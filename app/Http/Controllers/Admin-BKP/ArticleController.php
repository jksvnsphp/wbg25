<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function businessHelpArticles()
    {
        $icon = "fas fa-user-circle";
        $heading = "Business Profile";
        
        return view('external-user.business-profile-help', compact('icon', 'heading'));
    }

    public function spotlightStoreHelpArticles()
    {
        $subtext = "To use the Spotlight Store & Options you need to be a Gold or Platinum Member.";
        $heading = "Spotlight Store";
       
        return view('external-user.spotlight-store-help', compact('subtext', 'heading'));
    }

    public function productHelpArticles()
    {
        return view('external-user.product-help');
    }
    public function tenderHelpArticles()
    {
        return view('external-user.tender-help');
    }
    public function quotationHelpArticles()
    {
        return view('external-user.quotation-help');
    }

    public function productBuyerHelpArticles()
    {
        return view('external-user.buyer-product-help');
    }
    public function tenderBuyerHelpArticles()
    {
        return view('external-user.buyer-tender-help');
    }
    public function quotationBuyerHelpArticles()
    {
        return view('external-user.buyer-quotation-help');
    }


    public function saleCommissionHelpArticles()
    {
        return view('external-user.sale-provision-help');
    }
}
