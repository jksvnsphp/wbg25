<?php

namespace App\Http\Controllers\admin;

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
use App\Http\Controllers\Controller;
use App\Models\TenderCategory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StoresController extends Controller
{
    //

    public function index(Request $request)
    {
        $countries = countries::orderBy('name', 'ASC')->get();
        $query = User::where('account_type', 'seller')
            ->where('isComplete', 1)
            ->where('status', 1)
            ->with('company', 'sellerPackage');
        // ->whereHas('company', function ($companyQuery) {
        //     $companyQuery->whereNotNull('spotlight_banner')
        //         ->whereNotNull('spotlight_preview1');
        // });
        // ->whereHas('sellerPackage', function ($query) {
        //     $query->whereHas('package', function ($subQuery) {
        //         $subQuery->whereIn('type', ['gold', 'platinum']);
        //     })
        //         ->where(function ($expireQuery) {
        //             $expireQuery->whereNull('expire_at')
        //                 ->orWhere('expire_at', '>', now());
        //         });
        // });
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
                        $StoreKeyQuery->where(function ($keysQuery) use ($searchTerm) {
                            for ($i = 1; $i <= 10; $i++) {
                                $column = "key{$i}";
                                if ($i === 1) {
                                    $keysQuery->where($column, 'LIKE', "%{$searchTerm}%");
                                } else {
                                    $keysQuery->orWhere($column, 'LIKE', "%{$searchTerm}%");
                                }
                            }
                        });
                    })
                    ->orWhereHas('store_meta', function ($metaQuery) use ($searchTerm) {
                        $metaQuery->where(function ($metaSubQuery) use ($searchTerm) {
                            $metaSubQuery->where('title', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('keywords', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('description', 'LIKE', "%{$searchTerm}%");
                        });
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
        $pageItem = 15;
        if ($request->has('pageItem') && $request->filled('pageItem')) {
            $pageItem = $request->pageItem ?? 10;
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

        // echo "<pre/>";
        // print_r($spotlights->toArray());
        // die('dsad');
        return view('admin.stores_management.index', compact('spotlights', 'countries', 'categories'));
    }

    public function images(Request $request)
    {
        $countries = countries::orderBy('name', 'ASC')->get();
        // $query = User::where('account_type', 'seller')
        //    // ->where('isComplete', 1)
        //    // ->where('status', 1)
        //     ->with('company', 'sellerPackage');

        $query = User::where('account_type', 'seller')
            ->with('company', 'sellerPackage')
            ->whereHas('company', function ($q) {
                $q->whereNotNull('company_logo')
                    ->where('company_logo', '!=', '');
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
                        $StoreKeyQuery->where(function ($keysQuery) use ($searchTerm) {
                            for ($i = 1; $i <= 10; $i++) {
                                $column = "key{$i}";
                                if ($i === 1) {
                                    $keysQuery->where($column, 'LIKE', "%{$searchTerm}%");
                                } else {
                                    $keysQuery->orWhere($column, 'LIKE', "%{$searchTerm}%");
                                }
                            }
                        });
                    })
                    ->orWhereHas('store_meta', function ($metaQuery) use ($searchTerm) {
                        $metaQuery->where(function ($metaSubQuery) use ($searchTerm) {
                            $metaSubQuery->where('title', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('keywords', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('description', 'LIKE', "%{$searchTerm}%");
                        });
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
        $pageItem = 10;
        if ($request->has('pageItem') && $request->filled('pageItem')) {
            $pageItem = $request->pageItem ?? 10;
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
        return view('admin.store-image.images', compact('spotlights', 'countries', 'categories'));
    }

    public function changeStatus(Request $request)
    {
        // dd($request->all());
        $supplier = TenderCategory::where('id', $request->id)->first();
        $supplier->status = $request->status;
        if ($supplier->save()) {
            return response()->json(['success' => 'Status Changed Successfully']);
        } else {
            return response()->json(['error' => 'Something went wrong']);
        }
    }

    public function storeBanners(Request $request)
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
                        $StoreKeyQuery->where(function ($keysQuery) use ($searchTerm) {
                            for ($i = 1; $i <= 10; $i++) {
                                $column = "key{$i}";
                                if ($i === 1) {
                                    $keysQuery->where($column, 'LIKE', "%{$searchTerm}%");
                                } else {
                                    $keysQuery->orWhere($column, 'LIKE', "%{$searchTerm}%");
                                }
                            }
                        });
                    })
                    ->orWhereHas('store_meta', function ($metaQuery) use ($searchTerm) {
                        $metaQuery->where(function ($metaSubQuery) use ($searchTerm) {
                            $metaSubQuery->where('title', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('keywords', 'LIKE', "%{$searchTerm}%")
                                ->orWhere('description', 'LIKE', "%{$searchTerm}%");
                        });
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
        $pageItem = 10;
        if ($request->has('pageItem') && $request->filled('pageItem')) {
            $pageItem = $request->pageItem ?? 10;
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
        return view('admin.store-image.banners', compact('spotlights', 'countries', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|unique:tender_categories,name',
                'meta_keyword' => 'nullable|string',
                'image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
                'meta_description' => 'nullable|string'
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {
            $slug = Str::slug($request->name);
            //    check slug is exist or not
            $TenderCategory = TenderCategory::where('slug', $slug)->first();
            if (!empty($TenderCategory)) {
                return back()->with(['alert-type' => 'error', 'message' => 'Slug is already taken!']);
            } else {
                $TenderCategory = new TenderCategory();
                $TenderCategory->name = $request->name;
                $TenderCategory->slug = Str::slug($request->name);
                $TenderCategory->meta_keyword = $request->meta_keyword;
                $TenderCategory->meta_description = $request->meta_description;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('tender_') . '.' . $ext;
                    $file->move(public_path('/uploads/tender_category/'), $fileName);
                    $TenderCategory->image = $fileName;
                }
                $TenderCategory->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Tender Category added successfully']);
            }
        }
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|string|exists:tender_categories,id',
                'name' => 'required|string|unique:tender_categories,name,' . $request->id,
                'meta_keyword' => 'nullable|string',
                'image' => 'nullable|image|mimes:png,jpg,jpeg,svg',
                'meta_description' => 'nullable|string'
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors())->withInput($request->all());
        } else {

            $TenderCategory = TenderCategory::where('id', $request->id)->first();
            if (!empty($TenderCategory)) {

                $TenderCategory->name = $request->name;
                $TenderCategory->slug = Str::slug($request->name);
                $TenderCategory->meta_keyword = $request->meta_keyword;
                $TenderCategory->meta_description = $request->meta_description;
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $ext = $file->getClientOriginalExtension();
                    $fileName = uniqid('tender_') . '.' . $ext;
                    $file->move(public_path('/uploads/tender_category/'), $fileName);
                    if ($TenderCategory->image != '') {
                        $oldfile = public_path('/uploads/tender_category/' . $TenderCategory->image);
                        if (File::exists($oldfile)) {
                            File::delete($oldfile);
                        }
                    }
                    $TenderCategory->image = $fileName;
                }
                $TenderCategory->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Tender Category updated successfully']);
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Tender Category not found!']);
            }
        }
    }


    public function DeleteCategory($category_id)
    {
        $TenderCategory = TenderCategory::where('id', $category_id)->first();
        if (!empty($TenderCategory)) {
            if ($TenderCategory->image != '') {
                $oldfile = public_path('/uploads/supplier_category/' . $TenderCategory->image);
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }

            $TenderCategory->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully deleted']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Category not found!']);
        }
    }
    public function edit($category_id)
    {
        $TenderCategory = TenderCategory::where('id', $category_id)->first();
        if (!empty($TenderCategory)) {

            return view('admin.tenders_management.edit_tender_category', ['pcat' => $TenderCategory]);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Category not found!']);
        }
    }

    public function storeChangeStatus(Request $request)
    {
        // dd($request->all());
        $supplier = TenderCategory::where('id', $request->id)->first();
        $supplier->status = $request->status;
        if ($supplier->save()) {
            return response()->json(['success' => 'Status Changed Successfully']);
        } else {
            return response()->json(['error' => 'Something went wrong']);
        }
    }

    /**
     * Show details of a product.
     */
    public function show(Request $request, $id)
    {
        $product = products::with('vendor', 'gallery', 'category', 'subcategory', 'childcategory', 'brand', 'unit')->where('id', $id)->firstOrFail();
        $product->country = countries::find($product->vendor->country);
        $averageRating = $product->reviews()->avg('rating');
        $product->average_rating = $averageRating !== null ? number_format($averageRating, 2) : '0.00';
        $product->sold = DB::table('order_items')
            ->where('order_items.product_id', $product->id)
            ->sum('order_items.quantity');
        $product->totalReviews = $product->reviews()->count();

        // echo '<pre>'; print_r($product->toArray()); die;
        return view('admin.store.show', compact('product'));
    }

    public function deletImage()
    {
        $category_id = request()->spotlight_id;
        $TenderCategory = TenderCategory::where('id', $category_id)->first();
        if (!empty($TenderCategory)) {
            if ($TenderCategory->image != '') {
                $oldfile = public_path('/uploads/supplier_category/' . $TenderCategory->image);
                if (File::exists($oldfile)) {
                    File::delete($oldfile);
                }
            }

            $TenderCategory->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully deleted']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Store not found!']);
        }
    }
}


//images