<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function dashboard(){
        return view('admin.dashboard');
    }

    














    // Random UI Route
    public function showSellers(){
        return view('admin.all-seller');
    }
    public function productApproval(){
        return view('admin.approval-center.product-approval');
    }
    public function sellerApproval(){
        return view('admin.approval-center.seller-approval');
    }
    public function buyTenderApproval(){
        return view('admin.approval-center.buy-tender-approval');
    }
    public function sellTenderApproval(){
        return view('admin.approval-center.sell-tender-approval');
    }
    public function paymentCenter(){
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
        return view('admin.enquiry.enquiry-box');
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
