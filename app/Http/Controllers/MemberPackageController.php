<?php

namespace App\Http\Controllers;

use App\Models\business_profile_symbol;
use App\Models\memberPackage;
use App\Models\packageService;
use App\Models\seller_package;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class MemberPackageController extends Controller
{

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
    public function index()
    {
        $memberPackages = memberPackage::get();
        $packageServices = packageService::get();

        $data = array('packages' => $memberPackages, 'services' => $packageServices);
        return view('admin.member_package.member_packages', $data);
    }
    public function indexClient()
    {
        $memberPackages = memberPackage::get();
        $packageServices = packageService::get();

        $data = array('packages' => $memberPackages, 'services' => $packageServices);
        return view('external-user.join-membership.membership-packages', $data);
    }
    public function upgradeMembership()
    {
        $memberPackages = memberPackage::get();
        $packageServices = packageService::get();

        $data = array('packages' => $memberPackages, 'services' => $packageServices);
        return view('external-user.join-membership.upgrade-membership', $data);
    }
    public function addNewPackageService()
    {
        return view('admin.member_package.add_package_service');
    }
    public function editPackage($id)
    {
        $package = memberPackage::where('id', $id)->first();
        if (!empty($package)) {
            return view('admin.member_package.edit_member_package', compact('package'));
        } else {
            return back()->with(['alert-type' => 'warning', 'message' => 'This Package is no more!']);
        }
    }
    public function editPackageService($id)
    {
        $service = packageService::where('id', $id)->first();
        if (!empty($service)) {
            return view('admin.member_package.edit_package_service', compact('service'));
        } else {
            return back()->with(['alert-type' => 'warning', 'message' => 'This Package service is no more!']);
        }
    }
    public function updatePackage(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|numeric',
                'package_name' => 'required',
                'price' => 'required|numeric',
                'validDays' => 'required|numeric',
                'productLimit' => 'required|numeric',
                'tenderLimit' => 'required|numeric',
                // 'buyTenderLimit' => 'required|numeric',
                'newsLimit' => 'required|numeric',
                'sellProvisionInclude' => 'required|numeric',
                'status' => 'required|numeric',
            ]
        );
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->with(['alert-type' => 'warning', 'message' => 'Please fill all the fields!']);
        } else {
            $package = memberPackage::where('id', $request->id)->first();
            if (!empty($package)) {
                $package->name = $request->package_name;
                $package->price = $request->price;
                $package->validDays = $request->validDays;
                $package->productLimit = $request->productLimit;
                $package->sellTenderLimit = $request->tenderLimit;
                // $package->buyTenderLimit = $request->buyTenderLimit;
                $package->newsLimit = $request->newsLimit;
                $package->tradeLeadsInclude = $request->sellProvisionInclude;
                $package->code = uniqid();
                $package->status = $request->status;
                $package->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Package Updated Successfully!']);
            } else {
                return back()->with(['alert-type' => 'warning', 'message' => 'This Package is no more!']);
            }
        }
    }
    public function updateStatusPackageService(Request $request)
    {
        $packageService = packageService::findOrFail($request->id);
        $packageService->status = $request->status;
        $packageService->save();
        return response()->json(['success' => true]);
    }

    public function DeletePackageService($id)
    {
        $packageService = packageService::where('id', $id)->first();
        if (!empty($packageService)) {
            $packageService->delete();
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully deleted']);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Package Service not found!']);
        }
    }
    public function storeNewPackageService(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'service_name' => ['required', 'string'],
                'isBronce' => ['required', 'numeric'],
                'isSilver' => ['required', 'numeric'],
                'isGold' => ['required', 'numeric'],
                'isPlatinum' => ['required', 'numeric'],
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors());
        } else {
            $packageService = new packageService();
            $packageService->serviceName = $request->service_name;
            $packageService->bronce = $request->isBronce;
            $packageService->silver = $request->isSilver;
            $packageService->gold = $request->isGold;
            $packageService->platinum = $request->isPlatinum;
            $packageService->save();
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully Added']);
        }
    }
    public function updatePackageService(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => ['required', 'exists:package_services,id'],
                'service_name' => ['required', 'string'],
                'isBronce' => ['required', 'numeric'],
                'isSilver' => ['required', 'numeric'],
                'isGold' => ['required', 'numeric'],
                'isPlatinum' => ['required', 'numeric'],
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withErrors($validator->errors());
        } else {
            $packageService = packageService::where('id', $request->id)->first();
            if (!empty($packageService)) {
                $packageService->serviceName = $request->service_name;
                $packageService->bronce = $request->isBronce;
                $packageService->silver = $request->isSilver;
                $packageService->gold = $request->isGold;
                $packageService->platinum = $request->isPlatinum;
                $packageService->save();

                return back()->with(['alert-type' => 'success', 'message' => 'Successfully Updated']);
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Something went wrong']);
            }
        }
    }

    public function upgradeMembershipPay(Request $request)
    {
        if ($request->has('code') && $request->code != "") {
            $code = $request->input('code');
            $memberPackage = memberPackage::where('code', $code)->where('status', 1)->first();
            if (!empty($memberPackage)) {
                $price = $memberPackage->price;
                if ($price > 0) {
                    $amount = $price;
                    $user = auth()->user();
                    session(['package_code' => $code]);
                    $provider = new PayPalClient;
                    $provider->setApiCredentials(config('paypal'));
                    $token = $provider->getAccessToken();
                    $provider->setAccessToken($token);

                    $response = $provider->createOrder([
                        "intent" => "CAPTURE",
                        "application_context" => [
                            "return_url" => route('seller.upgrade.pay.status'),
                            "cancel_url" => route('seller.upgrade.pay.status'),
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
                        return redirect()->route('seller.upgrade.member.package')->with(['alert-type' => 'error', 'message' => 'Something went wrong.']);
                    } else {
                        return redirect()->route('seller.upgrade.member.package')->with(['alert-type' => 'error', 'message' => $response['message'] ?? 'Something went wrong.']);
                    }
                } else {
                    // free package
                    $user = auth()->user();
                    $package_seller = seller_package::where('seller_id', $user->id)->first();
                    if ($package_seller) {
                        $package_seller->seller_id = $user->id;
                        $package_seller->package_id = $memberPackage->id;
                        $package_seller->payment_id = 'FREE';
                        $package_seller->payment_status = 'paid';
                        $package_seller->price = 0;
                        $package_seller->billing_detail = null;
                        $package_seller->package_info = null;
                        $package_seller->expire_at = date('Y-m-d', strtotime('+90 days'));
                        $package_seller->save();

                        $wallet = new Wallet();
                        $wallet->user_id = $user->id;
                        $wallet->credit = $memberPackage->tradeLeadsInclude;
                        $wallet->save();
                        $this->functionHandleBusinessSymbole($memberPackage->type, $user->id);
                        session()->flash('success', 'Congratulation, Your account has been successfully upgraded!');
                        $url = route('seller.success.gallery');
                        return redirect($url);
                    } else {
                        return back()->with(['alert-type' => 'error', 'message' => 'Invalid Seller account.']);
                    }
                }
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Invalid code']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Invalid Request']);
        }
    }

    public function payPalStatus(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        // dd($token);
        $provider->setAccessToken($token);
        $package_code = Session::get('package_code');
        $user_id = Auth::user()->id;;
        $packageData = memberPackage::where('code', $package_code)->first();
        $response = $provider->capturePaymentOrder($request['token']);
        // dd($response);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $billingAddress = $response['purchase_units'][0]['shipping']['address'];
            $user = User::where('id', $user_id)->first();
            $package_seller = seller_package::where('seller_id', $user_id)->first();
            if ($package_seller) {
                $package_seller->seller_id = $user->id;
                $package_seller->package_id = $packageData->id;
                $package_seller->payment_id = $response['id'];
                $package_seller->payment_status = 'paid';
                $package_seller->price = $packageData->price;
                $package_seller->billing_detail = json_encode($billingAddress);
                $package_seller->package_info = json_encode($response);
                $package_seller->expire_at = date('Y-m-d', strtotime('+360 days'));
                $package_seller->save();
                
                $wallet = new Wallet();
                $wallet->user_id = $user->id;
                $wallet->credit = $packageData->tradeLeadsInclude;
                $wallet->save();
            }
            $this->functionHandleBusinessSymbole($packageData->type, $user->id);
            session()->flash('success', 'Congratulation, Your account has been successfully upgraded!');
            $url = route('seller.success.gallery');
            return redirect($url);
        } else {
            return redirect()->route('seller.upgrade.member.package')->with(['alert-type' => 'error', 'message' => $response['message'] ?? 'Payment failed.']);
        }
    }
}
