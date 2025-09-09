<?php

namespace App\Http\Controllers;

use App\Models\countries;
use Illuminate\Http\Request;

class UISupplierRegionController extends Controller
{
    //
    public function allsupplier_region()
    {
        $supplier_region = countries::orderBy('name', 'ASC')->paginate(48);
        return view('external-user.supplier-regions', compact('supplier_region'));
    }
}
