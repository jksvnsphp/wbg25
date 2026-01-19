<?php

namespace App\Http\Controllers;

use App\Models\countries;
use App\Models\parent_category;
use App\Models\SellerNews;
use App\Models\states;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UINewsController extends Controller
{
    public function index(Request $request)
    {
        $categories = parent_category::where('status', "1")->orderBy('name', 'ASC')->get();
        $countries = countries::orderBy('name', 'ASC')->get();
        $suppliers = User::query()
            ->where(['isComplete' => 1, 'status' => 1, 'account_type' => 'seller'])
            ->with('company')
            ->whereHas('company', function ($sq) {
                $sq->where('id', "!=", "");
            })->latest()->get();

        $newsQuery = SellerNews::where('isPublish', 1)->with('vendor.company')->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [now()]);

        // Filter by order_type: all, latest, endest-soon
        $orderType = $request->input('order_type', 'all'); // default to 'all'

        if ($orderType === 'latest') {
            $newsQuery->latest('created_at');
        } elseif ($orderType === 'expired-soon') {
            // Order by expiry date ascending (soonest to expire first)
            $newsQuery->orderByRaw('DATE_ADD(created_at, INTERVAL duration DAY) ASC');
        } else {
            // For 'all' or any other value, default order
            $newsQuery->latest();
        }

        if ($request->has('date') && $request->date != '') {
            $newsQuery->whereDate('created_at', $request->date);
        }

        if ($request->has('topic') && $request->topic != '') {
            $newsQuery->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->topic . '%')
                    ->orWhere('short_description', 'like', '%' . $request->topic . '%')
                    ->orWhere('description', 'like', '%' . $request->topic . '%');
            });
        }

        if ($request->has('category') && $request->category != '') {
            $newsQuery->where('category_id', $request->category);
        }
        if ($request->has('subcategory') && $request->subcategory != '') {
            $newsQuery->where('subcategory_id', $request->subcategory);
        }

        if ($request->has('supplier') && $request->supplier != '') {
            $newsQuery->where('vendor_id', $request->supplier);
        }

        if ($request->has('country') && $request->country != '') {
            $countryData = countries::where('name', $request->country)->first();
            if ($countryData != null) {
                $newsQuery->whereHas('vendor', function ($query) use ($countryData) {
                    $query->where('country', $countryData->id);
                });
            }
        }

        $pageItem = 4;
        if ($request->has('pageItem') && $request->filled('pageItem')) {
            $pageItem = $request->pageItem ?? 5;
        }

        $news = $newsQuery->paginate($pageItem);

        foreach ($news as $new) {
            $new->country = null;
            $new->state = null;
            if (isset($new->vendor->country)) {
                $new->country = countries::where('id', $new->vendor->country)->first();
            }
            $new->average_rating = null;
            $new->average_rating = number_format($new->ratings()->avg('rate'));

            // Add expiry info for UI if needed
            $expiryDate = Carbon::parse($new->created_at)->addDays($new->duration);
            $new->expiry_date = $expiryDate->format('Y M d | H:i');
            $new->is_expired = now()->greaterThanOrEqualTo($expiryDate);
        }

        return view('external-user.news', compact('categories', 'suppliers', 'countries', 'news'));
    }




    public function readNews($slug = null)
    {
        $news = SellerNews::where('slug', $slug)->where('isPublish', 1)->with('vendor.company', 'vendor.ratings')->first();
        $news->country = null;
        $news->state = null;
        if (isset($news->vendor->country)) {
            $news->country = countries::where('id', $news->vendor->country)->first();
        }
        if (isset($news->vendor->state)) {
            $news->state = states::where('id', $news->vendor->state)->first();
        }
        $news->average_rating = null;
        $news->average_rating = number_format($news->vendor->ratings()->avg('rate'));
        // dd($news->toArray());
        return view('external-user.read-news', compact('news'));
    }
}
