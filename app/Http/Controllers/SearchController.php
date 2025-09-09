<?php

namespace App\Http\Controllers;

use App\Models\company;
use App\Models\memberPackage;
use App\Models\products;
use App\Models\Tender;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('search');
        $category = $request->input('type-filter');
        $route = match ($category) {
            'products'  => 'all.products',
            'stores'    => 'all.spotlight',
            'tenders'   => 'all.tenders',
            'suppliers' => 'all.suppliers',
            default     => 'search.no_results',
        };
        if ($route == 'search.no_results') {
            return abort(404);
        }
        return redirect()->route($route, ['type-filter'=>$category,'q' => $query]);
    }


    private function getStores($query)
    {
        return company::whereNotNull('spotlight_banner')
            ->whereNotNull('spotlight_preview1')
            ->whereNotNull('spotlight_preview2')
            ->whereNotNull('spotlight_preview3')
            ->whereNotNull('spotlight_preview4')
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhereHas('vendor', function ($q) use ($query) {
                        $q->where('first_name', 'LIKE', "%{$query}%")
                            ->orWhere('last_name', 'LIKE', "%{$query}%")
                            ->orWhere('ref_no', 'LIKE', "%{$query}%");
                    })
                    ->orWhere(function ($q) use ($query) {
                        for ($i = 1; $i <= 10; $i++) {
                            $q->orWhere("key{$i}", 'LIKE', "%{$query}%");
                        }
                    });
            })
            ->with(['vendor.sellerPackage' => function ($q) {
                $q->join('member_packages', 'seller_packages.package_id', '=', 'member_packages.id')
                    ->select('seller_packages.seller_id', 'member_packages.type', 'seller_packages.expire_at');
            }])
            ->get();
    }

    private function getTenders($query)
    {
        $tenders = Tender::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($tenders);
    }

    private function getSuppliers($query)
    {
        $suppliers = User::where('account_type', 'seller')
            ->where(function ($q) use ($query) {
                $q->where('first_name', 'LIKE', "%{$query}%")
                    ->orWhere('last_name', 'LIKE', "%{$query}%")
                    ->orWhere('ref_no', 'LIKE', "%{$query}%");
            })
            ->get();

        return response()->json($suppliers);
    }
}
