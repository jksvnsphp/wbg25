<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\BuildsSeoMeta;
use App\Models\category;
use App\Models\countries;
use App\Models\endsubcategory;
use App\Models\OrderItem;
use App\Models\parent_category;
use App\Models\products;
use App\Models\shipping_rate_tables;
use App\Models\states;
use App\Models\subcategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UserProductController extends Controller
{
    use BuildsSeoMeta;

    //
    function findCategoryBySlug($slug)
    {
        // Check the slug in each category level table
        $parentCategory = parent_category::where('status', "1")->where('slug', $slug)->first();
        if ($parentCategory) {
            return ['category' => $parentCategory, 'level' => 1];
        }

        $category = category::where('status', "1")->where('slug', $slug)->first();
        if ($category) {
            return ['category' => $category, 'level' => 2];
        }

        $childCategory = subcategory::where('status', "1")->where('slug', $slug)->first();
        if ($childCategory) {
            return ['category' => $childCategory, 'level' => 3];
        }

        $endChildCategory = endsubcategory::where('status', "1")->where('slug', $slug)->first();
        if ($endChildCategory) {
            return ['category' => $endChildCategory, 'level' => 4];
        }

        // If no match found
        return null;
    }

    private function premiumProducts($request)
    {
        $search = $request->input('q');

        $queryp = products::query()
            ->where('isList', 1)
            ->where(function ($query) {
                $query->where('isMultiple', 1)
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('isMultiple', 0)
                            ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()]);
                    });
            })
            ->whereHas('vendor', function ($q) {
                $q->where('account_type', 'seller')
                    ->whereHas('sellerPackageOne', function ($subQuery) {
                        $subQuery->whereNotNull('expire_at')
                            ->whereDate('expire_at', '>=', now())
                            ->whereHas('package', function ($packageQuery) {
                                $packageQuery->whereIn('type', ['platinum']);
                            });
                    });
            });

        $queryp->with(['vendor.sellerPackageOne.package', 'gallery'])
            ->orderByDesc('created_at');

        if ($request->has('q') && $request->input('q') != '') {
            $search = $request->input('q');
            $queryp->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        } else {
            $queryp->inRandomOrder();
        }
        return $queryp->limit(5)->get();
    }

    public function allproducts(Request $request, $slug = null)
    {
        $pageItem = 25;
        if ($slug != '' && $slug != null) {
            $result = $this->findCategoryBySlug($slug);
            if ($result != null) {
                $category = $result['category'];
                $level = $result['level'];
            } else {
                abort(404);
            }
        }

        $countries = countries::orderBy('name', 'ASC')->get();
        $categories = parent_category::where('status', "1")->orderBy('name', 'ASC')->get();

        $queryp = products::query()->whereHas('vendor', function ($q) {
            $q->where('account_type', 'seller');
        })->with(['vendor.sellerPackageOne' => function ($q) {
            $q->whereNotNull('expire_at');
        }]);

        $queryp = Products::query()
            ->where(function ($q) {
                $q->whereNull('duration_date')         // old products
                    ->orWhere('duration_date', '>=', now());
            })               // active products only
            ->where('totalQty', '>=', 0)             // not sold out
            ->whereHas('vendor', function ($q) {
                $q->where('account_type', 'seller');
            })
            ->with([
                'vendor.sellerPackageOne' => function ($q) {
                    $q->whereNotNull('expire_at')
                        ->where('expire_at', '>=', now()); // valid package only
                }
            ]);


        $queryp->where('isList', 1);

        // Apply order_type logic
        if ($request->filled('order_type')) {
            $orderType = $request->input('order_type');
            switch ($orderType) {
                case 'multiply':
                    $queryp->where('isMultiple', 1);
                    break;
                case 'single':
                    $queryp->where('isMultiple', 0)
                        ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()]);
                    break;
                case 'expired-soon':
                    $queryp->where('isMultiple', 0)
                        ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()]) // not already expired
                        ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) <= ?', [Carbon::now()->addDays(3)]); // expiring in next 3 days
                    break;
                case 'latest':
                    $queryp->orderBy('created_at', 'desc')
                        ->where(function ($query) {
                            $query->where('isMultiple', 1)
                                ->orWhere(function ($subQuery) {
                                    $subQuery->where('isMultiple', 0)
                                        ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()]);
                                });
                        });
                    break;
                case 'all':
                default:
                    $queryp->where(function ($query) {
                        $query->where('isMultiple', 1)
                            ->orWhere(function ($subQuery) {
                                $subQuery->where('isMultiple', 0)
                                    ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()]);
                            });
                    });
                    break;
            }
        } else {
            // Default condition if no order_type
            $queryp->where(function ($query) {
                $query->where('isMultiple', 1)
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('isMultiple', 0)
                            ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()]);
                    });
            });
        }

        // Existing filters
        if ($request->has('q') && $request->input('q') != "") {
            $search = $request->input('q');
            $queryp->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('sellerId') && $request->filled('sellerId')) {
            $sellerId = $request->sellerId ?? 0;
            $queryp->where('vendor_id', $sellerId);
        }

        if ($request->has('pageItem') && $request->filled('pageItem')) {
            $pageItem = $request->pageItem ?? 10;
        }

        if ($request->has('business_type') && $request->input('business_type') != "") {
            $business_type = $request->input('business_type');
            $queryp->whereHas('vendor.company', function ($query) use ($business_type) {
                $query->where('business_type', $business_type);
            });
        }

        if ($request->filled('parentcategory')) {
            $queryp->where('parent_category_id', $request->input('parentcategory'));
        }
        if ($request->filled('subcategory')) {
            $queryp->where('category_id', $request->input('subcategory'));
        }
        if ($request->filled('childcategory')) {
            $queryp->where('subcategory_id', $request->input('childcategory'));
        }
        if ($request->filled('endcategory')) {
            $queryp->where('childcategory_id', $request->input('endcategory'));
        }
        if ($request->filled('min_price')) {
            $queryp->where('minPrice', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $queryp->where('maxPrice', '<=', $request->input('max_price'));
        }

        // Category level-based filtering
        if (isset($level) && isset($category)) {
            switch ($level) {
                case 1:
                    $queryp->where('parent_category_id', $category->id);
                    break;
                case 2:
                    $queryp->where('category_id', $category->id);
                    break;
                case 3:
                    $queryp->where('subcategory_id', $category->id);
                    break;
                case 4:
                    $queryp->where('childcategory_id', $category->id);
                    break;
            }
        }

        if ($request->has('country')) {
            $country = $request->input('country');
            $countryData = countries::where('name', $country)->first();
            if ($countryData) {
                $queryp->whereHas('vendor', function ($query) use ($countryData) {
                    $query->where('country', $countryData->id);
                });
            }
        }

        // Fetch results
        $products = $queryp
            ->with('gallery', 'vendor.company', 'vendor.symbols', 'ratings')
            ->withSum(['orderItems as sold_quantity' => function ($q) {
                $q->where('payment_status', '!=', 'processing');
            }], 'quantity')
            ->get();

        // Sort by package type
        $sortedResults = $products->sortBy(function ($product) {
            $package = optional($product->vendor->sellerPackageOne)->package;
            $expireAt = optional($product->vendor->sellerPackageOne)->expire_at;
            if (!$package || now()->greaterThan($expireAt)) {
                return 9999;
            }
            return match ($package->type) {
                'platinum' => 1,
                'gold' => 2,
                'silver' => 3,
                'bronce' => 4,
                default => 5,
            };
        });

        foreach ($sortedResults as $product) {
            $product->country = $product->vendor->country
                ? countries::find($product->vendor->country)
                : null;
            $product->average_rating = number_format($product->vendor->ratings()->avg('rate') ?? 0);

            $totalQty = 0;

            if ($product->isMultiple == 1) {
                $variants = is_string($product->variants)
                    ? json_decode($product->variants, true)
                    : $product->variants;

                $variants = is_array($variants) ? $variants : [];

                foreach ($variants as $variant) {
                    $totalQty += isset($variant['quantity'])
                        ? (int) $variant['quantity']
                        : 0;
                }
            } else {
                $totalQty = $product->totalQty;
            }

            $product->totalQty = $totalQty;
            $product->remaining_qty = max($totalQty - $product->sold_quantity, 0);
        }

        // Paginate
        $filteredResults = $sortedResults->filter(function ($product) {
            return $product->remaining_qty > 0;
        })->values();

        // Pagination
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $items = $filteredResults
            ->slice(($currentPage - 1) * $pageItem, $pageItem)
            ->values();

        $products = new LengthAwarePaginator(
            $items,
            $filteredResults->count(),
            $pageItem,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]
        );

        $premiumProducts = $this->premiumProducts($request);

        // echo '<pre>';
        // print_r($products->toArray());
        // die;
        // echo '</pre>';

        return view('external-user.products', compact('categories', 'countries', 'products', 'premiumProducts'));
    }


    public function allTypeProducts(Request $request, $type)
    {
        $pageItem = 25;

        if ($request->has('pageItem') && $request->filled('pageItem')) {
            $pageItem = $request->pageItem;
        }

        $orderType = $request->input('order_type', 'all');

        $countries = countries::orderBy('name', 'ASC')->get();
        $categories = parent_category::where('status', "1")->orderBy('name', 'ASC')->get();

        $queryp = products::query()
            ->whereHas('vendor', function ($q) {
                $q->where('account_type', 'seller');
            })
            ->with(['vendor.sellerPackageOne' => function ($q) {
                $q->whereNotNull('expire_at');
            }]);

        // Type filters
        if ($type === "limited-offer") {
            $queryp->where('isLimitedOffer', 1);
        } elseif ($type === "daily-deal") {
            $queryp->where('isDailyDeal', 1);
        } elseif ($type === "bulk-buying") {
            $queryp->where('isBulkBuy', 1);
        } elseif ($type === "hot") {
            $queryp->where('isHotProduct', 1);
        }

        $retype = $type;

        // Order type filters
        $queryp->where(function ($query) use ($orderType) {
            if ($orderType === 'multiple') {
                $query->where('isMultiple', 1);
            } elseif ($orderType === 'single') {
                $query->where('isMultiple', 0)
                    ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()]);
            } elseif ($orderType === 'endest-soon') {
                $query->where('isMultiple', 0)
                    ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()])
                    ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) <= ?', [Carbon::now()->addDays(7)]);
            } else {
                $query->where('isMultiple', 1)
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('isMultiple', 0)
                            ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()]);
                    });
            }
        });

        // Other filters
        if ($request->has('q') && $request->input('q') != "") {
            $search = $request->input('q');
            $queryp->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('business_type') && $request->input('business_type') != "") {
            $queryp->whereHas('vendor.company', function ($query) use ($request) {
                $query->where('business_type', $request->input('business_type'));
            });
        }

        foreach (['parentcategory' => 'parent_category_id', 'subcategory' => 'category_id', 'childcategory' => 'subcategory_id', 'endcategory' => 'childcategory_id'] as $input => $column) {
            if ($request->has($input) && $request->input($input) != "") {
                $queryp->where($column, $request->input($input));
            }
        }

        if ($request->has('min_price') && $request->input('min_price') != '') {
            $queryp->where('minPrice', '>=', $request->input('min_price'));
        }

        if ($request->has('max_price') && $request->input('max_price') != "") {
            $queryp->where('maxPrice', '<=', $request->input('max_price'));
        }

        if ($request->has('country') && $request->input('country') != "") {
            $countryData = countries::where('name', $request->input('country'))->first();
            if ($countryData != null) {
                $queryp->whereHas('vendor', function ($query) use ($countryData) {
                    $query->where('country', $countryData->id);
                });
            }
        }

        // Product collection
        if ($orderType === 'latest') {
            $products = $queryp->with('gallery', 'vendor.company', 'vendor.symbols')
                ->orderByDesc('created_at')
                ->get();
        } else {
            $products = $queryp->with('gallery', 'vendor.company', 'vendor.symbols')
                ->inRandomOrder()
                ->get();
        }

        // Product collection
        if ($orderType === 'latest') {
            $products = $queryp->with('gallery', 'vendor.company', 'vendor.symbols')
                ->withSum(['orderItems as sold_quantity' => function ($q) {
                    $q->where('payment_status', '!=', 'processing');
                }], 'quantity')
                ->orderByDesc('created_at')
                ->get();
        } else {
            $products = $queryp->with('gallery', 'vendor.company', 'vendor.symbols')
                ->withSum(['orderItems as sold_quantity' => function ($q) {
                    $q->where('payment_status', '!=', 'processing');
                }], 'quantity')
                ->inRandomOrder()
                ->get();
        }

        // Sorting by seller package
        $sortedResults = $products->sortBy(function ($product) {
            $package = optional($product->vendor->sellerPackageOne)->package;
            $expireAt = optional($product->vendor->sellerPackageOne)->expire_at;
            if (!$package || now()->greaterThan($expireAt)) {
                return 9999;
            }
            return match ($package->type) {
                'platinum' => 1,
                'gold' => 2,
                'silver' => 3,
                'bronce' => 4,
                default => 5,
            };
        });

        // Enrich products
        foreach ($sortedResults as $product) {
            $product->country = $product->vendor->country
                ? countries::find($product->vendor->country)
                : null;
            $product->average_rating = number_format($product->vendor->ratings()->avg('rate') ?? 0);

            $totalQty = 0;

            if ($product->isMultiple == 1) {
                $variants = is_string($product->variants)
                    ? json_decode($product->variants, true)
                    : $product->variants;

                $variants = is_array($variants) ? $variants : [];

                foreach ($variants as $variant) {
                    $totalQty += isset($variant['quantity'])
                        ? (int) $variant['quantity']
                        : 0;
                }
            } else {
                $totalQty = $product->totalQty;
            }

            $product->totalQty = $totalQty;
            $product->remaining_qty = $totalQty - $product->sold_quantity;
        }

        // Paginate
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $items = $sortedResults->slice(($currentPage - 1) * $pageItem, $pageItem)->values();
        $paginatedResults = new LengthAwarePaginator($items, $sortedResults->count(), $pageItem, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'query' => $request->query(),
        ]);

        $products = $paginatedResults;
        $premiumProducts = $this->premiumProducts($request);

        return view('external-user.filter-products', compact('categories', 'countries', 'products', 'premiumProducts', 'type', 'retype'));
    }


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
                $countryCode = 'US';
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
                        ? ['name' => $region->country->name, 'cost' => $cost->cost, 'iso2' => $region->country->iso2, 'iso3' => $region->country->iso3, 'currency' => $region->country->currency, 'symbol' => $region->country->currency_symbol]
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

    public function productDetails($slug = null)
    {
        $product = products::where('isList', 1)->where('slug', $slug)->with('parentcategory', 'category', 'childcategory', 'endchildcategory', 'gallery', 'video', 'product_attributes.categoryAttribute.attribute', 'vendor.company', 'vendor.symbols', 'product_setting', 'rate_table.shipping_rate_costs.shipping_regions', 'vendor.payment_info', 'vendor.sellerPackageOne.package')->first();

        if (isset($product)) {
            $shippingData = $this->getShippingData($product->rate_table_id);
            $yourShippingCost = $this->getShippingCostByIp($product->rate_table_id);
            // dd($shippingData, $product->rate_table_id, $yourShippingCost);
            //use Carbon\Carbon;

            if ($product->isMultiple == 0) {

                $start = Carbon::parse($product->created_at);
                $end   = $start->copy()->addDays($product->duration);
                $now   = Carbon::now();

                $isExpired = $now->greaterThanOrEqualTo($end);

                // Auto unlist if expired
                if ($isExpired && $product->isList !== 0) {
                    $product->isList = 0;
                    $product->save();
                }

                // Remaining time calculation
                if ($isExpired) {
                    $product->remaining_time = 'Expired';
                } else {

                    $remainingSeconds = $now->diffInSeconds($end);

                    $days = intdiv($remainingSeconds, 86400);
                    $remainingSeconds %= 86400;

                    $hours = intdiv($remainingSeconds, 3600);
                    $remainingSeconds %= 3600;

                    $minutes = intdiv($remainingSeconds, 60);
                    $seconds = $remainingSeconds % 60;

                    if ($days > 0) {
                        $time = "{$days}d {$hours}h";
                    } elseif ($hours > 0) {
                        $time = "{$hours}h {$minutes}m";
                    } elseif ($minutes > 0) {
                        $time = "{$minutes}m {$seconds}s";
                    } else {
                        $time = "{$seconds}s";
                    }

                    $product->remaining_time = "Ends in {$time}";
                }

                $product->expiry_date = $end->format('Y M d h:i:s A');
                $product->is_expired  = $isExpired;
            } elseif ($product->isMultiple == 1) {
                $variants = json_decode($product->variants, true);
                foreach ($variants as &$variant) {
                    $combination = $variant['attributes'];
                    $soldQuantity = DB::table('order_items')
                        ->where('product_id', $product->id)
                        ->whereJsonContains('variant', $combination)
                        ->sum('quantity');
                    $variant['sold_quantity'] = $soldQuantity;
                }
                $product->variants = json_encode($variants);
            }
            //    dd($product->variants);
            $soldQty = OrderItem::where('product_id', $product->id)
                ->whereHas('order', function ($query) {
                    $query->where('payment_status', '!=', 'processing');
                })->sum('quantity');
            // dd($soldQty);
            $product->totalQty = $product->totalQty - $soldQty;
            $product->soldQty = $soldQty;
            $product->country = null;
            $product->state = null;
            $product->paymentInfo = $product->vendor->payment_info ?? [];

            if (isset($product->vendor->country)) {
                $product->country = countries::where('id', $product->vendor->country)->first();
            }
            if (isset($product->vendor->state)) {
                $product->state = states::where('id', $product->vendor->state)->first();
            }
            $product->item_country = null;
            $product->item_state = null;
            if (isset($product->product_setting->country_id)) {
                $product->item_country = countries::where('id', $product->product_setting->country_id)->first();
            }
            if (isset($product->product_setting->state_id)) {
                $product->item_state = states::where('id', $product->product_setting->state_id)->first();
            }

            $searchedPath = '';
            if (isset($product->parent_category_id) && $product->parent_category_id != "" && isset($product->parentcategory->id)) {
                $searchedPath .= ' > <a href="' . route("categories.show", $product->parentcategory->slug) . '" class="text-decoration-none text-primary">' . $product->parentcategory->name . '</a>';
            }
            if (isset($product->category_id) && $product->category_id != "" && isset($product->category->id) && $product->category->id != "") {
                $searchedPath .= ' > <a href="' . route("categories.show", $product->category->slug) . '" class="text-decoration-none text-primary">' . $product->category->name . '</a>';
            }
            if (isset($product->subcategory_id) && $product->subcategory_id != "" && isset($product->childcategory->id) && $product->childcategory->id != "") {
                $searchedPath .= ' > <a href="' . route("categories.show", $product->childcategory->slug) . '" class="text-decoration-none text-primary">' . $product->childcategory->name . '</a>';
            }
            if (isset($product->childcategory_id) && $product->childcategory_id != "" && isset($product->endchildcategory->id) && $product->endchildcategory->id != "") {
                $searchedPath .= ' > <a href="' . route("categories.show", $product->endchildcategory->slug) . '" class="text-decoration-none text-primary">' . $product->endchildcategory->name . '</a>';
            }
            $product->searched_path = $searchedPath;

            $product->shippingData = $shippingData;
            $product->average_rating = number_format($product->vendor->ratings()->avg('rate') ?? 0);

            $seo = $this->buildSeoMeta($product->name ?? null, 'Products');
            $metaTitle = $seo['metaTitle'];
            $metaDescription = $seo['metaDescription'];
            $metaKeywords = $seo['metaKeywords'];

            // echo '<pre>';
            // print_r($product->toArray());
            // echo '</pre>';

            return view('external-user.product-detail', compact('product', 'yourShippingCost', 'metaTitle', 'metaDescription', 'metaKeywords'));
        } else {
            return redirect()->back();
        }
    }
    public function getSubCategory(Request $request)
    {
        $categories = [];
        if (isset($request->id)) {
            $categories = category::where('status', "1")->where('parent_category_id', $request->id)->orderBy('name', 'ASC')->get();
        }
        return response()->json(['status' => true, 'categories' => $categories]);
    }

    // Controller Method to Get Subcategories
    public function getSubCategories(Request $request)
    {
        $subCategories = category::where('parent_category_id', $request->category_id)->where('status', 1)->orderBy('name', 'ASC')->get();
        return response()->json($subCategories);
    }

    public function getSubSubCategories(Request $request)
    {
        $subSubCategories = subcategory::where('category_id', $request->sub_category_id)->where('status', 1)->orderBy('name', 'ASC')->get();
        return response()->json($subSubCategories);
    }

    public function getChildCategories(Request $request)
    {
        $childCategories = endsubcategory::where('subcategories_id', $request->sub_sub_category_id)->where('status', 1)->orderBy('name', 'ASC')->get();
        return response()->json($childCategories);
    }




    // spotlight store
    public function sellerSpotlight(Request $request, $code, $slug = null)
    {
        $seller = User::where('ref_no', $code)->with('company', 'store_meta', 'store_keys')
            ->addSelect([
                'total_sold' => products::selectRaw('SUM(order_items.quantity)')
                    ->join('order_items', 'order_items.product_id', '=', 'products.id')
                    ->whereColumn('products.vendor_id', 'users.id')
                    ->where('order_items.quantity', '>', 0)
                    ->groupBy('products.vendor_id')
                    ->limit(1)
            ])
            ->first();
        // dd($seller->toArray());
        if ($seller) {
            $countries = countries::orderBy('name', 'ASC')->get();
            $categories = parent_category::where('status', "1")->orderBy('name', 'ASC')->get();
            $category_id = null;
            if ($slug != null && $slug != '' && is_string($slug)) {
                $categorySearch = category::where('slug', $slug)->first();
                if ($categorySearch) {
                    $category_id = $categorySearch->id;
                } else {
                    abort(404, 'Product not found!');
                }
            }
            $products = products::where('isList', 1)
                ->where(function ($query) {
                    $query->where('isMultiple', 1)
                        ->orWhere(function ($subQuery) {
                            $subQuery->where('isMultiple', 0)
                                ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()]);
                        });
                })
                ->where('vendor_id', $seller->id);
            if ($category_id != null) {
                $products = $products->where('category_id', $category_id);
            }
            $products = $products->with('gallery', 'vendor.company', 'vendor.symbols')
                ->paginate(8);

            $products_ct = products::where('isList', 1)
                ->where(function ($query) {
                    $query->where('isMultiple', 1)
                        ->orWhere(function ($subQuery) {
                            $subQuery->where('isMultiple', 0)
                                ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()]);
                        });
                })
                ->where('vendor_id', $seller->id)
                ->with('parentcategory', 'category', 'childCategory', 'endchildcategory')
                ->get();


            foreach ($products as $product) {
                $product->country = null;
                $product->state = null;
                if (isset($product->vendor->country)) {
                    $product->country = countries::where('id', $product->vendor->country)->first();
                }
                if (isset($product->vendor->state)) {
                    $product->state = states::where('id', $product->vendor->state)->first();
                }
            }
            $categoryTree = [];
            foreach ($products_ct as $product_ct) {

                $parentCategory = $product_ct->parentCategory;
                $category = $product_ct->category;

                if ($parentCategory) {
                    // Ensure the parent category exists in the tree
                    if (!isset($categoryTree[$parentCategory->id])) {
                        $categoryTree[$parentCategory->id] = [
                            'id' => $parentCategory->id,
                            'name' => $parentCategory->name,
                            'slug' => $parentCategory->slug,
                            'categories' => [],
                        ];
                    }

                    // Add the category under the parent category
                    if ($category) {
                        $categoryTree[$parentCategory->id]['categories'][$category->id] = [
                            'id' => $category->id,
                            'name' => $category->name,
                            'slug' => $category->slug,
                        ];
                    }
                }
            }

            $categoryTree = array_values($categoryTree);
            // dd($categoryTree);
            $seller->rating = number_format($seller->ratings()->avg('rate') ?? 0, 1);

            return view('external-user.spotlight-store', compact('seller', 'categories', 'countries', 'products', 'categoryTree'));
        } else {
            abort(404);
        }
    }
}
