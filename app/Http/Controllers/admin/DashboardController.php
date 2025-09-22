<?php

namespace App\Http\Controllers\admin;

use App\Models\business_profile_symbol;
use App\Models\company;
use App\Models\CounterOfferQuotation;
use App\Models\CounterOfferTender;
use App\Models\countries;
use App\Models\CustomeCategory;
use App\Models\inbox;
use App\Models\memberPackage;
use App\Models\OfferQuotation;
use App\Models\OfferTender;
use App\Models\Order;
use App\Models\packageService;
use App\Models\Quotation;
use App\Models\seller_package;
use App\Models\User;
use App\Models\Tender;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class DashboardController extends Controller
{
    //
    public function dashboard(){
        return view('admin.dashboard');
    }

    















    // Random UI Route
    public function showSellers(Request $request)
{
     
        
        $query = User::where('account_type', 'seller')
    ->with('countryData', 'sellerPackage','company','exports','social')
    ->leftJoin('companies', 'users.id', '=', 'companies.vendor_id')
    ->select('users.*');

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
    // Search filter
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
          $q->where('companies.name', 'like', "%{$search}%")
          ->orWhere('users.first_name', 'like', "%{$search}%")
          ->orWhere('users.email', 'like', "%{$search}%");
        });
    }

    // Country filter
    if ($request->filled('country')) {
        $query->whereHas('countryData', function ($q) use ($request) {
            $q->where('name', $request->country);
        });
    }

    // Sort (optional)
    if ($request->filled('sort') && $request->sort == 'oldest') {
        $query->oldest();
    } else {
        $query->latest();
    }

    $sellers = $query->paginate(10)->withQueryString();
    // echo "<pre>";
    // print_r($sellers->toArray());
    // echo "</pre>";  die;

    return view('admin.sellers.index', compact('sellers','countries'));
}
    public function showBuyers(){
        $buyers = User::where('account_type', 'buyer')->with('countryData','sellerPackage')->latest()->get();
        return view('admin.all-buyers', compact('buyers'));
    }
    public function showAllAdmins(){
        $admins = User::where('account_type', 'admin')->with('countryData','sellerPackage')->latest()->get();
        return view('admin.all-admins', compact('admins'));
    }
   public function productApproval()
{
    // Example: Assuming you have a Product model with relations to User (seller)
    $products = \App\Models\Product::with('seller') // seller = belongsTo(User::class, 'user_id')
        ->latest()
        ->paginate(10);

    return view('admin.approval-center.product-approval', compact('products'));
}

    public function sellerApproval(){
          $tenders = Tender::with(['vendor']) // eager load seller/buyer
           // ->where('type', 'buy') // assuming you have a type column ('buy'/'sell')
            ->latest()
            ->paginate(10);

        return view('admin.approval-center.seller-approval',compact('tenders'));
        
    }
    public function buyTenderApproval(){
                // Fetch only buy tenders
        $tenders = Tender::with(['vendor']) // eager load seller/buyer
           // ->where('type', 'buy') // assuming you have a type column ('buy'/'sell')
            ->latest()
            ->paginate(10);

        return view('admin.approval-center.buy-tender-approval',compact('tenders'));
    }
    public function sellTenderApproval(){
       // die('here');
                // Fetch only sell tenders
         $tenders = Tender::with(['vendor']) // eager load seller/buyer
           // ->where('type', 'buy') // assuming you have a type column ('buy'/'sell')
            ->latest()
            ->paginate(10);
        return view('admin.approval-center.sell-tender-approval',   compact('tenders'));
    }
    public function paymentCenter(){
      //  die( 'here');
        return view('admin.payment.payment-center');
    }
    public function productManagement(){
        return view('admin.product_managment.product-manager');
    }
    public function buyTradeList(){
        return view('admin.tenders_management.buy-trades');
    }
    public function sellTradeList(){
 
        return view('admin.tenders_management.sell-trades');
    }
    public function adsBanners(){
        return view('admin.ads-banners.ads-and-banners');
    }
    public function allBuyQuotation(){
        return view('admin.all-buy-quotations');
    }
    public function addNewBanner(){
        return view('admin.ads-banners.add-new-banner');
    }
    public function showBanner(){
        return view('admin.ads-banners.show-banners');
    }
    public function seoManagements(){
        return view('admin.seo.seo-management');
    }
    public function addNewSeo(){
        return view('admin.seo.add-new-seo');
    }
    public function enquiryBox(){
      // Get only buyer inquiries (filter by message_type if needed)
        $inquiries = Inbox::with(['sender', 'receiver'])
            ->where('message_type', 'inquiry') // adjust if your type is different
            ->latest()
            ->paginate(10);
        return view('admin.enquiry.enquiry-box', compact('inquiries'));
    }
    public function adminEnquiryBox(){
        return view('admin.enquiry.admin-enquiry-box');
    }
    public function adminEmailTemplates(){
        return view('admin.email-template.email-templates');
    }
    public function adminAddEmailTemplate(){
        return view('admin.email-template.add-new-template');
    }
    public function adminBulkMailSend(){
        return view('admin.email-template.bulk-email-send');
    }
    public function adminVideoShow(){
        return view('admin.video-shows.video-shows');
    }
    public function advertisementEnquiry(){
        return view('admin.enquiry.advertisement_enquiry');
    }

}
