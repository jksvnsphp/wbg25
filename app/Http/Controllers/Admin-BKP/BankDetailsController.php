<?php

namespace App\Http\Controllers;

use App\Models\bank_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BankDetailsController extends Controller
{
    //
    public function bankDetail()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $bank = bank_details::where('vendor_id', '=', $id)->first();
            return view('seller-vendor.bank-detail', compact('bank'));
        } else {
            return redirect()->route('login');
        }
    }
    public function addBandDetail(Request $request)
    {

        if (isset(auth()->user()->id)) {

            $id = auth()->user()->id;

            $validator = Validator::make(
                $request->all(),
                [
                    'isBankDetail' => ['nullable'],
                    'account_holder' => ['required_if:isBankDetail,on'],
                    'bank_name' => ['required_if:isBankDetail,on'],
                    'country' => ['required_if:isBankDetail,on'],
                    'iban' => ['required_if:isBankDetail,on'],
                    'bic' => ['required_if:isBankDetail,on'],
                    'isPayPal' => ['nullable'],
                    'email' => ['required_if:isPayPal,on'],
                    'isGooglePay' => ['nullable'],
                    'upi_google' => ['required_if:isGooglePay,on'],
                    'isOther' => ['nullable'],
                    'other_method_name' => ['required_if:isOther,on'],
                    'other_value' => ['required_if:isOther,on'],
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->with(['alert-type' => 'error', 'message' => 'Validation failed.']);
            } else {
                $icons = bank_details::where('vendor_id', '=', $id)->first();
                if ($icons) {
                    $icons->isBankDetail = $request->isBankDetail == "on" ? 1 : 0;
                    $icons->account_holder = $request->account_holder;
                    $icons->bank_name = $request->bank_name;
                    $icons->country = $request->country;
                    $icons->iban = $request->iban;
                    $icons->bic = $request->bic;
                    $icons->isPayPal = $request->isPayPal == "on" ? 1 : 0;
                    $icons->email = $request->email;

                    $icons->isGooglePay = $request->isGooglePay == "on" ? 1 : 0;
                    $icons->upi_google = $request->upi_google;
                    $icons->isOther = $request->isOther == "on" ? 1 : 0;
                    $icons->other_method_name = $request->other_method_name;
                    $icons->other_value = $request->other_value;
                    $icons->save();
                } else {
                    $icons = new bank_details();
                    $icons->vendor_id = $id;
                    $icons->isBankDetail = $request->isBankDetail == "on" ? 1 : 0;
                    $icons->account_holder = $request->account_holder;
                    $icons->bank_name = $request->bank_name;
                    $icons->country = $request->country;
                    $icons->iban = $request->iban;
                    $icons->bic = $request->bic;
                    $icons->isPayPal = $request->isPayPal == "on" ? 1 : 0;
                    $icons->email = $request->email;
                    
                    $icons->isGooglePay = $request->isGooglePay == "on" ? 1 : 0;
                    $icons->upi_google = $request->upi_google;
                    $icons->isOther = $request->isOther == "on" ? 1 : 0;
                    $icons->other_method_name = $request->other_method_name;
                    $icons->other_value = $request->other_value;
                    $icons->save();
                }
                session()->flash('success', 'Congratulation, Your bank details has updated successfully!');
                return redirect()->route('seller.success.gallery');
            }
        } else {
            return redirect()->route('login');
        }
    }
}
