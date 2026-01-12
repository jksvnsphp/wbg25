<?php

namespace App\Http\Controllers;

use App\Models\countries;
use App\Models\CustomeCategory;
use App\Models\OfferQuotation;
use App\Models\parent_category;
use App\Models\Quotation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SourceProController extends Controller
{
    //
    public function sourcePro_old_05_06_(Request $request)
    {
        $categories = CustomeCategory::where('status', "1")->where('deleted', "0")->where('parent_id', "0")->orderBy('category_name', 'ASC')->get();
        $countries = countries::orderBy('name', 'ASC')->get();
        $queryT = Quotation::query()->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()]);
        $queryT->where('status', 'pending')->with('vendor');

        if ($request->has('country') && $request->input('country') != "") {
            $country = $request->input('country');
            $countryData = countries::where('name', $country)->first();
            if ($countryData) {
                $queryT->whereHas('vendor', function ($query) use ($countryData) {
                    $query->where('country', $countryData->id);
                });
            }
        }
        if ($request->has('keywords') && $request->input('keywords') != "") {
            $keywords = explode(',', $request->input('keywords'));
            $queryT->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $keyword = trim($keyword);
                    $q->orWhere('product_service', 'LIKE', "%$keyword%")
                        ->orWhere('requirement_details', 'LIKE', "%$keyword%");
                }
            });
        }
        if ($request->has('category') && !empty($request->category)) {
            $queryT->where('category_id', $request->category);
        }
        $pageItem = 12;
        if ($request->has('pageItem') && $request->filled('pageItem')) {
            $pageItem = $request->pageItem ?? 12;
        }
        $quotations = $queryT->latest()->paginate($pageItem);
        foreach ($quotations as $quotation) {
            $quotation->country = null;
            if (isset($quotation->vendor->country)) {
                $quotation->country = countries::where('id', $quotation->vendor->country)
                    ->first();
            }
            $expiryDate = Carbon::parse($quotation->created_at)->addDays($quotation->duration);
            $isExpired = now()->greaterThanOrEqualTo($expiryDate);
            $quotation->expiry_date = $expiryDate->format('Y M d | H:i');
        }
        return view('external-user.source-pro', compact('categories', 'countries', 'quotations'));
    }
    
    public function sourcePro(Request $request)
{
    $categories = CustomeCategory::where('status', "1")
        ->where('deleted', "0")
        ->where('parent_id', "0")
        ->orderBy('category_name', 'ASC')
        ->get();

    $countries = countries::orderBy('name', 'ASC')->get();

    $queryT = Quotation::query()
        ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()])
        ->where('status', 'pending')
        ->with('vendor');

    // Filter by country name if provided
    if ($request->has('country') && $request->input('country') != "") {
        $country = $request->input('country');
        $countryData = countries::where('name', $country)->first();
        if ($countryData) {
            $queryT->whereHas('vendor', function ($query) use ($countryData) {
                $query->where('country', $countryData->id);
            });
        }
    }

    // Filter by keywords if provided
    if ($request->has('keywords') && $request->input('keywords') != "") {
        $keywords = explode(',', $request->input('keywords'));
        $queryT->where(function ($q) use ($keywords) {
            foreach ($keywords as $keyword) {
                $keyword = trim($keyword);
                $q->orWhere('product_service', 'LIKE', "%$keyword%")
                    ->orWhere('requirement_details', 'LIKE', "%$keyword%");
            }
        });
    }

    // Filter by category if provided
    if ($request->has('category') && !empty($request->category)) {
        $queryT->where('category_id', $request->category);
    }

    // Handle order_type filter
    $orderType = $request->input('order_type', 'all'); // default 'all'

    if ($orderType === 'expired-soon') {
        // order by expiry date ascending = created_at + duration days ascending
        $queryT->orderByRaw('DATE_ADD(created_at, INTERVAL duration DAY) ASC');
    } elseif ($orderType === 'latest') {
        // order by creation date descending
        $queryT->orderBy('created_at', 'DESC');
    } else {
        // default, order by latest (created_at descending)
        $queryT->orderBy('created_at', 'DESC');
    }

    // Pagination count
    $pageItem = 8;
    if ($request->has('pageItem') && $request->filled('pageItem')) {
        $pageItem = $request->pageItem ?? 8;
    }

    $quotations = $queryT->paginate($pageItem);

    // Add expiry_date and country info to each quotation
    foreach ($quotations as $quotation) {
        $quotation->country = null;
        if (isset($quotation->vendor->country)) {
            $quotation->country = countries::where('id', $quotation->vendor->country)->first();
        }
        $expiryDate = Carbon::parse($quotation->created_at)->addDays($quotation->duration);
        $expiryDate = Carbon::parse($expiryDate)->format('d-M-Y').' | '.now()->diffInDays($expiryDate, false).'d '.(now()->diffInMinutes($expiryDate, false) % 60).'m';
        $quotation->expiry_date = $expiryDate ;//$expiryDate->format('Y M d | H:i');
    }

    return view('external-user.source-pro', compact('categories', 'countries', 'quotations'));
}
    
    public function sourceProDetail($slug)
    {
        $quotation = Quotation::where('slug', $slug) 
            ->where('status', 'pending')
            ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()])
            ->with('vendor')
            ->first();
        $quotation->country = null;
        if (isset($quotation->vendor->country)) {
            $quotation->country = countries::where('id', $quotation->vendor->country)
                ->first();
        }
        if ($quotation) {
             $expiryDate = Carbon::parse($quotation->created_at)->addDays($quotation->duration);
             $isExpired = now()->greaterThanOrEqualTo($expiryDate);
             $expiryDate = Carbon::parse($expiryDate)->format('d-M-Y').' | '.now()->diffInDays($expiryDate, false).'d '.(now()->diffInMinutes($expiryDate, false) % 60).'m';
             $quotation->expiry_date = $expiryDate ;//$expiryDate->format('Y M d | H:i');
             //$quotation->expiry_date = $expiryDate->format('d M Y | H:i');
            return view('external-user.source-pro-detail', compact('quotation'));
        } else {
            return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Quotation is more in store!']);
        }
    }

   public function sendOffer(Request $request)
{
    if (!auth()->check()) {
        return response()->json([
            'status' => false,
            'message' => 'You must be logged in to submit an offer!',
            'code' => 403
        ], 200);
    }

    // Validation
    $validator = Validator::make($request->all(), [
        'quotation_id' => 'required|exists:quotations,id',
        'offer_price'  => 'required|numeric|min:1',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation failed!',
            'error' => $validator->errors()
        ], 200);
    }

    $quotation = Quotation::find($request->quotation_id);

    if (!$quotation) {
        return response()->json([
            'status' => false,
            'message' => 'Quotation not found!'
        ], 200);
    }

    // Owner check
    if ($quotation->user_id == auth()->id()) {
        return response()->json([
            'status' => false,
            'message' => 'You are the owner of this quotation.'
        ], 200);
    }

    // Duplicate offer check
    $alreadyOffered = OfferQuotation::where([
        'quotation_id' => $quotation->id,
        'user_id'      => auth()->id()
    ])->exists();

    if ($alreadyOffered) {
        return response()->json([
            'status' => false,
            'message' => 'You have already submitted a quote for this quotation.'
        ], 200);
    }

    // Create offer
    OfferQuotation::create([
        'user_id'      => auth()->id(),
        'vendor_id'    => $quotation->user_id,
        'quotation_id' => $quotation->id,
        'offer_price'  => $request->offer_price,
        'status'       => 'pending',
    ]);

    // ---------------- SEND MAIL (USING HELPER) ----------------
    $seller = User::find($quotation->user_id);

    sendDynamicMail(
        $seller->id,
        'quotation_new_offer_seller', // slug from email_templates
        [
            '[Seller Name]'     => $seller->first_name,
            '[Quotation Name]'  => $quotation->product_service,
            '[Offer Price]'     => $request->offer_price,
            '[Buyer Name]'      => auth()->user()->first_name . ' ' . auth()->user()->last_name,
            '[Buyer Email]'     => auth()->user()->email,
            '[Button URL]'      => route('user.source-pro.detail', $quotation->slug),
        ]
    );

    session()->flash('success', 'Congratulations! Your quote has been submitted successfully.');

    $redirectUrl = auth()->user()->account_type === 'seller'
        ? route('seller.success.offer.tender', $quotation->slug)
        : route('buyer.success.offer.tender', $quotation->slug);

    return response()->json([
        'status'  => true,
        'message' => 'Your Quote has been submitted successfully!',
        'url'     => $redirectUrl
    ], 200);
}

}
