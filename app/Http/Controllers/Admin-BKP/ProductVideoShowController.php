<?php

namespace App\Http\Controllers\admin;

use App\Models\countries;
use App\Models\parent_category;
use App\Models\products;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProductVideoShowController extends Controller
{
    //
    public function index(Request $request)
    {
        $categories = parent_category::where('status', "1")->orderBy('name', 'ASC')->get();
        $countries = countries::orderBy('name', 'ASC')->get();
        // dd($categories);
        $queryp = products::latest()->with('video', 'vendor.company')
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
            });
        if ($request->has('product_name') && $request->input('product_name') != "") {
            $product_name = $request->input('product_name');
            $queryp->where('name', 'like', '%' . $product_name . '%');
        }
        if ($request->has('category') && $request->input('category') != "") {
            $category = $request->input('category');
            $queryp->where('parent_category_id', $category);
        }
        if ($request->has('subcategory') && $request->input('subcategory') != "") {
            $subcategory = $request->input('subcategory');
            $queryp->where('category_id', $subcategory);
        }
        if ($request->has('supplier') && $request->input('supplier') != "") {
            $supplier = $request->input('supplier');
            $queryp->where('vendor_id', $supplier);
        }
        if ($request->has('country') && $request->country != '') {
            $countryData = countries::where('name', $request->country)->first();
            if ($countryData != null) {
                $queryp->whereHas('vendor', function ($query) use ($countryData) {
                    $query->where('country', $countryData->id);
                });
            }
        }

        $pageItem = 5;
        if ($request->has('pageItem') && $request->filled('pageItem')) {
            $pageItem = $request->pageItem ?? 5;
        }
        $products = $queryp->paginate($pageItem);
        foreach ($products as $product) {
            $product->country = null;
            if (isset($product->vendor->country)) {
                $product->country = countries::where('id', $product->vendor->country)->first();
            }
            $product->average_rating = null;
            $product->average_rating = number_format($product->ratings()->avg('rate'));
        }
        $suppliers = User::query()
            ->where(['isComplete' => 1, 'status' => 1, 'account_type' => 'seller'])
            ->with('company')
            ->whereHas('company', function ($sq) {
                $sq->where('id', "!=", "");
            })->latest()->get();
           // echo "<pre>"; print_r($products[0]->video->toArray()); exit;
        return view('admin.video-shows.index', compact('categories', 'countries','products','suppliers'));
    }
}
