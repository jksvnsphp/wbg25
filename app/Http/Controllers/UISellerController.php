<?php

namespace App\Http\Controllers;

use App\Models\company_certificate;
use App\Models\countries;
use App\Models\products;
use App\Models\Rating;
use App\Models\seller_package;
use App\Models\SellerNews;
use App\Models\states;
use App\Models\Tender;
use App\Models\User;
use Illuminate\Http\Request;

class UISellerController extends Controller
{
    //
    public function profilePreview($code)
    {
        $seller = User::where('ref_no', $code)
            ->with(['company', 'exports', 'social', 'profile_meta'])
            ->first();

        if ($seller) {
            $query = User::where('account_type', 'seller')
                ->where('isComplete', 1)
                ->where('status', 1)
                ->where('id', $seller->id)
                ->with('company', 'sellerPackage')
                ->whereHas('company', function ($companyQuery) {
                    $companyQuery->whereNotNull('spotlight_banner')
                        ->whereNotNull('spotlight_preview1');
                })
                ->whereHas('sellerPackage', function ($query) {
                    $query->whereHas('package', function ($subQuery) {
                        $subQuery->whereIn('type', ['gold', 'platinum']);
                    })
                        ->where(function ($expireQuery) {
                            $expireQuery->whereNull('expire_at')
                                ->orWhere('expire_at', '>', now());
                        });
                });
            $spotlights = $query->orderByRaw("
                (CASE 
                    WHEN EXISTS (SELECT 1 FROM seller_packages sp 
                                JOIN member_packages p ON sp.package_id = p.id 
                                WHERE users.id = sp.seller_id AND p.type = 'platinum') THEN 1
                    WHEN EXISTS (SELECT 1 FROM seller_packages sp 
                                JOIN member_packages p ON sp.package_id = p.id 
                                WHERE users.id = sp.seller_id AND p.type = 'gold') THEN 2
                    ELSE 3
                END)
                ")->first();


            $packageData = seller_package::latest()->where('seller_id', $seller->id)->with('package')->first();
            $certificates = company_certificate::where('vendor_id', $seller->id)->get();
            $seller->country = countries::where('id', $seller->country)->first();
            $seller->state = states::where('id', $seller->state)->first();

            $latestNews = SellerNews::where('vendor_id', $seller->id)->where('isPublish', 1)->latest()->first();
            $latestProduct = products::latest()->where('vendor_id', $seller->id)->with('gallery')->where('isList', 1)->first();
            $latestTender = Tender::latest()->where('vendor_id', $seller->id)->where('status', 1)->first();


            $averageRating = Rating::where('vendor_id', $seller->id)->avg('rate');
            $fiveStarCount = Rating::where('vendor_id', $seller->id)->where('rate', 5)->count();
            $fourStarCount = Rating::where('vendor_id', $seller->id)->where('rate', 4)->count();
            $threeStarCount = Rating::where('vendor_id', $seller->id)->where('rate', 3)->count();
            $twoStarCount = Rating::where('vendor_id', $seller->id)->where('rate', 2)->count();
            $oneStarCount = Rating::where('vendor_id', $seller->id)->where('rate', 1)->count();
            $totalRatings = Rating::where('vendor_id', $seller->id)->count();
            $fiveStarPercent = $totalRatings > 0 ? ($fiveStarCount / $totalRatings) * 100 : 0;
            $fourStarPercent = $totalRatings > 0 ? ($fourStarCount / $totalRatings) * 100 : 0;
            $threeStarPercent = $totalRatings > 0 ? ($threeStarCount / $totalRatings) * 100 : 0;
            $twoStarPercent = $totalRatings > 0 ? ($twoStarCount / $totalRatings) * 100 : 0;
            $oneStarPercent = $totalRatings > 0 ? ($oneStarCount / $totalRatings) * 100 : 0;
            $ratingData = [
                'totalRatings' => $totalRatings,
                'averageRating' => number_format($averageRating, 1),
                'fiveStarCount' => $fiveStarCount,
                'fourStarCount' => $fourStarCount,
                'threeStarCount' => $threeStarCount,
                'twoStarCount' => $twoStarCount,
                'oneStarCount' => $oneStarCount,
                'fiveStarPercent' => $fiveStarPercent,
                'fourStarPercent' => $fourStarPercent,
                'threeStarPercent' => $threeStarPercent,
                'twoStarPercent' => $twoStarPercent,
                'oneStarPercent' => $oneStarPercent,
                'spotlights' => $spotlights,
            ];

            return view('external-user.supplier-profile-view', compact('certificates', 'ratingData', 'seller', 'packageData', 'latestNews', 'latestProduct', 'latestTender'));
        } else {
            abort(404);
        }
    }
}
