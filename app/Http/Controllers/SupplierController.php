<?php

namespace App\Http\Controllers;


use App\Models\countries;
use App\Models\CustomeCategory;
use App\Models\states;
use App\Models\User;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    //
    public function allsuppliers(Request $request)
    {
        $pageItem = 25;
        $countries = countries::orderBy('name', 'ASC')->get();
        $categories = CustomeCategory::where('status', "1")->where('deleted', "0")->where('parent_id', "0")->orderBy('category_name', 'ASC')->get();
        $querySuppliers = User::query()
            ->where(['isComplete' => 1, 'status' => 1, 'account_type' => 'seller'])
            ->with(['sellerPackageOne' => function ($q) {
                $q->whereNotNull('expire_at');
            }])
            ->with('company', 'exports', 'symbols', 'sellerPackageOne.package')
            ->whereHas('company', function ($sq) {
                $sq->where('id', "!=", "");
            });
        if ($request->has('pageItem') && $request->filled('pageItem')) {
            $pageItem = $request->pageItem ?? 10;
        }
        if ($request->has('q') && !empty($request->q)) {
            $searchTerm = $request->q;
            $querySuppliers->where(function ($q) use ($searchTerm) {
                $q->where('first_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('last_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('ref_no', 'LIKE', "%{$searchTerm}%")
                    ->orWhereHas('company', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('name', 'LIKE', "%{$searchTerm}%");
                        for ($i = 1; $i <= 10; $i++) {
                            $subQuery->orWhere("key{$i}", 'LIKE', "%{$searchTerm}%");
                        }
                    })
                    ->orWhereHas('profile_meta', function ($metaQuery) use ($searchTerm) {
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
                $querySuppliers->where('country', $countryData->id);
            }
        }
        // Filter by Category
        if ($request->has('category') && !empty($request->category)) {
            $querySuppliers->whereHas('company', function ($q) use ($request) {
                $q->where('category_1', $request->category);
            });
        }

        // Filter by Subcategory
        if ($request->has('subcategory') && !empty($request->subcategory)) {
            $querySuppliers->whereHas('company', function ($q) use ($request) {
                $q->where('category_2', $request->subcategory);
            });
        }

        // Filter by Business Type
        if ($request->has('business_type') && !empty($request->business_type)) {
            $querySuppliers->whereHas('company', function ($q) use ($request) {
                $q->where('business_type', $request->business_type);
            });
        }

        if ($request->has('product_service') && !empty($request->product_service)) {
            $querySuppliers->whereHas('company', function ($q) use ($request) {
                $q->where(function ($subQuery) use ($request) {
                    $subQuery->where('company_desc', 'LIKE', '%' . $request->product_service . '%')
                        ->orWhere('key1', 'LIKE', '%' . $request->product_service . '%')
                        ->orWhere('key2', 'LIKE', '%' . $request->product_service . '%')
                        ->orWhere('key3', 'LIKE', '%' . $request->product_service . '%')
                        ->orWhere('key4', 'LIKE', '%' . $request->product_service . '%')
                        ->orWhere('key5', 'LIKE', '%' . $request->product_service . '%')
                        ->orWhere('key6', 'LIKE', '%' . $request->product_service . '%')
                        ->orWhere('key7', 'LIKE', '%' . $request->product_service . '%')
                        ->orWhere('key8', 'LIKE', '%' . $request->product_service . '%')
                        ->orWhere('key9', 'LIKE', '%' . $request->product_service . '%')
                        ->orWhere('key10', 'LIKE', '%' . $request->product_service . '%');
                });
            });
        }

        // $suppliers = $querySuppliers->orderByRaw("
        // (CASE 
        //     WHEN EXISTS (SELECT 1 FROM seller_packages sp 
        //                 JOIN member_packages p ON sp.package_id = p.id 
        //                 WHERE users.id = sp.seller_id AND p.type = 'platinum') THEN 1
        //     WHEN EXISTS (SELECT 1 FROM seller_packages sp 
        //                 JOIN member_packages p ON sp.package_id = p.id 
        //                 WHERE users.id = sp.seller_id AND p.type = 'gold') THEN 2
        //     ELSE 3
        // END)
        // ")->paginate($pageItem);
        $suppliers = $querySuppliers->orderByRaw("
            CASE 
                WHEN EXISTS (
                    SELECT 1 FROM seller_packages sp 
                    JOIN member_packages p ON sp.package_id = p.id 
                    WHERE users.id = sp.seller_id AND p.type = 'platinum'
                ) THEN 1
                WHEN EXISTS (
                    SELECT 1 FROM seller_packages sp 
                    JOIN member_packages p ON sp.package_id = p.id 
                    WHERE users.id = sp.seller_id AND p.type = 'gold'
                ) THEN 2
                WHEN EXISTS (
                    SELECT 1 FROM seller_packages sp 
                    JOIN member_packages p ON sp.package_id = p.id 
                    WHERE users.id = sp.seller_id AND p.type = 'silver'
                ) THEN 3
                WHEN EXISTS (
                    SELECT 1 FROM seller_packages sp 
                    JOIN member_packages p ON sp.package_id = p.id 
                    WHERE users.id = sp.seller_id AND p.type = 'bronze'
                ) THEN 4
                ELSE 5
            END
        ")->paginate($pageItem);



        foreach ($suppliers as $seller) {
            $seller->average_rating = null;
            $seller->country = countries::where('id', $seller->country)->first();
            $seller->state = states::where('id', $seller->state)->first();
            $seller->average_rating = number_format($seller->ratings()->avg('rate'));
        }
        // dd($suppliers);
        return view('external-user.all-suppliers', compact('categories', 'countries', 'suppliers'));
    }

    public function getSubCategory(Request $request)
    {
        $categories = [];
        if (isset($request->id)) {
            $categories = CustomeCategory::where('status', "1")->where('deleted', "0")->where('parent_id', $request->id)->orderBy('category_name', 'ASC')->get();
        }
        return response()->json(['status' => true, 'categories' => $categories]);
    }

    public function getStates(Request $request)
    {
        $states = [];
        if (isset($request->id)) {
            $states = states::where('status', "1")->where('country_id', $request->id)->orderBy('name', 'ASC')->get();
        }
        return response()->json(['status' => true, 'states' => $states]);
    }
}
