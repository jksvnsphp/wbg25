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
use App\Models\SeoMeta;
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
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Random UI Route
    public function showSellers(Request $request)
    {
        $query = User::where('account_type', 'seller')
            ->with('countryData', 'sellerPackage', 'company', 'exports', 'social')
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

        return view('admin.sellers.index', compact('sellers', 'countries'));
    }
    public function showBuyers()
    {
        $buyers = User::where('account_type', 'buyer')->with('countryData', 'sellerPackage')->latest()->get();
        return view('admin.all-buyers', compact('buyers'));
    }
    public function showAllAdmins()
    {
        $admins = User::where('account_type', 'admin')->with('countryData', 'sellerPackage')->latest()->get();
        return view('admin.all-admins', compact('admins'));
    }
    public function productApproval()
    {
        // Example: Assuming you have a Product model with relations to User (seller)
        $products = collect([]); // Replace with actual product fetching logic

        return view('admin.approval-center.product-approval', compact('products'));
    }

    public function sellerApproval()
    {
        $tenders = Tender::with(['vendor']) // eager load seller/buyer
            // ->where('type', 'buy') // assuming you have a type column ('buy'/'sell')
            ->latest()
            ->paginate(10);

        return view('admin.approval-center.seller-approval', compact('tenders'));
    }
    public function buyTenderApproval()
    {
        // Fetch only buy tenders
        $tenders = Tender::with(['vendor']) // eager load seller/buyer
            // ->where('type', 'buy') // assuming you have a type column ('buy'/'sell')
            ->latest()
            ->paginate(10);

        return view('admin.approval-center.buy-tender-approval', compact('tenders'));
    }
    public function sellTenderApproval()
    {
        // die('here');
        // Fetch only sell tenders
        $tenders = Tender::with(['vendor']) // eager load seller/buyer
            // ->where('type', 'buy') // assuming you have a type column ('buy'/'sell')
            ->latest()
            ->paginate(10);
        return view('admin.approval-center.sell-tender-approval',   compact('tenders'));
    }
    public function paymentCenter1(Request $request)
    {
        $query = seller_package::with(['user', 'package']);

        if ($request->filled('payment')) {
            if ($request->payment == 1) {
                $query->where('payment_status', 'paid');
            } elseif ($request->payment == 2) {
                $query->where('payment_status', 'pending');
            }
        }

        if ($request->filled('package')) {
            $query->whereHas('package', function ($q) use ($request) {
                $q->where('type', $request->package);
            });
        }

        $records = $query->orderBy('id', 'desc')
            ->paginate(10)
            ->appends($request->all());

        //print_r($records);				 

        return view('admin.payment.payment-center', compact('records'));
    }

    public function paymentCenter()
    {
        $packages = memberPackage::orderBy('name', 'asc')->get();

        // Optionally, get all payment statuses if you want dynamic status select
        $paymentStatuses = [
            ['id' => 1, 'name' => 'Complete'],
            ['id' => 2, 'name' => 'Pending']
        ];

        return view('admin.payment.payment-center', compact('packages', 'paymentStatuses'));
    }

    public function destroyPackage($id)
    {
        $record = seller_package::findOrFail($id);
        $record->delete();

        return response()->json(['status' => true, 'message' => 'Payment deleted successfully']);
    }




    public function paymentCenterAjax(Request $request)
    {
        // Use query with package join for proper filtering
        $query = seller_package::with(['user', 'package']);

        // FILTER PAYMENT STATUS
        if ($request->filled('payment')) {
            if ($request->payment == 1) {
                $query->where('payment_status', 'paid');
            } elseif ($request->payment == 2) {
                $query->where('payment_status', 'pending');
            }
        }

        // FILTER PACKAGE TYPE
        if ($request->filled('package')) {
            $packageId = $request->package; // select value should be package id
            $query->where('package_id', $packageId);
        }

        // SEARCH
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->search}%")
                    ->orWhere('last_name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%")
                    ->orWhere('phone', 'like', "%{$request->search}%");
            });
        }

        // PAGINATION
        $records = $query->orderBy('id', 'desc')->paginate(10)->appends($request->all());

        // RETURN TABLE HTML ONLY
        return response()->json([
            'html' => view('admin.payment.ajax-table', compact('records'))->render()
        ]);
    }



    public function productManagement()
    {
        return view('admin.product_managment.product-manager');
    }
    public function buyTradeList()
    {
        $quotations = Quotation::where('isDeal', 1)->latest()
            // ->where('user_id', auth()->user()->id)
            //->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()])
            ->with('category')->paginate(10);
        //echo "<pre/>";
        //print_r($quotations);die;


        return view('admin.quotation_management.quotationl', compact('quotations'));
    }
    public function sellTradeList()
    {

        return view('admin.tenders_management.sell-trades');
    }
    public function adsBanners()
    {
        return view('admin.ads-banners.ads-and-banners');
    }
    public function allBuyQuotation()
    {
        return view('admin.all-buy-quotations');
    }
    public function addNewBanner()
    {
        return view('admin.ads-banners.add-new-banner');
    }
    public function showBanner()
    {
        return view('admin.ads-banners.show-banners');
    }
    public function seoManagements()
    {
        $seo = SeoMeta::all();
        return view('admin.seo.seo-management', compact('seo'));
    }

    public function seo_show($id)
    {
        $seo = SeoMeta::findOrFail($id);
        return view('admin.seo.view', compact('seo'));
    }

    public function seo_edit($id)
    {
        $seo = SeoMeta::findOrFail($id);
        return view('admin.seo.edit', compact('seo'));
    }
    public function seo_update(Request $request, $id)
    {
        $seo = SeoMeta::findOrFail($id);

        $request->validate([
            'page' => 'required|unique:seo_meta,page,' . $seo->id,
            'title' => 'required',
            'keywords' => 'required',
            'description' => 'required',
        ]);

        $seo->update($request->all());

        return redirect()->route('admin.seo.manager')->with('success', 'SEO updated successfully');
    }


    public function seo_destroy($id)
    {
        SeoMeta::destroy($id);

        return response()->json(['message' => 'SEO entry deleted successfully']);
    }


    public function addNewSeo()
    {
        return view('admin.seo.add-new-seo');
    }

    public function seo_store(Request $request)
    {
        $request->validate([
            'page' => 'required',
            'title' => 'required',
            'keywords' => 'required',
            'description' => 'required'
        ]);

        SeoMeta::updateOrCreate(
            ['page' => $request->page],
            [
                'title' => $request->title,
                'keywords' => $request->keywords,
                'description' => $request->description,
            ]
        );
        return redirect()->route('admin.seo.manager')->with([
            'alert-type' => 'success',
            'message' => 'SEO Meta Information Saved Successfully'
        ]);
    }







    public function enquiryBox()
    {
        // Get only buyer inquiries (filter by message_type if needed)
        $inquiries = Inbox::with(['sender', 'receiver'])
            ->where('message_type', 'inquiry') // adjust if your type is different
            ->latest()
            ->paginate(10);
        return view('admin.enquiry.enquiry-box', compact('inquiries'));
    }
    public function adminEnquiryBox()
    {
        return view('admin.enquiry.admin-enquiry-box');
    }
    public function adminEmailTemplates()
    {
        return view('admin.email-template.email-templates');
    }
    public function adminAddEmailTemplate()
    {
        return view('admin.email-template.add-new-template');
    }
    public function adminBulkMailSend()
    {
        return view('admin.email-template.bulk-email-send');
    }
    public function adminVideoShow()
    {
        return view('admin.video-shows.video-shows');
    }
    public function advertisementEnquiry()
    {
        return view('admin.enquiry.advertisement_enquiry');
    }
}
