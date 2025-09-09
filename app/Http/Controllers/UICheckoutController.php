<?php

namespace App\Http\Controllers;

use App\Models\bank_details;
use App\Models\Cart;
use App\Models\countries;
use App\Models\DeliveryAddress;
use App\Models\OfferQuotation;
use App\Models\OfferTender;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\products;
use App\Models\seller_package;
use App\Models\shipping_rate_tables;
use App\Models\states;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class UICheckoutController extends Controller
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
    public function index($ref_no)
    {

        $carts = Cart::latest()
            ->where('user_id', auth()->user()->id)
            ->with('product.product_setting', 'product.vendor.company')
            ->whereHas('product.vendor', function ($query) use ($ref_no) {
                $query->where('ref_no', $ref_no);
            })
            ->get();

        if (isset($carts) && count($carts) > 0) {
            foreach ($carts as $cart) {
                $cart->shippingData = $this->getShippingData($cart->product->rate_table_id);
                $cart->yourShippingCost = $this->getShippingCostByIp($cart->product->rate_table_id);
                if (isset($cart->product->product_setting->isReturnAccept)) {
                    $cart->isReturnAccept = true;
                } else {
                    $cart->isReturnAccept = false;
                }
            }
        } else {
            return redirect()->route('all.products')->with(['alert-type' => 'warning', 'message' => 'Please add some item in cart.']);
        }
        $vuser = User::where('ref_no', $ref_no)->first();
        $bankDetails = bank_details::where('vendor_id', $vuser->id)->first();
        if (!$bankDetails) {
            return redirect()->back()->with(['alert-type' => 'warning', 'message' => 'This seller don\'t have payment methods.']);
        }
        $myAddress = [];
        $deliveryAddress = DeliveryAddress::where('user_id', Auth::user()->id)->first();
        if ($deliveryAddress) {
            $myAddress = [
                'user_id' => $deliveryAddress->user_id,
                'country' => $deliveryAddress->country,
                'state' => $deliveryAddress->state,
                'city' => $deliveryAddress->city,
                'postal_code' => $deliveryAddress->postal_code,
                'phone_number' => $deliveryAddress->phone_number,
                'street' => $deliveryAddress->street,
                'house_no' => $deliveryAddress->house_no,
                'country_name' => countries::where('id', $deliveryAddress->country)->first()->name,
                'state_name' => states::where('id', $deliveryAddress->state)->first()->name,
            ];
        } else {
            $user = User::where('id', Auth::user()->id)->first();

            $myAddress = [
                'user_id' => $user->id,
                'country' => $user->country,
                'state' => $user->state,
                'city' => $user->city,
                'postal_code' => $user->zip,
                'phone_number' => $user->phone,
                'street' => $user->street,
                'house_no' => $user->house_no,
                'country_name' => countries::where('id', $user->country)->first()->name,
                'state_name' => states::where('id', $user->state)->first()->name,
            ];
        }
        $user = User::where('id', Auth::user()->id)->first();


        $billingAddress = [
            'user_id' => $user->id,
            'name' => $user->first_name . ' ' . $user->last_name,
            'email' => $user->email,
            'country' => $user->country,
            'state' => $user->state,
            'city' => $user->city,
            'postal_code' => $user->zip,
            'phone_number' => $user->phone,
            'street' => $user->street,
            'house_no' => $user->house_no,
            'country_name' => countries::where('id', $user->country)->first()->name,
            'state_name' => states::where('id', $user->state)->first()->name,
        ];
        return view("external-user.checkout", compact('carts', 'user', 'myAddress', 'billingAddress', 'bankDetails'));
    }

    public function checkoutTender($ref_no)
    {

        $id = Auth::user()->id ?? null;
        $tenderOffers = OfferTender::where('user_id', $id)
            ->where('status', 'accept')
            ->with('tender.vendor.company')
            ->whereHas('tender.vendor', function ($query) use ($ref_no) {
                $query->where('ref_no', $ref_no);
            })
            ->where('isDealClose', 0)->get();



        if ($tenderOffers) {
            foreach ($tenderOffers as $cart) {
                $cart->average_rating = number_format($cart->ratings()->avg('rate'));
                $cart->shippingData = $this->getShippingData($cart->tender->rate_table_id);
                $cart->yourShippingCost = $this->getShippingCostByIp($cart->tender->rate_table_id);

                // Group by vendor
                $vendorId = $cart->tender->vendor->ref_no ?? '';
                $cart['vendor'] = $cart->tender->vendor->company;
            }
        }
        // dd($tenderOffers);
        $vuser = User::where('ref_no', $ref_no)->first();
        $bankDetails = bank_details::where('vendor_id', $vuser->id)->first();
        if (!$bankDetails) {
            return redirect()->back()->with(['alert-type' => 'warning', 'message' => 'This seller don\'t have payment methods.']);
        }
        $myAddress = [];
        $deliveryAddress = DeliveryAddress::where('user_id', Auth::user()->id)->first();
        if ($deliveryAddress) {
            $myAddress = [
                'user_id' => $deliveryAddress->user_id,
                'country' => $deliveryAddress->country,
                'state' => $deliveryAddress->state,
                'city' => $deliveryAddress->city,
                'postal_code' => $deliveryAddress->postal_code,
                'phone_number' => $deliveryAddress->phone_number,
                'street' => $deliveryAddress->street,
                'house_no' => $deliveryAddress->house_no,
                'country_name' => countries::where('id', $deliveryAddress->country)->first()->name,
                'state_name' => states::where('id', $deliveryAddress->state)->first()->name,
            ];
        } else {
            $user = User::where('id', Auth::user()->id)->first();

            $myAddress = [
                'user_id' => $user->id,
                'country' => $user->country,
                'state' => $user->state,
                'city' => $user->city,
                'postal_code' => $user->zip,
                'phone_number' => $user->phone,
                'street' => $user->street,
                'house_no' => $user->house_no,
                'country_name' => countries::where('id', $user->country)->first()->name,
                'state_name' => states::where('id', $user->state)->first()->name,
            ];
        }
        $user = User::where('id', Auth::user()->id)->first();


        $billingAddress = [
            'user_id' => $user->id,
            'name' => $user->first_name . ' ' . $user->last_name,
            'email' => $user->email,
            'country' => $user->country,
            'state' => $user->state,
            'city' => $user->city,
            'postal_code' => $user->zip,
            'phone_number' => $user->phone,
            'street' => $user->street,
            'house_no' => $user->house_no,
            'country_name' => countries::where('id', $user->country)->first()->name,
            'state_name' => states::where('id', $user->state)->first()->name,
        ];
        $groupedCarts = $tenderOffers;
        return view("external-user.checkout-tender", compact('groupedCarts', 'user', 'myAddress', 'billingAddress', 'bankDetails'));
    }

    public function checkoutQuotation($ref_no)
    {

        $id = Auth::user()->id ?? null;
        $quotationOffers = OfferQuotation::where('user_id', $id)
            ->where('status', 'accept')
            ->with('quotation.vendor.company')
            ->whereHas('quotation.vendor', function ($query) use ($ref_no) {
                $query->where('ref_no', $ref_no);
            })
            ->where('isDealClose', 0)->get();



        if ($quotationOffers) {
            foreach ($quotationOffers as $cart) {
                $cart->average_rating = number_format($cart->ratings()->avg('rate'));
                
                $vendorId = $cart->quotation->vendor->ref_no ?? '';
                $cart['vendor'] = $cart->quotation->vendor->company;
            }
        }
        // dd($tenderOffers);
        $vuser = User::where('ref_no', $ref_no)->first();
        $bankDetails = bank_details::where('vendor_id', $vuser->id)->first();
        if (!$bankDetails) {
            return redirect()->back()->with(['alert-type' => 'warning', 'message' => 'This seller don\'t have payment methods.']);
        }
        $myAddress = [];
        $deliveryAddress = DeliveryAddress::where('user_id', Auth::user()->id)->first();
        if ($deliveryAddress) {
            $myAddress = [
                'user_id' => $deliveryAddress->user_id,
                'country' => $deliveryAddress->country,
                'state' => $deliveryAddress->state,
                'city' => $deliveryAddress->city,
                'postal_code' => $deliveryAddress->postal_code,
                'phone_number' => $deliveryAddress->phone_number,
                'street' => $deliveryAddress->street,
                'house_no' => $deliveryAddress->house_no,
                'country_name' => countries::where('id', $deliveryAddress->country)->first()->name,
                'state_name' => states::where('id', $deliveryAddress->state)->first()->name,
            ];
        } else {
            $user = User::where('id', Auth::user()->id)->first();

            $myAddress = [
                'user_id' => $user->id,
                'country' => $user->country,
                'state' => $user->state,
                'city' => $user->city,
                'postal_code' => $user->zip,
                'phone_number' => $user->phone,
                'street' => $user->street,
                'house_no' => $user->house_no,
                'country_name' => countries::where('id', $user->country)->first()->name,
                'state_name' => states::where('id', $user->state)->first()->name,
            ];
        }
        $user = User::where('id', Auth::user()->id)->first();


        $billingAddress = [
            'user_id' => $user->id,
            'name' => $user->first_name . ' ' . $user->last_name,
            'email' => $user->email,
            'country' => $user->country,
            'state' => $user->state,
            'city' => $user->city,
            'postal_code' => $user->zip,
            'phone_number' => $user->phone,
            'street' => $user->street,
            'house_no' => $user->house_no,
            'country_name' => countries::where('id', $user->country)->first()->name,
            'state_name' => states::where('id', $user->state)->first()->name,
        ];
        $groupedCarts = $quotationOffers;
        return view("external-user.checkout-quotation", compact('groupedCarts', 'user', 'myAddress', 'billingAddress', 'bankDetails'));
    }

    public function orderNow(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'payment' => ['required'],
            'address' => ['required']
        ]);
        if ($validate->fails()) {
            // dd($validate->errors());
            return redirect()->back()->withErrors($validate->errors())->with(['alert-type' => 'error', 'message' => 'Something went to wrong!']);
        } else {
            $user = User::where('id', Auth::user()->id)->first();
            $carts = Cart::where('user_id', Auth::user()->id)->with('product.gallery')->get();

            $totalShippingCost = 0;
            $totalPrice = 0;
            if ($carts) {
                foreach ($carts as $cart) {
                    $cart->shippingData = $this->getShippingData($cart->product->rate_table_id);
                    $cart->yourShippingCost = $this->getShippingCostByIp($cart->product->rate_table_id);
                    $totalPrice += $cart->price;
                    if (isset($cart->yourShippingCost['country'])) {
                        $totalShippingCost += $cart->yourShippingCost['shipping_cost'] ?? 0;
                    }
                }
            }

            if ($totalPrice > 0) {
                if ($request->payment == "paypal") {
                    $order = new Order();
                    $order->user_id = Auth::user()->id;
                    $order->order_number = Order::generateOrderNumber();
                    $order->order_status = 'processing';
                    $order->shipping_cost = $totalShippingCost;
                    $order->total_amount = $totalPrice;
                    $order->payment_status = 'processing';
                    $order->payment_method = $request->payment;
                    $order->shipping_address = $request->address;
                    $order->billing_address = $request->billing_address;
                    $order->save();
                    Session::put('order_number', $order->order_number);
                    foreach ($carts as $cart) {
                        $orderItem = new OrderItem();
                        $orderItem->order_id = $order->id;
                        $orderItem->product_id = $cart->product_id;
                        $orderItem->product_name = $cart->product->name ?? 'No Name';
                        $orderItem->variant = json_encode($cart->variant);
                        $orderItem->quantity = $cart->quantity;
                        $orderItem->price = $cart->qtyPrice;
                        $orderItem->total_price = $cart->price;
                        $orderItem->save();
                    }

                    $amount = $totalShippingCost + $totalPrice;
                    $provider = new PayPalClient;
                    $provider->setApiCredentials(config('paypal'));
                    $token = $provider->getAccessToken();
                    $provider->setAccessToken($token);

                    $response = $provider->createOrder([
                        "intent" => "CAPTURE",
                        "application_context" => [
                            "return_url" => route('order.paypal.status'),
                            "cancel_url" => route('order.paypal.status'),
                        ],
                        "purchase_units" => [
                            0 => [
                                "amount" => [
                                    "currency_code" => "EUR",
                                    "value" => $amount
                                ]
                            ]
                        ]
                    ]);

                    if (isset($response['id']) && $response['id'] != null) {
                        foreach ($response['links'] as $link) {
                            if ($link['rel'] == 'approve') {
                                return redirect()->away($link['href']);
                            }
                        }
                        return back()->with(['alert-type' => 'error', 'message' => 'Something went wrong.']);
                    } else {
                        return back()->with(['alert-type' => 'error', 'message' => $response['message'] ?? 'Something went wrong.']);
                    }
                } else {
                    $order = new Order();
                    $order->user_id = Auth::user()->id;
                    $order->order_number = Order::generateOrderNumber();
                    $order->order_status = 'processing';
                    $order->shipping_cost = $totalShippingCost;
                    $order->total_amount = $totalPrice;
                    $order->payment_status = 'pending';
                    $order->payment_method = $request->payment;
                    $order->shipping_address = $request->address;
                    $order->billing_address = $request->billing_address;
                    $order->save();
                    Session::put('order_number', $order->order_number);
                    $shippingAddress = json_decode($order->shipping_address, true);
                    $formattedAddress = implode(', ', array_filter([
                        $shippingAddress['street'] ?? null,
                        $shippingAddress['house_no'] ?? null,
                        $shippingAddress['city'] ?? null,
                        $shippingAddress['state_name'] ?? null,
                        $shippingAddress['country_name'] ?? null,
                        $shippingAddress['postal_code'] ?? null,
                        $shippingAddress['phone_number'] ?? null
                    ]));
                    $orderItems = [];

                    foreach ($carts as $cart) {

                        $orderItem = new OrderItem();
                        $orderItem->order_id = $order->id;
                        $orderItem->product_id = $cart->product_id;
                        $orderItem->product_name = $cart->product->name ?? 'No Name';
                        $orderItem->variant = json_encode($cart->variant);
                        $orderItem->quantity = $cart->quantity;
                        $orderItem->price = $cart->qtyPrice;
                        $orderItem->total_price = $cart->price;
                        $orderItem->save();
                        // filter product image
                        $cartVariant = is_string($orderItem->variant)
                            ? json_decode($orderItem->variant, true)
                            : $orderItem->variant;
                        $variants = is_string($cart->product->variants)
                            ? json_decode($cart->product->variants, true)
                            : $cart->product->variants;
                        $variants = is_array($variants) ? $variants : [];
                        $allImages = [];
                        foreach ($variants as $variant) {
                            if (
                                isset($variant['attributes']) &&
                                $variant['attributes'] == $cartVariant
                            ) {
                                if (
                                    !empty($variant['images']) &&
                                    is_array($variant['images'])
                                ) {
                                    $allImages = array_merge(
                                        $allImages,
                                        $variant['images'],
                                    );

                                    break;
                                }
                            }
                        }

                        // Pick the first valid image
                        $previewImage = !empty($allImages)
                            ? asset('uploads/products/' . $allImages[0])
                            : null;

                        // Fallback to gallery or placeholder
                        if (empty($previewImage)) {
                            $previewImage =
                                isset($cart->product->gallery[0]->image) &&
                                !empty($cart->product->gallery[0]->image)
                                ? asset(
                                    'uploads/products/gallery/' .
                                        $cart->product->gallery[0]->image,
                                )
                                : 'https://placehold.co/600x400';
                        }
                        $orderItem->image = $previewImage;
                        $orderItem->slug = route('product.detail', $cart->product->slug);

                        $orderItems[] = $orderItem;
                        $getVendor = products::where('id', $cart->product_id)->with('vendor')->first();
                        $seller_data = [
                            'seller_name' => isset($getVendor->vendor->first_name) ? $getVendor->vendor->first_name : "",
                            'order_number' => $order->order_number,
                            'total_amount' => $order->total_amount,
                            'shipping_address' => $formattedAddress,
                            'order_items' => $orderItems,
                            'payment_method' => $order->payment_method,
                            'shipping_cost' => $order->shipping_cost,
                            'buyer_name' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                            'buyer_email' => Auth::user()->email,
                        ];
                        if (isset($getVendor->vendor->email)) {
                            $seller_email = $getVendor->vendor->email;
                            Mail::send('mail.order-to-seller', $seller_data, function ($message) use ($seller_email) {
                                $message->to($seller_email)
                                    ->subject('Order Confirmation!');
                            });
                        }
                    }

                    $data = [
                        'user_name' => Auth::user()->first_name,
                        'order_number' => $order->order_number,
                        'total_amount' => $order->total_amount,
                        'shipping_address' => $formattedAddress,
                        'order_items' => $orderItems,
                        'payment_method' => $order->payment_method,
                        'shipping_cost' => $order->shipping_cost,
                    ];
                    $email = Auth::user()->email;
                    Mail::send('mail.order-confirmed', $data, function ($message) use ($email) {
                        $message->to($email)
                            ->subject('Your Product Has Been Placed!');
                    });

                    Cart::where('user_id', Auth::user()->id)->delete();
                    return redirect()->route('order.placed')->with(['alert-type' => 'success', 'message' => 'Your order has been placed.']);
                }
            }
        }
    }

    public function orderNow2(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'vendor_id' => ['required', 'exists:users,id'],
            'payment' => ['required'],
            'address' => ['required']
        ]);
        if ($validate->fails()) {
            // dd($validate->errors());
            return redirect()->back()->withErrors($validate->errors())->with(['alert-type' => 'error', 'message' => 'Something went to wrong!']);
        } else {
            $vendor = User::where('id', $request->vendor_id)->with('payment_info')->first();
            if (!$vendor) {
                return redirect()->back()->withErrors(['Vendor not found'])->with(['alert-type' => 'error', 'message' => 'Vendor not found']);
            }
            $carts = Cart::where('user_id', Auth::user()->id)
                ->whereHas('product.vendor', function ($query) use ($vendor) {
                    $query->where('ref_no', $vendor->ref_no);
                })
                ->with('product.gallery')->get();

            $totalShippingCost = 0;
            $totalPrice = 0;
            if ($carts) {
                foreach ($carts as $cart) {
                    $cart->shippingData = $this->getShippingData($cart->product->rate_table_id);
                    $cart->yourShippingCost = $this->getShippingCostByIp($cart->product->rate_table_id);
                    $totalPrice += $cart->price;
                    if (isset($cart->yourShippingCost['country'])) {
                        $totalShippingCost += $cart->yourShippingCost['shipping_cost'] ?? 0;
                    }
                }
            }

            if ($totalPrice > 0) {
                $order = new Order();
                $order->user_id = Auth::user()->id;
                $order->order_number = Order::generateOrderNumber();
                $order->order_status = 'processing';
                $order->shipping_cost = $totalShippingCost;
                $order->total_amount = $totalPrice;
                $order->payment_status = 'payment_check';
                $order->payment_method = $request->payment;
                $order->payment_id = uniqid('NOPAYMENT_');
                $order->shipping_address = $request->address;
                $order->billing_address = $request->billing_address;
                $order->save();

                Session::put('order_number', $order->order_number);
                $shippingAddress = json_decode($order->shipping_address, true);
                $formattedAddress = implode(', ', array_filter([
                    $shippingAddress['street'] ?? null,
                    $shippingAddress['house_no'] ?? null,
                    $shippingAddress['city'] ?? null,
                    $shippingAddress['state_name'] ?? null,
                    $shippingAddress['country_name'] ?? null,
                    $shippingAddress['postal_code'] ?? null,
                    $shippingAddress['phone_number'] ?? null
                ]));
                $orderItems = [];

                foreach ($carts as $cart) {

                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $cart->product_id;
                    $orderItem->product_name = $cart->product->name ?? 'No Name';
                    $orderItem->variant = json_encode($cart->variant);
                    $orderItem->quantity = $cart->quantity;
                    $orderItem->price = $cart->qtyPrice;
                    $orderItem->total_price = $cart->price;
                    $orderItem->save();
                    // filter product image
                    $cartVariant = is_string($orderItem->variant)
                        ? json_decode($orderItem->variant, true)
                        : $orderItem->variant;
                    $variants = is_string($cart->product->variants)
                        ? json_decode($cart->product->variants, true)
                        : $cart->product->variants;
                    $variants = is_array($variants) ? $variants : [];
                    $allImages = [];
                    foreach ($variants as $variant) {
                        if (
                            isset($variant['attributes']) &&
                            $variant['attributes'] == $cartVariant
                        ) {
                            if (
                                !empty($variant['images']) &&
                                is_array($variant['images'])
                            ) {
                                $allImages = array_merge(
                                    $allImages,
                                    $variant['images'],
                                );

                                break;
                            }
                        }
                    }

                    // Pick the first valid image
                    $previewImage = !empty($allImages)
                        ? asset('uploads/products/' . $allImages[0])
                        : null;

                    // Fallback to gallery or placeholder
                    if (empty($previewImage)) {
                        $previewImage =
                            isset($cart->product->gallery[0]->image) &&
                            !empty($cart->product->gallery[0]->image)
                            ? asset(
                                'uploads/products/gallery/' .
                                    $cart->product->gallery[0]->image,
                            )
                            : 'https://placehold.co/600x400';
                    }
                    $orderItem->image = $previewImage;
                    $orderItem->slug = route('product.detail', $cart->product->slug);

                    $orderItems[] = $orderItem;
                    $getVendor = products::where('id', $cart->product_id)->with('vendor')->first();
                    $seller_data = [
                        'seller_name' => isset($getVendor->vendor->first_name) ? $getVendor->vendor->first_name : "",
                        'order_number' => $order->order_number,
                        'total_amount' => $order->total_amount,
                        'shipping_address' => $formattedAddress,
                        'order_items' => $orderItems,
                        'payment_method' => $order->payment_method,
                        'shipping_cost' => $order->shipping_cost,
                        'buyer_name' => Auth::user()->first_name . ' ' . Auth::user()->last_name,
                        'buyer_email' => Auth::user()->email,
                    ];
                    if (isset($getVendor->vendor->email)) {
                        $seller_email = $getVendor->vendor->email;
                        Mail::send('mail.order-to-seller', $seller_data, function ($message) use ($seller_email) {
                            $message->to($seller_email)
                                ->subject('Order Confirmation!');
                        });
                    }
                }
                $paymentInfo = [];
                if ($request->payment == "paypal") {
                    $paymentInfo = [
                        'payment method' => 'PayPal',
                        'paypal email' => $vendor->payment_info->email ?? '',
                    ];
                } elseif ($request->payment == "gpay") {
                    $paymentInfo = [
                        'payment method' => 'Google Pay',
                        'upi id' => $vendor->payment_info->upi_google ?? '',
                    ];
                } elseif ($request->payment == "other") {
                    $paymentInfo = [
                        'payment method' => $vendor->payment_info->other_method_name ?? '',
                        'method id' => $vendor->payment_info->other_value ?? '',
                    ];
                } else {
                    $paymentInfo = [
                        'payment method' => 'Bank',
                        'bank name' => $vendor->payment_info->bank_name ?? '',
                        'account holder' => $vendor->payment_info->account_holder ?? '',
                        'iban' => $vendor->payment_info->iban ?? '',
                        'bic' => $vendor->payment_info->bic ?? '',
                        'country' => $vendor->payment_info->country ?? '',
                    ];
                }
                $data = [
                    'user_name' => Auth::user()->first_name,
                    'order_number' => $order->order_number,
                    'seller_name' => $vendor->first_name ?? '' . $vendor->last_name ?? '',
                    'seller_phone' => $vendor->phone ?? '',
                    'seller_email' => $vendor->email ?? '',
                    'total_amount' => $order->total_amount,
                    'shipping_address' => $formattedAddress,
                    'order_items' => $orderItems,
                    'payment_method' => $order->payment_method,
                    'paymentInfo' => $paymentInfo,
                    'shipping_cost' => $order->shipping_cost,
                ];
                $email = Auth::user()->email;

                Mail::send('mail.order-confirmed2', $data, function ($message) use ($email) {
                    $message->to($email)
                        ->subject('Your Product Has Been Placed For Payment!');
                });

                Cart::where('user_id', Auth::user()->id)
                    ->whereHas('product.vendor', function ($query) use ($vendor) {
                        $query->where('ref_no', $vendor->ref_no);
                    })
                    ->delete();
                if (Auth::user()->account_type == "seller") {
                    return redirect()->route('order.placed')->with(['alert-type' => 'success', 'message' => 'Your order has been placed.']);
                } else {
                    return redirect()->route('order.placed2')->with(['alert-type' => 'success', 'message' => 'Your order has been placed.']);
                }
            }
        }
    }

    public function orderNowTender(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'vendor_id' => ['required', 'exists:users,id'],
            'payment' => ['required'],
            'address' => ['required']
        ]);
        if ($validate->fails()) {
            // dd($validate->errors());
            return redirect()->back()->withErrors($validate->errors())->with(['alert-type' => 'error', 'message' => 'Something went to wrong!']);
        } else {
            $vendor = User::where('id', $request->vendor_id)->with('payment_info')->first();
            if (!$vendor) {
                return redirect()->back()->withErrors(['Vendor not found'])->with(['alert-type' => 'error', 'message' => 'Vendor not found']);
            }
            $id = Auth::user()->id ?? null;
            $tenderOffers = OfferTender::where('user_id', $id)
                ->where('status', 'accept')
                ->with('tender.vendor.company')
                ->whereHas('tender.vendor', function ($query) use ($vendor) {
                    $query->where('ref_no', $vendor->ref_no);
                })
                ->where('isDealClose', 0)->get();

            $totalShippingCost = 0;
            $totalPrice = 0;

            $paymentInfo = [];
            if ($request->payment == "paypal") {
                $paymentInfo = [
                    'payment method' => 'PayPal',
                    'paypal email' => $vendor->payment_info->email ?? '',
                ];
            } elseif ($request->payment == "gpay") {
                $paymentInfo = [
                    'payment method' => 'Google Pay',
                    'upi id' => $vendor->payment_info->upi_google ?? '',
                ];
            } elseif ($request->payment == "other") {
                $paymentInfo = [
                    'payment method' => $vendor->payment_info->other_method_name ?? '',
                    'method id' => $vendor->payment_info->other_value ?? '',
                ];
            } else {
                $paymentInfo = [
                    'payment method' => 'Bank',
                    'bank name' => $vendor->payment_info->bank_name ?? '',
                    'account holder' => $vendor->payment_info->account_holder ?? '',
                    'iban' => $vendor->payment_info->iban ?? '',
                    'bic' => $vendor->payment_info->bic ?? '',
                    'country' => $vendor->payment_info->country ?? '',
                ];
            }
            $shippingAddress = json_decode($request->address, true);
            $formattedAddress = implode(', ', array_filter([
                $shippingAddress['street'] ?? null,
                $shippingAddress['house_no'] ?? null,
                $shippingAddress['city'] ?? null,
                $shippingAddress['state_name'] ?? null,
                $shippingAddress['country_name'] ?? null,
                $shippingAddress['postal_code'] ?? null,
                $shippingAddress['phone_number'] ?? null
            ]));
            $orderItems = [];

            $total_price = 0;
            $total_shipping_price = 0;
            if ($tenderOffers) {
                foreach ($tenderOffers as $cart) {
                    
                    $yourShippingCost = $this->getShippingCostByIp($cart->tender->rate_table_id);
                    $price = $cart->offer_price;
                    $total_price += $cart->offer_price;
                    if (isset($yourShippingCost['country'])) {
                        $totalShippingCost = $yourShippingCost['shipping_cost'] ?? 0;
                        $total_shipping_price += $yourShippingCost['shipping_cost'] ?? 0;
                    }
                    $cart->shipping_cost = $totalShippingCost;
                    $cart->total_payment = $price + $totalShippingCost;
                    $cart->payment_info = json_encode($paymentInfo);
                    $cart->shipping_address = $request->address;
                    $cart->isDealClose = 1;
                    $cart->save();
                    $orderItems[] = $cart;
                }
            }

           
                $data = [
                    'user_name' => Auth::user()->first_name,
                    'seller_name' => $vendor->first_name ?? '' . $vendor->last_name ?? '',
                    'seller_phone' => $vendor->phone ?? '',
                    'seller_email' => $vendor->email ?? '',
                    'total_amount' => $total_price,
                    'shipping_address' => $formattedAddress,
                    'order_items' => $orderItems,
                    'payment_method' => $request->payment,
                    'paymentInfo' => $paymentInfo,
                    'shipping_cost' => $total_shipping_price,
                ];
                $email = Auth::user()->email;

                // Mail::send('mail.order-tender-confirmed2', $data, function ($message) use ($email) {
                //     $message->to($email)
                //         ->subject('Your Tender Deal Send For Payment!');
                // });
                
                if (Auth::user()->account_type == "seller") {
                    session()->flash('success', 'Congratulation, Your Tender deal ready for payment!');
                    return redirect()->route('seller.success.gallery');
                } else {
                    session()->flash('success', 'Congratulation, Your Tender deal ready for payment!');
                    return redirect()->route('buyer.success')->with(['alert-type' => 'success', 'message' => 'Congratulation, Your Tender deal ready for payment!']);
                }
            
        }
    }

    public function orderNowQuotation(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'vendor_id' => ['required', 'exists:users,id'],
            'payment' => ['required'],
            'address' => ['required']
        ]);
        if ($validate->fails()) {
            // dd($validate->errors());
            return redirect()->back()->withErrors($validate->errors())->with(['alert-type' => 'error', 'message' => 'Something went to wrong!']);
        } else {
            $vendor = User::where('id', $request->vendor_id)->with('payment_info')->first();
            if (!$vendor) {
                return redirect()->back()->withErrors(['Vendor not found'])->with(['alert-type' => 'error', 'message' => 'Vendor not found']);
            }
            $id = Auth::user()->id ?? null;
            $tenderOffers = OfferQuotation::where('user_id', $id)
                ->where('status', 'accept')
                ->with('quotation.vendor.company')
                ->whereHas('quotation.vendor', function ($query) use ($vendor) {
                    $query->where('ref_no', $vendor->ref_no);
                })
                ->where('isDealClose', 0)->get();

            $totalShippingCost = 0;
            $totalPrice = 0;

            $paymentInfo = [];
            if ($request->payment == "paypal") {
                $paymentInfo = [
                    'payment method' => 'PayPal',
                    'paypal email' => $vendor->payment_info->email ?? '',
                ];
            } elseif ($request->payment == "gpay") {
                $paymentInfo = [
                    'payment method' => 'Google Pay',
                    'upi id' => $vendor->payment_info->upi_google ?? '',
                ];
            } elseif ($request->payment == "other") {
                $paymentInfo = [
                    'payment method' => $vendor->payment_info->other_method_name ?? '',
                    'method id' => $vendor->payment_info->other_value ?? '',
                ];
            } else {
                $paymentInfo = [
                    'payment method' => 'Bank',
                    'bank name' => $vendor->payment_info->bank_name ?? '',
                    'account holder' => $vendor->payment_info->account_holder ?? '',
                    'iban' => $vendor->payment_info->iban ?? '',
                    'bic' => $vendor->payment_info->bic ?? '',
                    'country' => $vendor->payment_info->country ?? '',
                ];
            }
            $shippingAddress = json_decode($request->address, true);
            $formattedAddress = implode(', ', array_filter([
                $shippingAddress['street'] ?? null,
                $shippingAddress['house_no'] ?? null,
                $shippingAddress['city'] ?? null,
                $shippingAddress['state_name'] ?? null,
                $shippingAddress['country_name'] ?? null,
                $shippingAddress['postal_code'] ?? null,
                $shippingAddress['phone_number'] ?? null
            ]));
            $orderItems = [];

            $total_price = 0;
            $total_shipping_price = 0;
            if ($tenderOffers) {
                foreach ($tenderOffers as $cart) {
                    $price = $cart->offer_price;
                    $total_price += $cart->offer_price;
                    $total_shipping_price=0;
                    $totalShippingCost=0;
                    
                    $cart->total_payment = $price + $totalShippingCost;
                    $cart->payment_info = json_encode($paymentInfo);
                    $cart->shipping_address = $request->address;
                    $cart->isDealClose = 1;
                    $cart->save();
                    $orderItems[] = $cart;
                }
            }

           
                $data = [
                    'user_name' => Auth::user()->first_name,
                    'seller_name' => $vendor->first_name ?? '' . $vendor->last_name ?? '',
                    'seller_phone' => $vendor->phone ?? '',
                    'seller_email' => $vendor->email ?? '',
                    'total_amount' => $total_price,
                    'shipping_address' => $formattedAddress,
                    'order_items' => $orderItems,
                    'payment_method' => $request->payment,
                    'paymentInfo' => $paymentInfo,
                    'shipping_cost' => $total_shipping_price,
                ];
                $email = Auth::user()->email;

                // Mail::send('mail.order-tender-confirmed2', $data, function ($message) use ($email) {
                //     $message->to($email)
                //         ->subject('Your Tender Deal Send For Payment!');
                // });
                
                if (Auth::user()->account_type == "seller") {
                    session()->flash('success', 'Congratulation, Your Quotation deal ready for payment!');
                    return redirect()->route('seller.success.gallery');
                } else {
                    session()->flash('success', 'Congratulation, Your Quotation deal ready for payment!');
                    return redirect()->route('buyer.success')->with(['alert-type' => 'success', 'message' => 'Congratulation, Your Quotation deal ready for payment!']);
                }
            
        }
    }

    public function payPalStatus(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);
        $order_number = Session::get('order_number');



        $response = $provider->capturePaymentOrder($request['token']);
        // dd($response);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $billingAddress = $response['purchase_units'][0]['shipping']['address'];
            $order = Order::where('order_number', $order_number)->first();
            $order->payment_id = $response['id'];
            $order->payment_status = 'paid';
            $order->billing_address = json_encode($billingAddress);
            $order->save();

            $orderItems = OrderItem::where('order_id', $order->id)->with('product.gallery')->get();
            foreach ($orderItems as $orderItem) {
                // filter product image
                $cartVariant = is_string($orderItem->variant)
                    ? json_decode($orderItem->variant, true)
                    : $orderItem->variant;
                $variants = is_string($orderItem->product->variants)
                    ? json_decode($orderItem->product->variants, true)
                    : $orderItem->product->variants;
                $variants = is_array($variants) ? $variants : [];
                $allImages = [];
                foreach ($variants as $variant) {
                    if (
                        isset($variant['attributes']) &&
                        $variant['attributes'] == $cartVariant
                    ) {
                        if (
                            !empty($variant['images']) &&
                            is_array($variant['images'])
                        ) {
                            $allImages = array_merge(
                                $allImages,
                                $variant['images'],
                            );

                            break;
                        }
                    }
                }

                // Pick the first valid image
                $previewImage = !empty($allImages)
                    ? asset('uploads/products/' . $allImages[0])
                    : null;

                // Fallback to gallery or placeholder
                if (empty($previewImage)) {
                    $previewImage =
                        isset($orderItem->product->gallery[0]->image) &&
                        !empty($orderItem->product->gallery[0]->image)
                        ? asset(
                            'uploads/products/gallery/' .
                                $orderItem->product->gallery[0]->image,
                        )
                        : 'https://placehold.co/600x400';
                }
                $orderItem->image = $previewImage;
                $orderItem->slug = route('product.detail', $orderItem->product->slug);
            }
            $shippingAddress = json_decode($order->shipping_address, true);
            $formattedAddress = implode(', ', array_filter([
                $shippingAddress['street'] ?? null,
                $shippingAddress['house_no'] ?? null,
                $shippingAddress['city'] ?? null,
                $shippingAddress['state_name'] ?? null,
                $shippingAddress['country_name'] ?? null,
                $shippingAddress['postal_code'] ?? null,
                $shippingAddress['phone_number'] ?? null
            ]));
            $data = [
                'user_name' => Auth::user()->first_name,
                'order_number' => $order->order_number,
                'total_amount' => $order->total_amount,
                'shipping_address' => $formattedAddress,
                'order_items' => $orderItems,
                'payment_method' => $order->payment_method,
                'shipping_cost' => $order->shipping_cost,
            ];
            $email = Auth::user()->email;
            Mail::send('mail.order-confirmed', $data, function ($message) use ($email) {
                $message->to($email)
                    ->subject('Your Product Has Been Placed!');
            });
            Cart::where('user_id', Auth::user()->id)->delete();
            return redirect()->route('order.placed')->with(['alert-type' => 'success', 'message' => 'Your order has been successfully placed.']);
        } else {
            // Payment failed
            return redirect()->route('home')->with(['alert-type' => 'error', 'message' => $response['message'] ?? 'Payment failed.']);
        }
    }
    public function orderPlaced()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $seller = User::where('id', $id)->first();
            $packageData = seller_package::latest()->where('seller_id', $seller->id)->with('package')->first();
            $orderNumber = Session::get('order_number');
            if (isset($orderNumber)) {
                $order = Order::where('user_id', Auth::user()->id)->where('order_number', $orderNumber)
                    ->whereHas('orderItems')
                    ->with('orderItems.product.gallery')
                    ->first();
                return view('seller-vendor.order-success', compact('seller', 'packageData', 'order'));
            } else {
                return redirect()->route('home');
            }
        } else {
            abort(403);
        }
    }
    public function orderPlaced2()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $buyer = User::where('id', $id)->first();
            $orderNumber = Session::get('order_number');
            if (isset($orderNumber)) {
                $order = Order::where('user_id', Auth::user()->id)->where('order_number', $orderNumber)
                    ->whereHas('orderItems')
                    ->with('orderItems.product.gallery')
                    ->first();
                return view('buyer-vendor.order-success', compact('buyer', 'order'));
            } else {
                return redirect()->route('home');
            }
        } else {
            abort(403);
        }
    }
}
