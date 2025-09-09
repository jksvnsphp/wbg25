<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\OfferQuotation;
use App\Models\OfferTender;
use App\Models\products;
use App\Models\shipping_rate_tables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class UICartController extends Controller
{
    //
    function getShippingCostByCountry($rate_id, $countryCode)
    {
        try {
            // Fetch shipping rate table with cost and regions
            $shippingRates = shipping_rate_tables::with([
                'shipping_rate_costs.shipping_regions.region.countries',
                'shipping_rate_costs.shipping_regions.country'
            ])->where('id', $rate_id)->first();

            if (!$shippingRates) {
                return 'Shipping rate table not found';
            }

            // Initialize shipping cost
            $shippingCost = null;

            foreach ($shippingRates->shipping_rate_costs as $cost) {
                foreach ($cost->shipping_regions as $region) {
                    // Case 1: Worldwide shipping
                    if ($region->isWorldwide) {
                        $shippingCost = $cost->cost;
                        break 2;
                    }

                    // Case 2: Region-specific shipping
                    // Check if the region is matched with the user's country or region
                    if (isset($region->region)) {
                        // dd($region->region);
                        if (isset($region->region->countries) && $region->region->countries != null) {
                            $countriesInRegion = $region->region->countries;
                            if ($countriesInRegion && $countriesInRegion->pluck('iso2')->contains($countryCode)) {
                                $shippingCost = $cost->cost;
                                break 2;
                            }
                        }
                    }

                    // Case 3: Country-specific shipping
                    if (isset($region->country) && isset($region->country->iso2) && $region->country->iso2 === $countryCode) {
                        $shippingCost = $cost->cost;
                        break 2;
                    }
                }
            }

            if ($shippingCost) {
                return [
                    'country' => $countryCode,
                    'shipping_cost' => $shippingCost,
                ];
            } else {
                return [
                    'country' => $countryCode,
                    'message' => 'Shipping is not available for this country or region.',
                ];
            }
        } catch (\Exception $e) {
            return [
                'error' => 'Unable to fetch shipping details for this country.',
                'message' => $e->getMessage(),
            ];
        }
    }
    function getShippingCostByIp($rate_id)
    {
        try {
            // Get user IP address
            $userIp = request()->ip();
            if (filter_var($userIp, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                $response = Http::get("https://ipinfo.io/{$userIp}/json?token=1cbe42adf84123");
            } else {
                $countryCode = 'DE';
                return $this->getShippingCostByCountry($rate_id, $countryCode);
            }
            if ($response->successful()) {
                $data = $response->json();

                $countryCode = $data['country'];

                return $this->getShippingCostByCountry($rate_id, $countryCode);
            } else {
                return [
                    'error' => 'Unable to fetch location information from ipinfo.io',
                    'message' => $response->status(),
                ];
            }
        } catch (\Exception $e) {
            return [
                'error' => 'Unable to fetch location or shipping details.',
                'message' => $e->getMessage(),
            ];
        }
    }
    public function getShippingData($rate_id)
    {
        $shippingRates = shipping_rate_tables::with([
            'shipping_rate_costs.shipping_regions.region',
            'shipping_rate_costs.shipping_regions.country',
        ])->where('id', $rate_id)->get();
        $data = $shippingRates->map(function ($rate) {
            // Check if any shipping cost is worldwide
            $worldwideCost = $rate->shipping_rate_costs->flatMap(function ($cost) {
                return $cost->shipping_regions->map(function ($region) use ($cost) {
                    return $region->isWorldwide ? $cost->cost : null;
                });
            })->filter()->first(); // Get the first worldwide cost

            $regionsWithCost = $rate->shipping_rate_costs->flatMap(function ($cost) {
                return $cost->shipping_regions->map(function ($region) use ($cost) {
                    return !$region->isWorldwide && $region->region
                        ? ['name' => $region->region->name, 'cost' => $cost->cost]
                        : null;
                });
            })->filter()->unique()->values()->all();

            $countriesWithCost = $rate->shipping_rate_costs->flatMap(function ($cost) {
                return $cost->shipping_regions->map(function ($region) use ($cost) {
                    return !$region->isWorldwide && $region->country
                        ? ['name' => $region->country->name, 'cost' => $cost->cost]
                        : null;
                });
            })->filter()->unique()->values()->all();

            return [
                'shipping_rate_id' => $rate->id,
                'vendor_id' => $rate->vendor_id,
                'shipping_partner' => $rate->shipping_partner,
                'shipping_method' => $rate->shipping_method,
                'is_worldwide' => $worldwideCost ? ['status' => 'Worldwide', 'cost' => $worldwideCost] : null,
                'regions' => $regionsWithCost,
                'countries' => $countriesWithCost,
            ];
        });

        return $data;
    }
    
    
    public function index()
    {
        $id = Auth::user()->id ?? null;
        $quotationOffers = OfferQuotation::where('user_id', $id)->where('status', 'accept')->where('isDealClose', 0)->count();
        $tenderOffers = OfferTender::where('user_id', $id)->where('status', 'accept')->where('isDealClose', 0)->count();
        
        $carts = Cart::latest()->where('user_id', auth()->user()->id)->with('product.gallery', 'product.product_setting', 'product.vendor.company')->get();
        $groupedCarts = [];
        if ($carts) {
            foreach ($carts as $cart) {
                $cart->average_rating = number_format($cart->product->ratings()->avg('rate'));
                $cart->shippingData = $this->getShippingData($cart->product->rate_table_id);
                $cart->yourShippingCost = $this->getShippingCostByIp($cart->product->rate_table_id);
                $cart->isReturnAccept = isset($cart->product->product_setting->isReturnAccept);

                // Group by vendor
                $vendorId = $cart->product->vendor->ref_no ?? '';
                $groupedCarts[$vendorId]['vendor'] = $cart->product->vendor->company;
                $groupedCarts[$vendorId]['carts'][] = $cart;
            }
        }
        return view('external-user.shoping-cart', compact('groupedCarts', 'quotationOffers', 'tenderOffers'));
    }

    public function cartTender()
    {
        $id = Auth::user()->id ?? null;
        $tenderOffers = OfferTender::where('user_id', $id)->where('status', 'accept')->with('tender.vendor.company')->where('isDealClose', 0)->get();
        $quotationOffers = OfferQuotation::where('user_id', $id)->where('status', 'accept')->where('isDealClose', 0)->count();
        $cartOffers = Cart::where('user_id',$id)->count();
        $groupedCarts = [];
        if ($tenderOffers) {
            foreach ($tenderOffers as $cart) {
                $cart->average_rating = number_format($cart->ratings()->avg('rate'));
                $cart->shippingData = $this->getShippingData($cart->tender->rate_table_id);
                $cart->yourShippingCost = $this->getShippingCostByIp($cart->tender->rate_table_id);

                // Group by vendor
                $vendorId = $cart->tender->vendor->ref_no ?? '';
                $groupedCarts[$vendorId]['vendor'] = $cart->tender->vendor->company;
                $groupedCarts[$vendorId]['carts'][] = $cart;
            }
        }
        return view('external-user.shoping-cart-tender', compact('groupedCarts', 'quotationOffers','cartOffers'));
    }

    public function cartQuotation()
    {
        $id = Auth::user()->id ?? null;
        $tenderOffers = OfferTender::where('user_id', $id)->where('status', 'accept')->where('isDealClose', 0)->count();
        $quotationOffers = OfferQuotation::where('user_id', $id)->where('status', 'accept')->with('quotation.vendor.company')->where('isDealClose', 0)->get();
        $cartOffers = Cart::where('user_id',$id)->count();
        
        $groupedCarts = [];
        if ($quotationOffers) {
            foreach ($quotationOffers as $cart) {
                $cart->average_rating = number_format($cart->ratings()->avg('rate'));
                $vendorId = $cart->quotation->vendor->ref_no ?? '';
                $groupedCarts[$vendorId]['vendor'] = $cart->quotation->vendor->company;
                $groupedCarts[$vendorId]['carts'][] = $cart;
            }
        }
        return view('external-user.shoping-cart-quotation', compact('groupedCarts', 'tenderOffers','cartOffers'));
    }

    public function addToCart(Request $request)
    {
        if (isset(auth()->user()->id)) {
            //  dd($request->all());
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'variant' => 'nullable|array',
                'priceMultiply' => 'nullable',
            ]);
            $product = products::find($request->product_id);
            // Calculate price
            $qty = $request->quantity;
            if ($product->isMultiple == 0) {
                if ($qty >= $product->qtymin0 && $qty <= $product->qtymax0) {
                    $price = $product->price0;
                } elseif ($qty >= $product->qtymin1 && $qty <= $product->qtymax1) {
                    $price = $product->price1;
                } elseif ($qty >= $product->qtymin2 && $qty <= $product->qtymax2) {
                    $price = $product->price2;
                } else {
                    $price = 0;
                }
            } else {
                $price = $request->priceMultiply;
            }
            // Check if the product already exists in the cart
            if ($product->isMultiple == 0) {
                $existingCart = Cart::where('user_id', auth()->user()->id)->where('product_id', $request->product_id)
                    ->first();
            } else {
                $existingCart = Cart::where('user_id', auth()->user()->id)
                    ->where('product_id', $request->product_id)
                    ->where('variant', json_encode($request->variant))
                    ->first();
            }
            // dd($existingCart);
            if ($existingCart) {
                $existingCart->update(['quantity' => $request->quantity, 'price' => $price * $qty, 'qtyPrice' => $price]);
            } else {

                Cart::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $request->product_id,
                    'variant' => $request->variant ? $request->variant : null,
                    'quantity' => $request->quantity,
                    'price' => $price * $qty,
                    'qtyPrice' => $price,
                ]);
            }
            return response()->json(['success' => true, 'message' => 'Product added to cart']);
        } else {
            return response()->json(['success' => false, 'message' => 'Please logged in to use this!']);
        }
    }
    public function checkoutNow(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'variant' => 'nullable|array',
                'priceMultiply' => 'nullable',
            ]);
            $product = products::find($request->product_id);
            // Calculate price
            $qty = $request->quantity;
            if ($product->isMultiple == 0) {
                if ($qty >= $product->qtymin0 && $qty <= $product->qtymax0) {
                    $price = $product->price0;
                } elseif ($qty >= $product->qtymin1 && $qty <= $product->qtymax1) {
                    $price = $product->price1;
                } elseif ($qty >= $product->qtymin2 && $qty <= $product->qtymax2) {
                    $price = $product->price2;
                } else {
                    $price = 0;
                }
            } else {
                $price = $request->priceMultiply;
            }
            $product = products::where('id', $request->product_id)->with('vendor')->first();
            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Product not found']);
            }
            // Check if the product already exists in the cart
            if ($product->isMultiple == 0) {
                $existingCart = Cart::where('user_id', auth()->user()->id)->where('product_id', $request->product_id)
                    ->first();
            } else {
                $existingCart = Cart::where('user_id', auth()->user()->id)
                    ->where('product_id', $request->product_id)
                    ->where('variant', json_encode($request->variant))
                    ->first();
            }
            // dd($existingCart);
            if ($existingCart) {
                $existingCart->update(['quantity' => $request->quantity, 'price' => $price * $qty, 'qtyPrice' => $price]);
            } else {

                Cart::create([
                    'user_id' => auth()->user()->id,
                    'product_id' => $request->product_id,
                    'variant' => $request->variant ? $request->variant : null,
                    'quantity' => $request->quantity,
                    'price' => $price * $qty,
                    'qtyPrice' => $price,
                ]);
            }
            $url = route('checkout.product', $product->vendor->ref_no);
            return response()->json(['success' => true, 'message' => 'Now you are ready for checkout!', 'url' => $url]);
        } else {
            return response()->json(['success' => false, 'message' => 'You must be logged In!']);
        }
    }

    public function deleteCartItem($cartId)
    {
        $user_id = Auth::user()->id;
        $cart = Cart::where('id', $cartId)->where('user_id', $user_id)->first();
        if ($cart) {
            $cart->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Item removed from your cart.']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Item not found in your cart.']);
        }
    }
}
