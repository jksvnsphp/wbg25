<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\countries;
use App\Models\endsubcategory;
use App\Models\parent_category;
use App\Models\shipping_rate_tables;
use App\Models\states;
use App\Models\subcategory;
use App\Models\Tender;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class UITendersController extends Controller
{
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
    public function index_old_05_06_(Request $request, $slug = null)
    {
        $pageItem = 12;
        if ($slug != '' && $slug != null) {
            $result = $this->findCategoryBySlug($slug);
            if ($result != null) {
                $category = $result['category'];
                $level = $result['level'];
            } else {
                abort(404);
            }
        }
        if ($request->has('pageItem') && $request->filled('pageItem')) {
            $pageItem = $request->pageItem ?? 10;
        }
        $categories = parent_category::where('status', "1")->orderBy('name', 'ASC')->get();
        $countries = countries::orderBy('name', 'ASC')->get();
        $queryT = Tender::query()->where('isDeal', 0)->whereHas('vendor', function ($q) {
            $q->where('account_type', 'seller');
        })->with(['vendor.sellerPackageOne' => function ($q) {
            $q->whereNotNull('expire_at');
        }]);
        $queryT->where('status', 1);
        if ($request->has('q') && $request->input('q') != "") {
            $search = $request->input('q');
            $queryT = $queryT->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
        if (isset($level) && isset($category)) {
            switch ($level) {
                case 1:
                    $queryT->where('parent_category_id', $category->id);
                    break;
                case 2:
                    $queryT->where(function ($query) use ($category) {
                        $query->where('category_id', $category->id)
                            ->orWhere('parent_category_id', $category->parent_category_id);
                    });
                    break;
                case 3:
                    $queryT->where(function ($query) use ($category) {
                        $query->where('subcategory_id', $category->id)
                            ->orWhere('category_id', $category->category_id);
                    });
                    break;
                case 4:
                    $queryT->where(function ($query) use ($category) {
                        $query->where('childcategory_id', $category->id)
                            ->orWhere('subcategory_id', $category->subcategories_id);
                    });
                    break;
                default:
                    break;
            }
        }
        if ($request->has('country') && $request->input('country') != "") {
            $country = $request->input('country');
            $countryData = countries::where('name', $country)->first();
            if ($countryData != null) {
                $queryT = $queryT->whereHas('vendor', function ($query) use ($countryData) {
                    $query->where('country', $countryData->id);
                });
            }
        }
        if ($request->has('keywords') && $request->input('keywords') != "") {
            $keywords = explode(',', $request->keywords);
            $queryT->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $keyword = trim($keyword);
                    $q->orWhere('name', 'LIKE', "%$keyword%")
                        ->orWhere('description', 'LIKE', "%$keyword%");
                }
            });
        }
        
        if ($request->has('parentcategory') && $request->input('parentcategory') != "") {
            $parentcategory = $request->input('parentcategory');
            $queryT->where('parent_category_id', $parentcategory);
        }
        if ($request->has('subcategory') && $request->input('subcategory') != "") {
            $subcategory = $request->input('subcategory');
            $queryT->where('category_id', $subcategory);
        }
        if ($request->has('childcategory') && $request->input('childcategory') != "") {
            $childcategory = $request->input('childcategory');
            $queryT->where('subcategory_id', $childcategory);
        }
        if ($request->has('endcategory') && $request->input('endcategory') != "") {
            $endcategory = $request->input('endcategory');
            $queryT->where('childcategory_id', $endcategory);
        }

        $tenders = $queryT->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()])
            ->with('vendor.company')
            ->latest()->get();
        $sortedResults = $tenders->sortBy(function ($tender) {
            $package = optional($tender->vendor->sellerPackageOne)->package;
            $expireAt = optional($tender->vendor->sellerPackageOne)->expire_at;

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
        foreach ($sortedResults as $tender) {
            $tender->country = null;
            if (isset($tender->vendor->country)) {
                $tender->country = countries::where('id', $tender->vendor->country)->first();
            }
            $expiryDate = Carbon::parse($tender->created_at)->addDays($tender->duration);
            $isExpired = now()->greaterThanOrEqualTo($expiryDate);
            $tender->expiry_date = $expiryDate->format('Y M d | H:i');
            $tender->is_expired = $isExpired;
        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $items = $sortedResults->slice(($currentPage - 1) * $pageItem, $pageItem)->values();
        $paginatedResults = new LengthAwarePaginator($items, $sortedResults->count(), $pageItem, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'query' => $request->query(),
        ]);
        $tenders = $paginatedResults;
        return view('external-user.tender.tender-home', compact('categories', 'countries', 'tenders'));
    }
    
    
    public function index(Request $request, $slug = null)
{
    $pageItem = 12;
    //$pageItem = request('per_page', 10); // default 10

    if ($slug != '' && $slug != null) {
        $result = $this->findCategoryBySlug($slug);
        if ($result != null) {
            $category = $result['category'];
            $level = $result['level'];
        } else {
            abort(404);
        }
    }

    if ($request->has('pageItem') && $request->filled('pageItem')) {
        $pageItem = $request->pageItem ?? 10;
    }

    $categories = parent_category::where('status', "1")->orderBy('name', 'ASC')->get();
    $countries = countries::orderBy('name', 'ASC')->get();

    $queryT = Tender::query()
        ->where('isDeal', 0)
        ->whereHas('vendor', fn($q) => $q->where('account_type', 'seller'))
        ->with(['vendor.sellerPackageOne' => fn($q) => $q->whereNotNull('expire_at')])
        ->where('status', 1);

    // Search
    if ($request->filled('q')) {
        $search = $request->input('q');
        $queryT->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%");
        });
    }

    // Keyword search
    if ($request->filled('keywords')) {
        $keywords = explode(',', $request->keywords);
        $queryT->where(function ($q) use ($keywords) {
            foreach ($keywords as $keyword) {
                $keyword = trim($keyword);
                $q->orWhere('name', 'LIKE', "%$keyword%")
                  ->orWhere('description', 'LIKE', "%$keyword%");
            }
        });
    }

    // Category filter by level
    if (isset($level) && isset($category)) {
        switch ($level) {
            case 1:
                $queryT->where('parent_category_id', $category->id);
                break;
            case 2:
                $queryT->where(fn($query) => $query
                    ->where('category_id', $category->id)
                    ->orWhere('parent_category_id', $category->parent_category_id));
                break;
            case 3:
                $queryT->where(fn($query) => $query
                    ->where('subcategory_id', $category->id)
                    ->orWhere('category_id', $category->category_id));
                break;
            case 4:
                $queryT->where(fn($query) => $query
                    ->where('childcategory_id', $category->id)
                    ->orWhere('subcategory_id', $category->subcategories_id));
                break;
        }
    }

    // Country filter
    if ($request->filled('country')) {
        $countryData = countries::where('name', $request->input('country'))->first();
        if ($countryData) {
            $queryT->whereHas('vendor', fn($q) => $q->where('country', $countryData->id));
        }
    }

    // Other category filters
    foreach (['parentcategory' => 'parent_category_id', 'subcategory' => 'category_id', 'childcategory' => 'subcategory_id', 'endcategory' => 'childcategory_id'] as $reqKey => $col) {
        if ($request->filled($reqKey)) {
            $queryT->where($col, $request->input($reqKey));
        }
    }

    // Exclude expired tenders (common in all)
    $queryT->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()]);
    
    // Apply order_type filter
    if ($request->filled('order_type')) {
        $orderType = $request->input('order_type');
        if ($orderType === 'latest') {
            $queryT->orderBy('created_at', 'desc');
        } elseif ($orderType === 'expired-soon') {
            $queryT->orderByRaw('DATE_ADD(created_at, INTERVAL duration DAY) ASC');
        }
    } else {
        $queryT->orderBy('created_at', 'desc');
    }

    $tenders = $queryT->with('vendor.company')->get();

    $sortedResults = $tenders->sortBy(function ($tender) {
        $package = optional($tender->vendor->sellerPackageOne)->package;
        $expireAt = optional($tender->vendor->sellerPackageOne)->expire_at;

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

    foreach ($sortedResults as $tender) {
        $tender->country = $tender->vendor->country
            ? countries::find($tender->vendor->country)
            : null;

        $expiryDate = Carbon::parse($tender->created_at)->addDays($tender->duration);
        $tender->expiry_date = $expiryDate->format('Y M d | H:i');
        $tender->is_expired = now()->greaterThanOrEqualTo($expiryDate);
    }

    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $items = $sortedResults->slice(($currentPage - 1) * $pageItem, $pageItem)->values();
    $paginatedResults = new LengthAwarePaginator($items, $sortedResults->count(), $pageItem, $currentPage, [
        'path' => LengthAwarePaginator::resolveCurrentPath(),
        'query' => $request->query(),
    ]);

    return view('external-user.tender.tender-home', [
        'categories' => $categories,
        'countries' => $countries,
        'tenders' => $paginatedResults,
    ]);
}

    
    function getShippingCostByCountry($rate_id, $countryCode)
    {
        try {

            $shippingRates = shipping_rate_tables::with([
                'shipping_rate_costs.shipping_regions.region.countries',
                'shipping_rate_costs.shipping_regions.country'
            ])->where('id', $rate_id)->first();

            if (!$shippingRates) {
                return 'Shipping rate table not found';
            }
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
    public function tenderDetails($slug)
    {
        $tender = Tender::where('slug', $slug)->where('status', 1)->where('isDeal', 0)->with('parentcategory', 'category', 'childcategory', 'endchildcategory', 'vendor.company')->first();
        if ($tender) {
            $shippingData = $this->getShippingData($tender->rate_table_id);
            $yourShippingCost = $this->getShippingCostByIp($tender->rate_table_id);
            
                $expiryDate = Carbon::parse($tender->created_at)->addDays($tender->duration);
                ///added_at
                // Check if expired
                $isExpired = now()->greaterThanOrEqualTo($expiryDate);

                $remainingTime = $isExpired
                    ? $expiryDate->diffForHumans([
                        'parts' => 3,
                        'short' => true,
                        'absolute' => true,
                    ])
                    : now()->diffForHumans($expiryDate, [
                        'parts' => 3,
                        'short' => true,
                        'absolute' => true,
                    ]);

                // Update product status if expired
                if ($isExpired && $tender->status != 0) {
                    $tender->status = 0;
                    $tender->save();
                    return back()->with(['alert-type' => 'error', 'message' => 'This tender is no more avialable in list.']);
                }
                $tender->expiry_date = $expiryDate->format('Y M d h:i:s A');
                $tender->added_at = $tender->created_at->format('Y M d h:i:s A');
                $tender->is_expired = $isExpired;
                $remainingTime = str_replace(['before', 'after'], '', $remainingTime);
                $tender->remaining_time = $remainingTime;
            
            
            
            $tender->country = null;
            $seller = User::where('id', $tender->vendor_id)->first();
            $seller->rating = number_format($seller->ratings()->avg('rate'), 1);
            $tender->paymentInfo = $tender->vendor->payment_info ?? [];

            if (isset($tender->vendor->country)) {
                $tender->country = countries::where('id', $tender->vendor->country)->first();
            }

            $searchedPath = '';
            if (isset($tender->parent_category_id) && $tender->parent_category_id != "" && isset($tender->parentcategory->id)) {
                $searchedPath .= ' > <a href="' . route("filter.all.tenders", $tender->parentcategory->slug) . '" class="text-decoration-none text-primary">' . $tender->parentcategory->name . '</a>';
            }
            if (isset($tender->category_id) && $tender->category_id != "" && isset($tender->category->id) && $tender->category->id != "") {
                $searchedPath .= ' > <a href="' . route("filter.all.tenders", $tender->category->slug) . '" class="text-decoration-none text-primary">' . $tender->category->name . '</a>';
            }
            if (isset($tender->subcategory_id) && $tender->subcategory_id != "" && isset($tender->childcategory->id) && $tender->childcategory->id != "") {
                $searchedPath .= ' > <a href="' . route("filter.all.tenders", $tender->childcategory->slug) . '" class="text-decoration-none text-primary">' . $tender->childcategory->name . '</a>';
            }
            if (isset($tender->childcategory_id) && $tender->childcategory_id != "" && isset($tender->endchildcategory->id) && $tender->endchildcategory->id != "") {
                $searchedPath .= ' > <a href="' . route("filter.all.tenders", $tender->endchildcategory->slug) . '" class="text-decoration-none text-primary">' . $tender->endchildcategory->name . '</a>';
            }
            $tender->searched_path = $searchedPath;
            $tender->shippingData = $shippingData;
            // dd($tender);
            return view('external-user.tender.tender-details', compact('tender', 'seller','yourShippingCost'));
        } else {
            abort(404);
        }
    }
}
