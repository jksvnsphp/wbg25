<?php

namespace App\Http\Controllers;

use App\Models\business_profile_symbol;
use App\Models\Coupon;
use App\Models\memberPackage;
use App\Models\packageService;
use App\Models\seller_package;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    //
    public function functionHandleBusinessSymbole($packageType, $id)
    {
        $profileSymbols = business_profile_symbol::where('vendor_id', $id)->firstOrCreate([
            'vendor_id' => $id
        ]);
        if ($packageType) {
            $verifiedSeal =  packageService::where('serviceName', 'Company + Product Verified Seal')->first();
            $trustSeal = packageService::where('serviceName', 'Company + Product Trust Seal')->first();

            $updateData = [];

            if ($verifiedSeal && $verifiedSeal->$packageType) {
                if (!$profileSymbols->isProductVerified) {
                    $updateData['isProductVerified'] = 1;
                } else {
                    $updateData['isProductVerified'] = 0;
                }
            } else {
                $updateData['isProductVerified'] = 0;
            }
            if ($trustSeal && $trustSeal->$packageType) {
                if (!$profileSymbols->isTrustSeal) {
                    $updateData['isTrustSeal'] = 1;
                } else {
                    $updateData['isTrustSeal'] = 0;
                }
            } else {
                $updateData['isTrustSeal'] = 0;
            }
            if (!empty($updateData)) {
                $profileSymbols->update($updateData);
            }
        }
    }
    public function payWithPayPal()
    {

        $package = Session::get('package_code');
        $user_id = Session::get('user_id');
        $packageData = memberPackage::where('code', $package)->first();
        $coupon_code = Session::get('coupon_code');
        $discount = 0;
        if ($coupon_code) {
            $coupon = Coupon::where('code', $coupon_code)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->where('is_active', 1)
                ->first();
            if ($coupon) {
                $discount = $coupon->discount;
            }
        }
        $amount = $packageData->price - $discount;
        $validDays = $packageData->validDays ?? 90;
        if ($amount > 0) {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $token = $provider->getAccessToken();
            $provider->setAccessToken($token);

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('paypal.status'),
                    "cancel_url" => route('paypal.status'),
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => "EUR",
                            "value" => $amount
                        ]
                    ]
                ]
            ]);

            if (isset($response['id']) && $response['id'] != null) {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] == 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
                return redirect()->route('paypal.pay')->with('error', 'Something went wrong.');
            } else {
                return redirect()->route('paypal.pay')->with('error', $response['message'] ?? 'Something went wrong.');
            }
        } elseif ($amount <= 0 && $packageData->price > 0) {
            $user = User::where('id', $user_id)->first();
            $package_seller = new seller_package();
            $package_seller->seller_id = $user_id;
            $package_seller->package_id = $packageData->id;
            $package_seller->payment_id = uniqid('DISCOUNT_');
            $package_seller->payment_status = 'paid';
            $package_seller->price = $packageData->price;
            $package_seller->billing_detail = json_encode([]);
            $package_seller->package_info = json_encode([]);
            $package_seller->coupon_code = $coupon_code;
            $package_seller->discount = $discount ?? 0;
            $package_seller->expire_at = date('Y-m-d', strtotime('+' . $validDays . ' days'));
            $package_seller->save();
            $user->isComplete = 1;
            $user->save();

            Auth::login($user);

            $wallet = new Wallet();
            $wallet->user_id = $user_id;
            $wallet->credit = $packageData->tradeLeadsInclude;
            $wallet->save();

            $this->functionHandleBusinessSymbole($packageData->type, $user_id);
            return redirect()->route('home')->with(['alert-type' => 'success', 'message' => 'Successfully login']);
        } else {
            $user = User::where('id', $user_id)->first();
            $package_seller = new seller_package();
            $package_seller->seller_id = $user_id;
            $package_seller->package_id = $packageData->id;
            $package_seller->payment_id = uniqid('FREE_');
            $package_seller->payment_status = 'paid';
            $package_seller->price = 0;
            $package_seller->billing_detail = json_encode([]);
            $package_seller->package_info = json_encode([]);
            $package_seller->expire_at = date('Y-m-d', strtotime('+90 days'));
            $package_seller->save();
            $user->isComplete = 1;
            $user->save();
            Auth::login($user);
            $wallet = new Wallet();
            $wallet->user_id = $user_id;
            $wallet->credit = $packageData->tradeLeadsInclude;
            $wallet->save();
            $this->functionHandleBusinessSymbole($packageData->type, $user_id);
            return redirect()->route('home')->with(['alert-type' => 'success', 'message' => 'Successfully login']);
        }
    }

    public function payPalStatus(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);
        $package_code = Session::get('package_code');

        $user_id = Session::get('user_id');
        $packageData = memberPackage::where('code', $package_code)->first();


        $response = $provider->capturePaymentOrder($request['token']);
        // dd($response);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $billingAddress = $response['purchase_units'][0]['shipping']['address'];
            // dd($billingAddress);
            $user = User::where('id', $user_id)->first();

            $coupon_code = Session::get('coupon_code');
            $discount = 0;
            if ($coupon_code) {
                $coupon = Coupon::where('code', $coupon_code)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->where('is_active', 1)
                    ->first();
                if ($coupon) {
                    $discount = $coupon->discount;
                }
            }
            $amount = $packageData->price - $discount;
            $validDays = $packageData->validDays ?? 90;
            $package_seller = new seller_package();
            $package_seller->seller_id = $user_id;
            $package_seller->package_id = $packageData->id;
            $package_seller->payment_id = $response['id'];
            // add payment status
            $package_seller->payment_status = 'paid';
            $package_seller->price = $packageData->price;
            $package_seller->coupon_code = $coupon_code;
            $package_seller->discount = $discount ?? 0;
            $package_seller->billing_detail = json_encode($billingAddress);
            $package_seller->package_info = json_encode($response);
            $package_seller->expire_at = date('Y-m-d', strtotime('+' . $validDays . ' days'));
            $package_seller->save();
            $user->isComplete = 1;
            $user->save();
            Auth::login($user);

            $wallet=new Wallet();
            $wallet->user_id=$user_id;
            $wallet->credit=$packageData->tradeLeadsInclude;
            $wallet->save();
            
            $this->functionHandleBusinessSymbole($packageData->type, $user_id);
            return redirect()->route('home')->with(['alert-type' => 'success', 'message' => 'Successfully login']);
        } else {
            // Payment failed
            return redirect()->route('home')->with(['alert-type' => 'error', 'message' => $response['message'] ?? 'Payment failed.']);
        }
    }
}
