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


    public function indexClientold()
    {
        $memberPackages = memberPackage::get();
        $packageServices = packageService::get();

        $data = array('packages' => $memberPackages, 'services' => $packageServices);
        return view('external-user.join-membership.membership-packages', $data);
    }
    public function indexClient()
    {
        $packageServices = packageService::get();

        // 🔹 If user is not logged in → show all packages
        if (!auth()->check()) {
            $memberPackages = memberPackage::where('status', 1)->get();

            return view('external-user.join-membership.membership-packages', [
                'packages' => $memberPackages,
                'services' => $packageServices
            ]);
        }

        // 🔹 Logged-in user
        $userId = auth()->user()->id;

        // Get latest purchased package of user
        $sellerPackage = seller_package::where('seller_id', $userId)
            ->latest()
            ->with('package')
            ->first();

        // 🔹 If user has NOT purchased any package
        if (!$sellerPackage) {
            $memberPackages = memberPackage::where('status', 1)->get();
        } else {
            // 🔹 Exclude purchased package
            $memberPackages = memberPackage::where('status', 1)
                ->where('id', '!=', $sellerPackage->package_id)
                ->get();
        }

        return view('external-user.join-membership.membership-packages', [
            'packages' => $memberPackages,
            'services' => $packageServices,
            'activePackage' => $sellerPackage?->package
        ]);
    }



    public function upgradeMembership()
    {
        $memberPackages = memberPackage::where('id', '!=', 1)->get();
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
                'newsLimit' => 'required|numeric',
                'sellProvisionInclude' => 'required|numeric',
                'status' => 'required|numeric',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator->errors())
                ->with(['alert-type' => 'warning', 'message' => 'Please fill all the fields!']);
        }

        $package = memberPackage::where('id', $request->id)->first();

        if (!$package) {
            return back()->with([
                'alert-type' => 'warning',
                'message' => 'This Package is no more!'
            ]);
        }

        // ✅ Image Upload
        if ($request->hasFile('image')) {

            // Delete old image
            if ($package->image && file_exists(public_path('uploads/member_packages/' . $package->image))) {
                unlink(public_path('uploads/member_packages/' . $package->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/member_packages'), $imageName);

            $package->image = $imageName;
        }

        // ✅ Update Fields
        $package->name = $request->package_name;
        $package->price = $request->price;
        $package->validDays = $request->validDays;
        $package->productLimit = $request->productLimit;
        $package->sellTenderLimit = $request->tenderLimit;
        $package->newsLimit = $request->newsLimit;
        $package->tradeLeadsInclude = $request->sellProvisionInclude;
        $package->code = uniqid();
        $package->status = $request->status;

        $package->save();

        return back()->with([
            'alert-type' => 'success',
            'message' => 'Package Updated Successfully!'
        ]);
    }


    public function updatePackageold(Request $request)
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

    public function saleProvisionInclude(Request $request)
    {


        $query = Wallet::where('user_id', '>', 0);

        // Search filter

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('seller', function ($q) use ($search) {
                    $q->where('company_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
        }

        // Sort
        if ($request->filled('sort') && $request->sort == 'oldest') {
            $query->orderBy('id', 'desc');
        } else {
            $query->latest();
        }

        $wallets = $query->paginate(10)->withQueryString();
        // die;
        return view('admin.member_package.sale-provision-include', compact('wallets'));
    }

    public function additionalSaleProvision(Request $request)
    {

        // $query = products::with('vendor','gallery');
        $query = Wallet::where('user_id', '>', 0)->where('balance', '<', 0);
        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhereHas('seller', function ($q) use ($search) {
                    $q->where('company_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
        }

        // Sort
        if ($request->filled('sort') && $request->sort == 'oldest') {
            $query->orderBy('id', 'desc');
        } else {
            $query->latest();
        }

        $wallets = $query->paginate(10)->withQueryString();
        // die;
        return view('admin.member_package.additional-sale-provision', compact('wallets'));
    }
}
