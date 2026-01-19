<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\countries;
use App\Models\CustomeCategory;
use App\Models\HomeBanner;
use App\Models\HomeInfo;
use App\Models\parent_category;
use App\Models\products;
use App\Models\SellerNews;
use App\Models\Tender;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontUIController extends Controller
{
    //
    public function makeCategoryTree()
    {

        $products = products::with(['parentcategory', 'category', 'childCategory', 'endchildcategory'])
            ->where('isList', 1)
            ->where(function ($query) {
                $query->where('isMultiple', 1)
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('isMultiple', 0)
                            ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()]);
                    });
            })
            ->get();
        $categoryTree = [];
        foreach ($products as $product) {
            $parentCategory = $product->parentCategory;
            $category = $product->category;
            $subCategory = $product->childCategory;
            $childCategory = $product->endchildcategory;

            if ($parentCategory) {
                // Ensure the parent category exists
                if (!isset($categoryTree[$parentCategory->id])) {
                    $categoryTree[$parentCategory->id] = [
                        'id' => $parentCategory->id,
                        'name' => $parentCategory->name,
                        'slug' => $parentCategory->slug,
                        'categories' => [],
                        'route' => route('categories.show', ['slug' => $parentCategory->slug]),
                    ];
                }

                if ($category) {
                    // Ensure the category exists under the parent
                    if (!isset($categoryTree[$parentCategory->id]['categories'][$category->id])) {
                        $categoryTree[$parentCategory->id]['categories'][$category->id] = [
                            'id' => $category->id,
                            'name' => $category->name,
                            'slug' => $category->slug,
                            'childCategory' => [],
                            'route' => route('categories.show', ['slug' => $category->slug]),
                        ];
                    }

                    if ($subCategory) {
                        // Ensure the subcategory exists under the category
                        if (!isset($categoryTree[$parentCategory->id]['categories'][$category->id]['childCategory'][$subCategory->id])) {
                            $categoryTree[$parentCategory->id]['categories'][$category->id]['childCategory'][$subCategory->id] = [
                                'id' => $subCategory->id,
                                'name' => $subCategory->name,
                                'slug' => $subCategory->slug,
                                'endchildcategory' => [],
                                'route' => route('categories.show', ['slug' => $subCategory->slug]),
                            ];
                        }

                        if ($childCategory) {
                            // Add the child category under the subcategory
                            $categoryTree[$parentCategory->id]['categories'][$category->id]['childCategory'][$subCategory->id]['endchildcategory'][$childCategory->id] = [
                                'id' => $childCategory->id,
                                'name' => $childCategory->name,
                                'slug' => $childCategory->slug,
                                'route' => route('categories.show', ['slug' => $childCategory->slug]),
                            ];
                        }
                    }
                }
            }
        }
        $categoryTree = array_map(function ($parent) {
            $parent['categories'] = array_values(array_map(function ($category) {
                $category['childCategory'] = array_values(array_map(function ($subCategory) {
                    $subCategory['endchildcategory'] = array_values($subCategory['endchildcategory']);
                    return $subCategory;
                }, $category['childCategory']));
                return $category;
            }, $parent['categories']));
            return $parent;
        }, $categoryTree);

        return array_values($categoryTree);
    }

    public function bc_makeCategoryTree()
    {
        // Fetch products with their categories
        $products = products::with(['parentcategory', 'category', 'childCategory', 'endchildcategory'])
            ->get();

        // Build the category tree
        $categoryTree = [];

        foreach ($products as $product) {
            $parentCategory = $product->parentCategory;
            $category = $product->category;
            $subCategory = $product->childCategory;
            $childCategory = $product->endchildcategory;

            if ($parentCategory) {
                // Ensure the parent category exists
                if (!isset($categoryTree[$parentCategory->id])) {
                    $categoryTree[$parentCategory->id] = [
                        'id' => $parentCategory->id,
                        'name' => $parentCategory->name,
                        'slug' => $parentCategory->slug,
                        'categories' => [],
                    ];
                }

                if ($category) {
                    // Ensure the category exists under the parent
                    if (!isset($categoryTree[$parentCategory->id]['categories'][$category->id])) {
                        $categoryTree[$parentCategory->id]['categories'][$category->id] = [
                            'id' => $category->id,
                            'name' => $category->name,
                            'slug' => $category->slug,
                            'childCategory' => [],
                        ];
                    }

                    if ($subCategory) {
                        // Ensure the subcategory exists under the category
                        if (!isset($categoryTree[$parentCategory->id]['categories'][$category->id]['childCategory'][$subCategory->id])) {
                            $categoryTree[$parentCategory->id]['categories'][$category->id]['childCategory'][$subCategory->id] = [
                                'id' => $subCategory->id,
                                'name' => $subCategory->name,
                                'slug' => $subCategory->slug,
                                'endchildcategory' => [],
                            ];
                        }

                        if ($childCategory) {
                            // Add the child category under the subcategory
                            $categoryTree[$parentCategory->id]['categories'][$category->id]['childCategory'][$subCategory->id]['endchildcategory'][$childCategory->id] = [
                                'id' => $childCategory->id,
                                'name' => $childCategory->name,
                                'slug' => $childCategory->slug,
                            ];
                        }
                    }
                }
            }
        }

        // Convert all arrays to values for easier handling in Blade
        $categoryTree = array_map(function ($parent) {
            $parent['categories'] = array_values(array_map(function ($category) {
                $category['childCategory'] = array_values(array_map(function ($subCategory) {
                    $subCategory['endchildcategory'] = array_values($subCategory['endchildcategory']);
                    return $subCategory;
                }, $category['childCategory']));
                return $category;
            }, $parent['categories']));
            return $parent;
        }, $categoryTree);

        return array_values($categoryTree);
    }


    public function home()
    {
        $homeBanner = HomeBanner::latest()->first();
        $banner = array();
        if ($homeBanner->banner1 != '') {
            $data['banner'] = $homeBanner->banner1;
            $data['banner_title'] = $homeBanner->banner1_text;
            $data['banner_link'] = $homeBanner->banner1_link;
            $banner[] = $data;
        }
        if ($homeBanner->banner2 != '') {
            $data['banner'] = $homeBanner->banner2;
            $data['banner_title'] = $homeBanner->banner2_text;
            $data['banner_link'] = $homeBanner->banner2_link;
            $banner[] = $data;
        }
        if ($homeBanner->banner3 != '') {
            $data['banner'] = $homeBanner->banner3;
            $data['banner_title'] = $homeBanner->banner3_text;
            $data['banner_link'] = $homeBanner->banner3_link;
            $banner[] = $data;
        }

        if ($homeBanner->banner4 != '') {
            $data['banner'] = $homeBanner->banner4;
            $data['banner_title'] = $homeBanner->banner4_text;
            $data['banner_link'] = $homeBanner->banner4_link;
            $banner[] = $data;
        }
        if ($homeBanner->banner5 != '') {
            $data['banner'] = $homeBanner->banner5;
            $data['banner_title'] = $homeBanner->banner5_text;
            $data['banner_link'] = $homeBanner->banner5_link;
            $banner[] = $data;
        }

        $categories = parent_category::orderBy('name', 'ASC')->with('subcategory.subcategory.subcategory')->get();
        // dd($categories);
        $countries = countries::whereIn('name', [
            'China',
            'Japan',
            'India',
            'Australia',
            'United States',
            'Canada',
            'Brazil',
            'Mexico',
            'Germany',
            'France',
            'United Kingdom',
            'South Africa'
        ])->get(['id', 'name', 'iso2']);
        // dd($countries->toArray());
        $infos = HomeInfo::get();
        $wholesalerUsers = User::latest()->where(['isComplete' => 1, 'status' => 1, 'account_type' => 'seller'])->whereHas('company', function ($query) {
            $query->where('business_type', '!=', '');
        })->limit(10)->get();

        $BulkProducts = products::latest()->with('gallery')
            ->where('isList', 1)
            ->where('isBulkBuy', 1)
            ->where(function ($query) {
                $query->where('isMultiple', 1)
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('isMultiple', 0)
                            ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()]);
                    });
            })->limit(10)->get();

        $DailyProducts = products::latest()
            ->with('gallery')->where('isList', 1)
            ->where('isDailyDeal', 1)
            ->where(function ($query) {
                $query->where('isMultiple', 1)
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('isMultiple', 0)
                            ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()]);
                    });
            })
            ->limit(10)->get();
        $HotsProducts = products::latest()->with('gallery')
            ->where('isList', 1)->where('isHotProduct', 1)
            ->where(function ($query) {
                $query->where('isMultiple', 1)
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('isMultiple', 0)
                            ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()]);
                    });
            })
            ->limit(10)->get();
        $LimitedProducts = products::latest()->with('gallery')
            ->where('isList', 1)->where('isLimitedOffer', 1)
            ->where(function ($query) {
                $query->where('isMultiple', 1)
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('isMultiple', 0)
                            ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()]);
                    });
            })
            ->limit(10)->get();
        $videoProduct = products::latest()->with('video')
            ->where('isList', 1)
            ->where(function ($query) {
                $query->where('isMultiple', 1)
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('isMultiple', 0)
                            ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()]);
                    });
            })
            ->whereHas('video', function ($videoQuery) {
                $videoQuery->whereNotNull('video_url')
                    ->whereRaw('LENGTH(video_url) > 0');
            })
            ->inRandomOrder()
            ->limit(1)
            ->get()
            ->first();
        $latestNews = SellerNews::where('isPublish', 1)->latest()->limit(5)->get();
        $latestProducts = products::latest()->with('gallery')
            ->where('isList', 1)
            ->where(function ($query) {
                $query->where('isMultiple', 1)
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('isMultiple', 0)
                            ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()]);
                    });
            })
            ->limit(15)->get();
        $latestTenders = Tender::latest()->where('status', 1)->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()])->limit(15)->get();
        $makeCategoryTree = $this->makeCategoryTree();
        // dd($makeCategoryTree);
        $top_suppliers = User::query()
            ->where('account_type', 'seller')
            ->where('users.isComplete', 1)
            ->where('users.status', 1)
            ->whereHas('company', function ($query) {
                $query->where('business_type', '!=', '');
            })
            ->with('company')
            ->select('users.*')
            ->addSelect([
                'total_sold' => products::selectRaw('SUM(order_items.quantity)')
                    ->join('order_items', 'order_items.product_id', '=', 'products.id')
                    ->whereColumn('products.vendor_id', 'users.id')
                    ->where('order_items.quantity', '>', 0)
                    ->groupBy('products.vendor_id')
                    ->limit(1)
            ])
            // Join seller_packages + member_packages to know membership type
            ->join('seller_packages', 'seller_packages.seller_id', '=', 'users.id')
            ->join('member_packages', 'member_packages.id', '=', 'seller_packages.package_id')
            ->whereIn('member_packages.type', ['platinum', 'gold', 'silver', 'bronce'])
            ->orderByRaw("
        CASE member_packages.type
            WHEN 'platinum' THEN 1
            WHEN 'gold' THEN 2
            WHEN 'silver' THEN 3
            WHEN 'bronce' THEN 4
        END
    ")
            ->orderByDesc('total_sold')
            ->get();


        //  dd($makeCategoryTree);
        $randomSellers = User::where('account_type', 'seller')
            ->where('isComplete', 1)
            ->where('status', 1)
            ->with('company', 'sellerPackage')
            ->whereHas('company', function ($companyQuery) {
                $companyQuery->whereNotNull('spotlight_banner')
                    ->whereNotNull('spotlight_preview1');
            })
            ->whereHas('sellerPackage', function ($query) {
                $query->whereHas('package', function ($subQuery) {
                    $subQuery->whereIn('type', ['gold', 'platinum']);
                })
                    ->where(function ($expireQuery) {
                        $expireQuery->whereNull('expire_at')
                            ->orWhere('expire_at', '>', now());
                    });
            })
            ->inRandomOrder()
            ->limit(10)
            ->get();
        foreach ($randomSellers ?? [] as $randomSeller) {
            $randomSeller->average_rating = number_format($randomSeller->ratings()->avg('rate'));
        }
        // dd($randomSellers);
        $array = ['banners' => $banner, 'top_suppliers' => $top_suppliers, 'categoryTree' => $makeCategoryTree, 'infos' => $infos, 'categories' => $categories, 'countries' => $countries, 'wholesalerUsers' => $wholesalerUsers, 'latestNews' => $latestNews, 'latestProducts' => $latestProducts, 'latestTenders' => $latestTenders, 'BulkProducts' => $BulkProducts, 'DailyProducts' => $DailyProducts, 'HotsProducts' => $HotsProducts, 'LimitedProducts' => $LimitedProducts, 'spotlights' => $randomSellers, 'videoProduct' => $videoProduct];

        return view('external-user.home', $array);
    }
    public function allSpotlight(Request $request)
    {
        $countries = countries::orderBy('name', 'ASC')->get();
        $query = User::where('account_type', 'seller')
            ->where('isComplete', 1)
            ->where('status', 1)
            ->with('company', 'sellerPackage')
            ->whereHas('company', function ($companyQuery) {
                $companyQuery->whereNotNull('spotlight_banner')
                    ->whereNotNull('spotlight_preview1');
            })
            ->whereHas('sellerPackage', function ($query) {
                $query->whereHas('package', function ($subQuery) {
                    $subQuery->whereIn('type', ['gold', 'platinum']);
                })
                    ->where(function ($expireQuery) {
                        $expireQuery->whereNull('expire_at')
                            ->orWhere('expire_at', '>', now());
                    });
            });
        if ($request->has('q') && !empty($request->q)) {
            $searchTerm = $request->q;

            $query->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('ref_no', 'LIKE', "%{$searchTerm}%")
                    ->orWhereHas('company', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('name', 'LIKE', "%{$searchTerm}%");
                    })
                    ->orWhereHas('store_keys', function ($StoreKeyQuery) use ($searchTerm) {
                        for ($i = 1; $i <= 10; $i++) {
                            $StoreKeyQuery->orWhere("key{$i}", 'LIKE', "%{$searchTerm}%");
                        }
                    })
                    ->orWhereHas('store_meta', function ($metaQuery) use ($searchTerm) {
                        $metaQuery->where('title', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('keywords', 'LIKE', "%{$searchTerm}%")
                            ->orWhere('description', 'LIKE', "%{$searchTerm}%");
                    });
            });
        }
        if ($request->has('country') && $request->input('country') != "") {
            $country = $request->input('country');
            $countryData = countries::where('name', $country)->first();
            if ($countryData != null) {
                $query->where('country', $countryData->id);
            }
        }

        if ($request->has('category') && !empty($request->category)) {
            $query->whereHas('company', function ($q) use ($request) {
                $q->where('category_1', $request->category);
            });
        }

        if ($request->has('subcategory') && !empty($request->subcategory)) {
            $query->whereHas('company', function ($q) use ($request) {
                $q->where('category_2', $request->subcategory);
            });
        }

        if ($request->has('business_type') && !empty($request->business_type)) {
            $query->whereHas('company', function ($q) use ($request) {
                $q->where('business_type', $request->business_type);
            });
        }
        $pageItem = 4;
        if ($request->has('pageItem') && $request->filled('pageItem')) {
            $pageItem = $request->pageItem ?? 4;
        }

        $spotlights = $query->orderByRaw("
        (CASE 
            WHEN EXISTS (SELECT 1 FROM seller_packages sp 
                        JOIN member_packages p ON sp.package_id = p.id 
                        WHERE users.id = sp.seller_id AND p.type = 'platinum') THEN 1
            WHEN EXISTS (SELECT 1 FROM seller_packages sp 
                        JOIN member_packages p ON sp.package_id = p.id 
                        WHERE users.id = sp.seller_id AND p.type = 'gold') THEN 2
            ELSE 3
        END)
        ")->paginate($pageItem);
        foreach ($spotlights ?? [] as $spotlight) {
            $spotlight->country = countries::find($spotlight->country);
            $spotlight->sold = DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('products.vendor_id', $spotlight->id)
                ->sum('order_items.quantity');
            $averageRating = $spotlight->ratings()->avg('rate');
            $spotlight->average_rating = $averageRating !== null ? number_format($averageRating, 2) : '0.00';
        }
        $categories = CustomeCategory::where('status', "1")->where('deleted', "0")->where('parent_id', "0")->orderBy('category_name', 'ASC')->get();
        return view('external-user.all-spotlights', compact('spotlights', 'countries', 'categories'));
    }
    public function refreshCaptcha()
    {
        return captcha_src('flat');;
    }


    public function mywallet()
    {
        if (Auth::check() && Auth::user()->account_type == "seller") {
            $wallets = Wallet::with('orderItem')->latest()->where('user_id', Auth::user()->id)->get();
            // dd($wallets->toArray());
            return view('seller-vendor.wallet.my-wallet', compact('wallets'));
        } else {
            return redirect()->back()->with(['alert-type' => 'info', 'message' => 'Wallet support only for seller!']);
        }
    }
    public function howToSell()
    {
        return view('external-user.how-to-sell');
    }
    public function howToBuy()
    {
        return view('external-user.how-to-buy');
    }
    public function privacyAndPolicy()
    {
        return view('external-user.privacy-and-policy');
    }
    public function dataProtection()
    {
        return view('external-user.data-protection');
    }
    public function termsAndCondition()
    {
        return view('external-user.terms-and-condition');
    }
    public function imprint()
    {
        return view('external-user.imprint');
    }
}
