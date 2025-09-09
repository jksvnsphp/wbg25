<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    //
    public function addStaticPage(){
        return view('admin.static-page.add-static-page');
    }
    public function allStaticPage(){
        return view('admin.static-page.all-static-page');
    }
    public function allCMSPage(){
        return view('admin.static-page.cms-page-list');
    }
}
