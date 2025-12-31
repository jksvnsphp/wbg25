<?php

namespace App\Http\Controllers;

use App\Models\business_profile_symbol;
use App\Models\seller_package;
use App\Models\packageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusinessProfileSymbolController extends Controller
{
    //
    public function allBusinessSymbol()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $icons = business_profile_symbol::where('vendor_id', '=', $id)->first();
            return view('seller-vendor.business-profile-symbols', compact('icons'));
        } else {
            return redirect()->route('login');
        }
    }
   
    public function addBusinessSymbol(Request $request)
    {
        if (isset(auth()->user()->id)) {

            $id = auth()->user()->id;
            $packageData = seller_package::latest()->where('seller_id', $id)->with('package')->first();
            $packageType = $packageData->package->type ?? '';
            $validator = Validator::make(
                $request->all(),
                [
                    'isTradeAssurance' => ['nullable'],
                    'isTrustSeal' => ['nullable'],
                    'isAssessedSupplier' => ['nullable'],
                    'isOnsiteChecked' => ['nullable'],
                    'isProductVerified' => ['nullable'],
                    'isStoreFavorite' => ['nullable'],
                    'isEmailVerified' => ['nullable'],
                    'isCategoryBest' => ['nullable'],
                    'isSecureTransaction' => ['nullable'],
                    'isSupport' => ['nullable'],
                    'isSecurity' => ['nullable'],

                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Validation failed.']);
            } else {
                $icons = business_profile_symbol::where('vendor_id', $id)->firstOrCreate([
                    'vendor_id' => $id
                ]);
                $verifiedSeal =  packageService::where('serviceName', 'Company + Product Verified Seal')->first();
                $trustSeal = packageService::where('serviceName', 'Company + Product Trust Seal')->first();
                if ($icons) {
                    $icons->isTradeAssurance = $request->isTradeAssurance == "on" ? 1 : 0;

                    $icons->isAssessedSupplier = $request->isAssessedSupplier == "on" ? 1 : 0;
                    $icons->isOnsiteChecked = $request->isOnsiteChecked == "on" ? 1 : 0;
                    if ($trustSeal && $trustSeal->$packageType) {
                        $icons->isTrustSeal = $request->isTrustSeal == "on" ? 1 : 0;
                    } else {
                        $icons->isTrustSeal = 0;
                    }
                    if ($verifiedSeal && $verifiedSeal->$packageType) {
                        $icons->isProductVerified = $request->isProductVerified == "on" ? 1 : 0;
                    } else {
                        $icons->isProductVerified = 0;
                    }
                    $icons->isStoreFavorite = $request->isStoreFavorite == "on" ? 1 : 0;
                    $icons->isEmailVerified = $request->isEmailVerified == "on" ? 1 : 0;
                    $icons->isCategoryBest = $request->isCategoryBest == "on" ? 1 : 0;
                    $icons->isSecureTransaction = $request->isSecureTransaction == "on" ? 1 : 0;
                    $icons->isSupport = $request->isSupport == "on" ? 1 : 0;
                    $icons->isSecurity = $request->isSecurity == "on" ? 1 : 0;
                    $icons->save();
                } else {
                    $icons = new business_profile_symbol();
                    $icons->vendor_id = $id;
                    $icons->isTradeAssurance = $request->isTradeAssurance == "on" ? 1 : 0;
                    $icons->isAssessedSupplier = $request->isAssessedSupplier == "on" ? 1 : 0;
                    $icons->isOnsiteChecked = $request->isOnsiteChecked == "on" ? 1 : 0;
                    if ($trustSeal && $trustSeal->$packageType) {
                        $icons->isTrustSeal = $request->isTrustSeal == "on" ? 1 : 0;
                    } else {
                        $icons->isTrustSeal = 0;
                    }
                    if ($verifiedSeal && $verifiedSeal->$packageType) {
                        $icons->isProductVerified = $request->isProductVerified == "on" ? 1 : 0;
                    } else {
                        $icons->isProductVerified = 0;
                    }
                    $icons->isStoreFavorite = $request->isStoreFavorite == "on" ? 1 : 0;
                    $icons->isEmailVerified = $request->isEmailVerified == "on" ? 1 : 0;
                    $icons->isCategoryBest = $request->isCategoryBest == "on" ? 1 : 0;
                    $icons->isSecureTransaction = $request->isSecureTransaction == "on" ? 1 : 0;
                    $icons->isSupport = $request->isSupport == "on" ? 1 : 0;
                    $icons->isSecurity = $request->isSecurity == "on" ? 1 : 0;
                    $icons->save();
                }
                session()->flash('success', 'Congratulation, Your Profile symbols has updated successfully and is showing online now!');
                return redirect()->route('seller.success.gallery');
            }
        } else {
            return redirect()->route('login');
        }
    }
}
