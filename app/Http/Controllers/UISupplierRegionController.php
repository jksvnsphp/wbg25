<?php

namespace App\Http\Controllers;

use App\Models\countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UISupplierRegionController extends Controller
{
    //
    public function allsupplier_region1()
    {
        $supplier_region = countries::orderBy('name', 'ASC')->paginate(48);
        return view('external-user.supplier-regions', compact('supplier_region'));
    }
	
	
	
	
	public function allsupplier_region(Request $request)
{
    $businessType = $request->get('business_type', 'all');

    $query = DB::table('companies')
        ->join('users', 'companies.vendor_id', '=', 'users.id')
        ->join('countries', 'users.country', '=', 'countries.id')
        ->select(
            'countries.id',
            'countries.name',
            'countries.iso2',
            DB::raw('COUNT(companies.id) as company_count')
        )
        ->where('companies.status', 1)
        ->whereNotNull('countries.iso2')
        ->groupBy(
            'countries.id',
            'countries.name',
            'countries.iso2'
        );

    if ($businessType !== 'all') {
        $query->where('companies.business_type', $businessType);
    }

    $supplier_region = $query->paginate(12)->withQueryString();

    return view('external-user.supplier-regions', compact('supplier_region'));
}

	
}
