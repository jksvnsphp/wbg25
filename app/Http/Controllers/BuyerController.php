<?php

namespace App\Http\Controllers;

use App\Models\business_profile_symbol;
use App\Models\company;
use App\Models\CounterOfferQuotation;
use App\Models\CounterOfferTender;

use App\Models\CustomeCategory;
use App\Models\inbox;
use App\Models\memberPackage;
use App\Models\OfferQuotation;
use App\Models\OfferTender;
use App\Models\Order;
use App\Models\packageService;
use App\Models\Quotation;
use App\Models\seller_package;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Mail;
use App\Mail\SellerUpgradeSuccessMail;




class BuyerController extends Controller
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

    public function buyerDashboard()
    {
        $id = auth()->user()->id;
        $buyer = User::where('id', $id)->first();

        if (!empty($buyer)) {
            $purchasedProductCount = Order::where('user_id', $id)
                ->where('order_status', '!=', 'cancel')
                ->where('payment_status', '!=', 'processing')
                ->where('payment_status', '!=', 'failed')
                ->with('orderItems')
                ->get()
                ->pluck('orderItems')
                ->flatten()
                ->sum('quantity');


            $mySubmittedOfferTender = OfferTender::where('user_id', $id)
                ->where('status', 'pending')
                ->where('isUserRead', 0)
                ->doesntHave('counters')
                ->count();


            $myReceivedCounterOfferTender = CounterOfferTender::where('user_id', $id)->where('isUserRead', 0)->where('status', 'pending')->count();



            $myDealedOfferTender = OfferQuotation::where(function ($query) {
                $query->where(
                    function ($q) {
                        $q->where('vendor_id', auth()->id())->where('isVendorDealRead', 0);
                    }
                )->orWhere(function ($q) {
                    $q->where('user_id', auth()->id())->where('isUserDealRead', 0);
                });
            })->where('status', 'accept')->count();
            $tenderInfo = $mySubmittedOfferTender + $myReceivedCounterOfferTender + $myDealedOfferTender;


            // quotation section
            $quotation = Quotation::where('user_id', auth()->user()->id)
                ->where('isRead', 0)
                ->where('isDeal', 0)
                ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()])
                ->count();

            $myReceivedOfferQuotation =  OfferQuotation::where('vendor_id', $id)
                ->where('status', 'pending')
                ->where('isVendorRead', 0)
                ->doesntHave('counters')
                ->count();
            $mySubmittedOfferQuotation = OfferQuotation::where('user_id', $id)->where('status', 'pending')->where('isUserRead', 0)->doesntHave('counters')->count();

            $myOfferQuotationDeal = OfferQuotation::where(function ($query) {
                $query->where(
                    function ($q) {
                        $q->where('vendor_id', auth()->id())->where('isVendorDealRead', 0);
                    }
                )->orWhere(function ($q) {
                    $q->where('user_id', auth()->id())->where('isUserDealRead', 0);
                });
            })->where('status', 'accept')->count();

            $mySubmittedCounterOfferQuotation = CounterOfferQuotation::where('user_id', $id)->where('status', 'pending')->where('isUserRead', 0)->count();
            $myReceivedCounterOfferQuotation = CounterOfferQuotation::whereHas('offer', function ($query) use ($id) {
                $query->where('vendor_id', $id);
            })->where('isVendorRead', 0)->where('status', 'pending')->count();

            $quotationInfo = $quotation + $myReceivedOfferQuotation + $myOfferQuotationDeal + $mySubmittedOfferQuotation + $mySubmittedCounterOfferQuotation + $myReceivedCounterOfferQuotation;

            // Count unread *threads* (same as inbox list):
            // - inbox unread for current user as receiver (inbox.is_read = 0)
            // - OR any unread chat messages in that thread for current user as receiver (message.is_read = 0)
            $unreadMessages = inbox::query()
                ->where(function ($q) use ($id) {
                    $q->where('receiver_id', $id)->orWhere('sender_id', $id);
                })
                ->where(function ($q) use ($id) {
                    $q->where(function ($q2) use ($id) {
                        $q2->where('receiver_id', $id)->where('is_read', 0);
                    })->orWhereHas('chatMessages', function ($q2) use ($id) {
                        $q2->where('receiver_id', $id)->where('is_read', 0);
                    });
                })
                ->count();
            $totalMessages = inbox::where(function ($query) use ($id) {
                $query->where('receiver_id', $id)
                    ->orWhere('sender_id', $id);
            })->count();

            return view('buyer-vendor.dashboard', compact('buyer', 'quotationInfo', 'tenderInfo', 'unreadMessages', 'totalMessages', 'purchasedProductCount'));
        } else {
            abort(404);
        }
    }

    public function newStateQuotation()
    {
        $id = auth()->user()->id;

        $quotation = Quotation::where('user_id', auth()->user()->id)
            ->where('isRead', 0)
            ->where('isDeal', 0)
            ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()])
            ->count();

        $myReceivedOfferQuotation = OfferQuotation::where('vendor_id', $id)
            ->where('status', 'pending')
            ->where('isVendorRead', 0)
            ->doesntHave('counters')
            ->count();

        $myRReceivedOfferQuotation = OfferQuotation::where('vendor_id', $id)
            ->where('status', 'pending')
            ->doesntHave('counters')
            ->count();

        $myOfferQuotationDeal = OfferQuotation::where(function ($query) {
            $query->where(
                function ($q) {
                    $q->where('vendor_id', auth()->id())->where('isVendorDealRead', 0);
                }
            )->orWhere(function ($q) {
                $q->where('user_id', auth()->id())->where('isUserDealRead', 0);
            });
        })->where('status', 'accept')->count();

        $myROfferQuotationDeal = OfferQuotation::where(function ($query) {
            $query->where(
                function ($q) {
                    $q->where('vendor_id', auth()->id());
                }
            )->orWhere(function ($q) {
                $q->where('user_id', auth()->id());
            });
        })->where('status', 'accept')->count();

        $mySubmittedCounterOfferQuotation = CounterOfferQuotation::whereHas('offer', function ($query) use ($id) {
            $query->where('vendor_id', $id);
        })->where('isVendorRead', 0)->where('status', 'pending')->count();

        $myRSubmittedCounterOfferQuotation = CounterOfferQuotation::whereHas('offer', function ($query) use ($id) {
            $query->where('vendor_id', $id);
        })->where('status', 'pending')->count();

        return view('buyer-vendor.new-state-quotations', compact(
            'quotation',
            'myReceivedOfferQuotation',
            'myOfferQuotationDeal',
            'mySubmittedCounterOfferQuotation',
            'myRReceivedOfferQuotation',
            'myROfferQuotationDeal',
            'myRSubmittedCounterOfferQuotation',
        ));
    }
    public function newStateTender()
    {
        $id = auth()->user()->id;

        $mySubmittedOfferTender = OfferTender::where('user_id', $id)->where('status', 'pending')->where('isUserRead', 0)->doesntHave('counters')->count();
        $myDealedOfferTender = OfferTender::where(function ($query) {
            $query->where(
                function ($q) {
                    $q->where('vendor_id', auth()->id())->where('isVendorDealRead', 0);
                }
            )->orWhere(function ($q) {
                $q->where('user_id', auth()->id())->where('isUserDealRead', 0);
            });
        })->where('status', 'accept')->count();

        $myReceivedCounterOfferTender = CounterOfferTender::where('user_id', $id)->where('isUserRead', 0)->where('status', 'pending')->count();

        // All info
        $myRSubmittedOfferTender = OfferTender::where('user_id', $id)->where('status', 'pending')->doesntHave('counters')->count();

        $myRDealedOfferTender = OfferTender::where(function ($query) {
            $query->where(
                function ($q) {
                    $q->where('vendor_id', auth()->id());
                }
            )->orWhere(function ($q) {
                $q->where('user_id', auth()->id());
            });
        })->where('status', 'accept')->count();

        $myRReceivedCounterOfferTender = CounterOfferTender::where('user_id', $id)->where('status', 'pending')->count();

        return view('buyer-vendor.new-state-tender', compact('mySubmittedOfferTender', 'myDealedOfferTender', 'myReceivedCounterOfferTender', 'myRSubmittedOfferTender', 'myRDealedOfferTender', 'myRReceivedCounterOfferTender'));
    }
    public function profileImageGallery()
    {
        $id = auth()->user()->id;
        $buyer = User::where('id', $id)->first();
        return view('buyer-vendor.profile-image-gallery', compact('buyer'));
    }
    public function upgradeToSeller()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $memberPackages = memberPackage::get();
            $packageServices = packageService::get();
            $buyer = User::where('id', $id)->first();
            $data = array('packages' => $memberPackages, 'services' => $packageServices, 'buyer' => $buyer);
            return view('external-user.join-membership.upgrade-to-seller', $data);
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login as buyer.']);
        }
    }
    public function upgradePackageSeller($code, $ref_no)
    {
        if (isset(auth()->user()->id) && auth()->user()->isComplete == 1 && auth()->user()->account_type = "buyer") {
            $id = auth()->user()->id;
            $user = User::where('id', $id)->with('company')->first();
            $package = memberPackage::where('code', $code)->first();
            $categories = CustomeCategory::where('status', "1")->where('deleted', "0")->where('parent_id', "0")->orderBy('category_name', 'ASC')->get();
            if ($package) {
                session(['package_code_buyer' => $code]);
                return view('external-user.complete-seller-upgrade-registration', compact('user', 'categories', 'package'));
            } else {
                return redirect()->route('home')->with(['alert-type' => 'error', 'message' => 'Something went to wrong']);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Please login as buyer.']);
        }
    }

    public function upgradeToSellerSave(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'user_id' => ['required', 'exists:users,id'],
                'package_code' => ['required', 'exists:member_packages,code'],
                'company_name' => ['required', 'string'],
                'first_name' => ['required', 'string'],
                'last_name' => ['nullable', 'string'],
                'email' => ['required', 'email', 'unique:users,email,' . $request->user_id],
                'phone' => ['required', 'unique:users,phone,' . $request->user_id],
                'password' => ['nullable', 'min:8', 'confirmed'],
                'registration_year' => ['required', 'numeric', 'max:3000', "min:1900"],
                'number_of_employees' => ['required', 'string'],
                'business_type' => ['required', 'string'],
                'certifications' => ['nullable', 'array'],
                'other_certificate' => ['required_if:certifications,Other'],
                'country' => 'required|string',
                'state' => 'required|string',
                'city' => 'required|string',
                'zip' => 'required',
                'street' => 'nullable|string',
                'house_no' => 'nullable|string',
                'company_category' => 'nullable|numeric',
                'company_sub_category' => 'nullable|numeric',
            ]
        );
        if ($validate->fails()) {
            return response()->json(['status' => false, 'message' => 'Please fill all required filled.', 'error' => $validate->errors()]);
        } else {
            $user = User::find($request->user_id);
            if (!empty($user)) {
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->phone = $request->phone;
                $user->email = $request->email;

                $password = $request->password;
                if (!empty($password)) {
                    $user->password = bcrypt($password);
                }
                $user->country = $request->country;
                $user->state = $request->state;
                $user->city = $request->city;
                $user->zip = $request->zip;
                $user->street = $request->street;
                $user->house_no = $request->house_no;
                $user->save();
                $user->fpassword = $password;

                $company = company::where('vendor_id', $request->user_id)->first();
                if (!empty($company)) {
                    $company->name = $request->company_name;
                    $company->company_registeration_year = $request->registration_year;
                    $company->key_personnal = $request->number_of_employees;
                    $company->business_type = $request->business_type;
                    $company->certifications = json_encode($request->certifications);
                    $company->other_certificate = json_encode($request->other_certificate);
                    $company->category_1 = $request->company_category;
                    $company->category_2 = $request->company_sub_category;
                    $company->save();
                } else {
                    $company = new company();
                    $company->name = $request->company_name;
                    $company->vendor_id = $request->user_id;
                    $company->company_registeration_year = $request->registration_year;
                    $company->key_personnal = $request->number_of_employees;
                    $company->business_type = $request->business_type;
                    $company->certifications = json_encode($request->certifications);
                    $company->other_certificate = json_encode($request->other_certificate);
                    $company->category_1 = $request->company_category;
                    $company->category_2 = $request->company_sub_category;
                    $company->save();
                }

                // Mail::send('mails.buyer-to-seller-upgrade-success', [
                //     'name' => $user->first_name,
                //     'package' => $package->name ?? 'Basic',
                //     'dashboardLink' => route('seller.dashboard')
                // ], function ($message) use ($user) {
                //     $message->to($user->email)
                //             ->subject('Your Seller Upgrade is Successful – Start Selling Today!');
                // });
                return response()->json(['status' => true, 'url' => route('buyer-upgrade.seller.pay')]);
            } else {
                return response()->json(['status' => false, 'message' => 'This Buyer account could not found.']);
            }
        }
    }

    public function updateProfilePicture(Request $request)
    {

        $id = auth()->user()->id;
        $buyer = User::where('id', $id)->first();
        $validator = Validator::make($request->all(), ['image' => 'required|image']);
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => 'Please upload a valid image'])->withErrors($validator->errors());
        } else {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $manager = new ImageManager(['driver' => 'gd']);
                $ext = $file->getClientOriginalExtension();
                $fileName = uniqid('buyer_' . $buyer->id) . '.' . $ext;
                $manager->make($file)->resize(200, 200)->save(public_path('uploads/profile/' . $fileName));
                $buyer->profile = $fileName;
                $buyer->save();
                return back()->with(['alert-type' => 'success', 'message' => 'Successfully uploaded'])->withErrors($validator->errors());
            } else {
                return back()->with(['alert-type' => 'error', 'message' => 'Please upload a valid image'])->withErrors($validator->errors());
            }
        }
    }

    public function deleteMyProfile()
    {
        $id = auth()->user()->id;
        $buyer = User::where('id', $id)->first();
        if ($buyer->profile != '') {
            $image = public_path('uploads/profile/' . $buyer->profile);
            if (File::exists($image)) {
                File::delete($image);
            }
        }
        $buyer->profile = null;
        $buyer->save();
        return back()->with(['alert-type' => 'success', 'message' => 'Successfully deleted']);
    }


    public function showAllBuyers()
    {
        $buyers = User::where('account_type', 'buyer')->with('countryData', 'sellerPackage')->latest()->get();
        // dd($buyers);
        return view('admin.all-buyers', compact('buyers'));
    }

    public function updateStatus(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->status = $request->status;
        $user->save();
        return response()->json(['success' => true]);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with(['alert-type' => 'success', 'message' => 'Successfully deleted']);
    }

    public function editBuyer($id)
    {
        $buyer = User::findOrFail($id);
        return view('admin.edit-buyer', compact('buyer'));
    }
    public function updateBuyer(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'required|string',
                'last_name' => 'nullable|string',
                'email' => 'required|email|unique:users,email,' . $request->id,
                'phone' => 'required|numeric|unique:users,phone,' . $request->id,
                'account_type' => 'required|string|in:buyer,seller',
            ]
        );
        if ($validator->fails()) {
            return back()->with(['alert-type' => 'error', 'message' => $validator->errors()->first()])->withErrors($validator->errors());
        } else {
            $buyer = User::findOrFail($request->id);
            $buyer->first_name = $request->first_name;
            $buyer->last_name = $request->last_name;
            $buyer->email = $request->email;
            $buyer->phone = $request->phone;
            $buyer->account_type = $request->account_type;
            $buyer->save();
            return back()->with(['alert-type' => 'success', 'message' => 'Successfully updated']);
        }
    }

    public function upgradePaymentPackage()
    {
        $code = Session::get('package_code_buyer');
        $memberPackage = memberPackage::where('code', $code)->where('status', 1)->first();
        if (!empty($memberPackage)) {
            $price = $memberPackage->price;
            if ($price > 0) {
                $amount = $price;
                $user = auth()->user();
                $provider = new PayPalClient;
                $provider->setApiCredentials(config('paypal'));
                $token = $provider->getAccessToken();
                $provider->setAccessToken($token);
                $response = $provider->createOrder([
                    "intent" => "CAPTURE",
                    "application_context" => [
                        "return_url" => route('buyer-upgrade.seller.pay.status'),
                        "cancel_url" => route('buyer-upgrade.seller.pay.status'),
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

                            try {
                                $company = $user->company ?? null;
                                Mail::to($user->email)->send(new SellerUpgradeSuccessMail($user, $memberPackage->name ?? 'Seller', route('seller.dashboard')));
                            } catch (\Exception $e) {
                                \Log::error('Failed to send seller upgrade email: ' . $e->getMessage());
                            }


                            return redirect()->away($link['href']);
                        }
                    }
                    return redirect()->route('buyer.upgrade.to.seller', $user->ref_no)->with(['alert-type' => 'error', 'message' => 'Something went wrong.']);
                } else {
                    return redirect()->route('buyer.upgrade.to.seller', $user->ref_no)->with(['alert-type' => 'error', 'message' => $response['message'] ?? 'Something went wrong.']);
                }
            } else {
                // free package
                $user = User::where('id', auth()->user()->id)->first();
                $package_seller = seller_package::where('seller_id', $user->id)->first();
                if (!$package_seller) {
                    $package_seller = new seller_package();
                }
                $package_seller->seller_id = $user->id;
                $package_seller->package_id = $memberPackage->id;
                $package_seller->payment_id = 'FREE';
                $package_seller->payment_status = 'paid';
                $package_seller->price = 0;
                $package_seller->billing_detail = null;
                $package_seller->package_info = null;
                $package_seller->expire_at = date('Y-m-d', strtotime('+90 days'));
                $package_seller->save();
                $user->account_type = "seller";
                $user->save();
                $userData = User::where('id', $user->id)->where('isComplete', 1)->with('company')->first();
                Auth::login($userData);
                $this->functionHandleBusinessSymbole($memberPackage->type, $user->id);
                session()->flash('success', 'Congratulation, Your account has been successfully upgraded buyer to seller!');
                $url = route('seller.success.gallery');
                try {
                    $company = $user->company ?? null;
                    Mail::to($user->email)->send(new SellerUpgradeSuccessMail($user, $memberPackage->name ?? 'Seller', route('seller.dashboard')));
                } catch (\Exception $e) {
                    \Log::error('Failed to send seller upgrade email: ' . $e->getMessage());
                }
                return redirect($url);
            }
        } else {
            return back()->with(['alert-type' => 'error', 'message' => 'Invalid code']);
        }
    }
    public function payPalStatus(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $token = $provider->getAccessToken();
        $provider->setAccessToken($token);
        $package_code = Session::get('package_code_buyer');
        $user_id = Auth::user()->id;
        $packageData = memberPackage::where('code', $package_code)->first();
        $response = $provider->capturePaymentOrder($request['token']);
        // dd($response);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $billingAddress = $response['purchase_units'][0]['shipping']['address'];
            $user = User::where('id', $user_id)->first();
            $package_seller = seller_package::where('seller_id', $user_id)->first();
            if (!$package_seller) {
                $package_seller = new seller_package();
            }
            $package_seller->seller_id = $user->id;
            $package_seller->package_id = $packageData->id;
            $package_seller->payment_id = $response['id'];
            $package_seller->payment_status = 'paid';
            $package_seller->price = $packageData->price;
            $package_seller->billing_detail = json_encode($billingAddress);
            $package_seller->package_info = json_encode($response);
            $package_seller->expire_at = date('Y-m-d', strtotime('+360 days'));
            $package_seller->save();

            $user->account_type = "seller";
            $user->save();
            $userData = User::where('id', $user->id)->where('isComplete', 1)->with('company')->first();
            Auth::login($userData);
            $this->functionHandleBusinessSymbole($packageData->type, $user->id);
            session()->flash('success', 'Congratulation, Your account has been successfully upgraded buyer to seller!');
            $url = route('seller.success.gallery');
            return redirect($url);
        } else {
            return redirect()->route('buyer.upgrade.to.seller', auth()->user()->ref_no)->with(['alert-type' => 'error', 'message' => $response['message'] ?? 'Payment failed.']);
        }
    }
}
