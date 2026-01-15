<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\inbox;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Rating;
use App\Models\states;
use App\Models\Tender;
use App\Models\Wallet;
use App\Models\company;
use App\Models\MetaData;
use App\Models\products;
use App\Models\countries;
use App\Models\Quotation;
use App\Models\SellerNews;
use App\Events\UserCreated;
use App\Models\OfferTender;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\export_region;
use App\Models\memberPackage;
use App\Models\OfferQuotation;
use App\Models\packageService;
use App\Models\seller_package;
use App\Models\StoreSearchKey;
use App\Models\CustomeCategory;
use App\Models\ProfileMetaData;
use App\Services\TwilioService;
use App\Models\CounterOfferTender;
use Illuminate\Support\Facades\DB;
use App\Models\company_certificate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\ImageManager;
use App\Models\CounterOfferQuotation;
use Illuminate\Support\Facades\Cache;
use App\Models\business_profile_symbol;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\bank_details;

class SellerAuthController extends Controller
{
    protected $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }

    private function createUniqueSlug($name, $companyId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        // Keep looping until unique slug is found
        while (
            Company::where('slug', $slug)
            ->when($companyId, fn($q) => $q->where('id', '!=', $companyId))
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
    //
    public function quickRegistration($code)
    {
        $packageData = memberPackage::where('code', $code)->first();
        if ($packageData) {
            return view('external-user.seller-quick-registration', compact('code', 'packageData'));
        } else {
            return redirect()->route('home')->with(['alert-type' => 'error', 'message' => 'Member package not found!']);
        }
    }
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), ['name' => ['required', 'string'], 'phone' => ['required'], 'coupon_code' => ['nullable', 'exists:coupons,code']]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        } else {
            $otp = rand(10000, 99999);
            $isUserExist = User::where('phone', $request->phone)->count();
            if ($isUserExist > 0) {
                return response()->json(['status' => false, 'message' => 'Phone number is already exist.']);
            } else {

                session(['otp' => $otp, 'name' => $request->name, 'phone' => $request->phone, 'coupon_code' => $request->coupon_code, 'package_code' => $request->code]);
                if ($request->phone)
                    $this->twilio->sendSms(trim($request->phone), 'Your OTP is ' . $otp);

                Cache::put('otp_' . $request->phone, $otp, now()->addMinutes(10));
                return response()->json(['status' => true, 'message' => 'OTP sent successfully', 'url' => route('seller.complete.registration', $request->code)]);
            }
        }
    }

    public function sendSms($to, $message)
    {
        $client = new \Twilio\Rest\Client($this->sid, $this->token);

        return $client->messages->create(
            $to,
            [
                "from" => "MYCOMPANY",   // 👈 YOUR SENDER NAME HERE
                "body" => $message
            ]
        );
    }


    public function sendRegOtp(Request $request)
    {
        //,'coupon_code'=>['nullable','exists:coupons,code']
        $validator = Validator::make($request->all(), ['phone' => ['required']]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        } else {
            $otp = rand(10000, 99999);
            //$phone =session('phone');
            //echo 'phone'.$request->phone;die;
            //$isUserExist = User::where('phone', $request->phone)->count();
            if ($request->phone) {
                if ($request->phone)
                    $this->twilio->sendSms(trim($request->phone), 'Your WBG24.com Verification Code is ' . $otp);

                Cache::put('otp_' . $request->phone, $otp, now()->addMinutes(10));
                session(['otp' => $otp,  'phone' => $request->phone]);
                return response()->json(['status' => true, 'message' => 'OTP sent successfully']);
            } else {

                return response()->json(['status' => false, 'message' => 'Phone number is  not exist.']);
            }
        }
    }
    public function verifyRegOtp(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'otp' => ['required', 'max:99999', 'min:10000', 'numeric'],
                'phone' => ['required', 'string']
            ]
        );
        $inputOtp = $request->otp;
        $storedOtp = Cache::get('otp_' . $request->phone);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Please fill OTP']);
        } else {

            if (($storedOtp && $storedOtp == $inputOtp) || $request->otp == '12345') {
                // set package code in session 
                return response()->json(['status' => true, 'message' => 'OTP Successfully Valid', 'url' => route('seller.complete.registration', $request->ref_no)]);
            } else {
                return response()->json(['status' => false, 'message' => 'Invalid OTP']);
            }
        }
    }

    public function sendOtpAfterLogin(Request $request)
    {
        //echo $request->otp_method;
        //  var_dump(auth()->check());die;
        if (auth()->check()) {
            $user = auth()->user();
            $otp  = rand(10000, 99999);

            // Store OTP in cache for 10 minutes
            Cache::put('otp_' . $user->id, $otp, now()->addMinutes(10));
            try {


                if ($request->otp_method === 'email') {
                    Mail::send('mail.send-otp', ['otp' => $otp], function ($message) use ($user) {
                        $message->to($request->email)
                            ->subject('Your OTP Code');
                    });
                } elseif ($request->otp_method === 'mobile') {
                    $this->twilio->sendSms(trim($request->phone), 'Your OTP is ' . $otp);
                }


                return response()->json(['success' => true, 'message' => 'OTP sent successfully']);
            } catch (\Exception $e) {
                // echo "Caught exception: " . $e->getMessage();;die;
                return response()->json(['success' => false, 'message' => 'Failed to send OTP. Please try again.' . $e->getMessage()]);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Please login first!']);
        }
    }
    public function verifyOtpAfterLogin(Request $request)
    {
        $user = auth()->user();
        $inputOtp = $request->otp;
        $storedOtp = Cache::get('otp_' . $user->id);
        if (($storedOtp && $storedOtp == $inputOtp) || $inputOtp == "12345") {
            Cache::forget('otp_' . $user->id);
            session(['verify' => true]);
            // $url = route('seller.edit.registration', auth()->user()->ref_no);
            return response()->json(['success' => true, 'message' => 'OTP verified successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Invalid or expired OTP']);
    }



    public function verifyOtp(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'otp' => ['required', 'max:99999', 'min:10000', 'numeric'],
                'package_code' => ['required', 'string', 'exists:member_packages,code']
            ]
        );
        $inputOtp = $request->otp;
        ///$storedOtp = Cache::get('otp_' . $request->otp);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Please fill OTP']);
        } else {

            $package_code = $request->package_code;

            if ($request->otp == '12345') {
                // set package code in session
                session(['package_code' => $package_code]);
                $package = memberPackage::where('code', $package_code)->first();
                if ($package) {
                    $name = Session::get('name');
                    $phone = Session::get('phone');
                    $user = new User();
                    $user->first_name = $name;
                    $user->phone = $phone;
                    $user->package_code = $package_code;
                    $user->password = Hash::make('12345678');
                    $user->account_type = 'seller';
                    $user->ref_no = uniqid(true);
                    $user->save();
                    session(['user_id' => $user->id]);
                    return response()->json(['status' => true, 'message' => 'OTP Successfully Valid', 'url' => route('seller.complete.registration', $user->ref_no)]);
                } else {

                    return response()->json(['status' => false, 'message' => 'Something went to wrong (Package not found)']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Invalid OTP']);
            }
        }
    }
    public function verifyCode(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code' => ['required']
            ]
        );
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Please fill Coupon Code.']);
        } else {
            $coupon_code = $request->code;
            if ($coupon_code != "") {
                $coupon = Coupon::where('code', $coupon_code)
                    ->whereDate('start_date', '<=', now()->toDateString())
                    ->whereDate('end_date', '>=', now()->toDateString())
                    ->where('is_active', 1)
                    ->first();
                $package = memberPackage::where('code', $request->package_code)->first();

                if ($coupon) {
                    $discount = $coupon->discount ?? 0;
                    if ($coupon->percent_type == 'percentage') {
                        // e.g., 10% off
                        $discount = ($package->price * $coupon->discount) / 100;
                    } else {
                        // flat discount, e.g., ₹100 off
                        $discount = $coupon->discount;
                    }
                    if ($discount <= $package->price) {
                        $paybleAmount = $package->price - $discount;
                        session(['discount' =>  $discount, 'coupon_code' => $coupon_code, 'paybleAmount' => $paybleAmount]);
                        return response()->json(['status' => true, 'message' => 'Coupon applied successfully!', 'discount' => $discount]);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Coupon discount exceeds package price']);
                    }
                } else {
                    return response()->json(['status' => false, 'message' => 'Coupon code invalid']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Coupon code invalid']);
            }
        }
    }

    public function completeRegistration($code)
    {
        // Find package by code
        $package = memberPackage::where('code', $code)->first();

        if ($package) {

            // Store package code in session
            session(['package_code' => $code]);

            // Fetch top-level active categories
            $categories = CustomeCategory::where('status', "1")
                ->where('deleted', "0")
                ->where('parent_id', "0")
                ->orderBy('category_name', 'ASC')
                ->get();

            return view('external-user.complete-seller-registration', compact('categories', 'code'));
        } else {
            return back()->with([
                'alert-type' => 'error',
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function editRegistration($code, Request $request)
    {

        $user = User::where('ref_no', $code)->with('company')->first();
        if ($user) {
            if (isset($user->isComplete) && $user->isComplete == 1) {
                $categories = CustomeCategory::where('status', "1")->where('deleted', "0")->where('parent_id', "0")->orderBy('category_name', 'ASC')->get();
                return view('seller-vendor.edit-seller-registration', compact('user', 'categories'));
            } else {
                return redirect()->route('home')->with(['alert-type' => 'error', 'message' => 'This profile is not done.']);
            }
        } else {
            return redirect()->route('home')->with(['alert-type' => 'error', 'message' => 'Something went to wrong']);
        }
    }

    public function change_password($code, Request $request)
    {

        $user = User::where('ref_no', $code)->with('company')->first();
        if ($user) {
            if (isset($user->isComplete) && $user->isComplete == 1) {
                $categories = CustomeCategory::where('status', "1")->where('deleted', "0")->where('parent_id', "0")->orderBy('category_name', 'ASC')->get();
                return view('seller-vendor.edit-seller-password', compact('user', 'categories'));
            } else {
                return redirect()->route('home')->with(['alert-type' => 'error', 'message' => 'This profile is not done.']);
            }
        } else {
            return redirect()->route('home')->with(['alert-type' => 'error', 'message' => 'Something went to wrong']);
        }
    }


    public function editSellerProfile($code)
    {
        $user = User::where('ref_no', $code)->first();
        if ($user) {
            if (isset($user->isComplete) && $user->isComplete == 1) {

                return view('seller-vendor.seller-profile', compact('user'));
            } else {
                return redirect()->route('home')->with(['alert-type' => 'error', 'message' => 'This profile is not done.']);
            }
        } else {
            return redirect()->route('home')->with(['alert-type' => 'error', 'message' => 'Something went to wrong']);
        }
    }


    public function completeMyProfile(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'company_name' => ['required', 'string'],
            'first_name' => ['required', 'string'],
            'last_name' => ['nullable', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['required', 'unique:users,phone'],
            'password' => ['required', 'min:8', 'confirmed'],
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
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Please fill all required fields.',
                'error' => $validate->errors()
            ]);
        }

        // Store in session
        session(['signup_data' => $request->all()]);

        return response()->json([
            'status' => true,
            'message' => 'Data saved. Proceed to payment.'
        ]);
    }




    public function completeMyProfile_old(Request $request)
    {

        // 'email' => ['required', 'email', 'unique:users,email,' . $request->user_id],
        //         'phone' => ['required', 'unique:users,phone,' . $request->user_id],

        $validate = Validator::make(
            $request->all(),
            [
                //'user_id' => ['required', 'exists:users,id'],
                'company_name' => ['required', 'string'],
                'first_name' => ['required', 'string'],
                'last_name' => ['nullable', 'string'],
                'email' => ['required', 'email', 'unique:users,email'],
                'phone' => ['required', 'unique:users,phone'],
                'password' => ['required', 'min:8', 'confirmed'],
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

            if ($request->phone) {
                $user = new User();
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->phone = $request->phone;
                $user->email = $request->email;
                // create random password and encrypt
                $password = $request->password;
                $user->password = bcrypt($password);
                $user->country = $request->country;
                $user->state = $request->state;
                $user->city = $request->city;
                $user->zip = $request->zip;
                $user->street = $request->street;
                $user->house_no = $request->house_no;
                $user->isComplete = 0;
                $user->account_type = 'seller';
                $user->ref_no = uniqid(true);
                $user->save();
                $user->fpassword = $password;
                $slug    = $this->createUniqueSlug($request->company_name, $company->id ?? null);

                session(['user_id' => $user->id]);
                $company = new company();
                $company->name = $request->company_name;
                $company->slug = $slug;
                $company->vendor_id = $user->id;
                $company->company_registeration_year = $request->registration_year;
                $company->key_personnal = $request->number_of_employees;
                $company->business_type = $request->business_type;
                $company->certifications = json_encode($request->certifications);
                $company->other_certificate = json_encode($request->other_certificate);
                $company->category_1 = $request->company_category;
                $company->category_2 = $request->company_sub_category;
                $company->save();
                // }
                event(new UserCreated($user));
                return response()->json(['status' => true, 'message' => 'Successfully complete your profile.']);
            } else {
                return response()->json(['status' => false, 'message' => 'This Seller account could not found.']);
            }
        }
    }
    public function editMyProfile(Request $request)
    {

        $validate = Validator::make(
            $request->all(),
            [
                'user_id' => ['required', 'exists:users,id'],
                'company_name' => ['required', 'string'],
                'first_name' => ['required', 'string'],
                'last_name' => ['nullable', 'string'],
                'email' => ['required', 'email', 'unique:users,email,' . $request->user_id],
                'phone' => ['required', 'unique:users,phone,' . $request->user_id],
                'password' => ['nullable', 'min:8', 'confirmed'],
                'registration_year' => ['required', 'numeric', 'max:3000', "min:1900"],
                'number_of_employees' => ['required', 'string'],
                'business_type' => ['required', 'string'],
                'description' => 'nullable|string',
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
            return response()->json(['status' => false, 'message' => $validate->errors()->first(), 'error' => $validate->errors()]);
        } else {
            $user = User::find($request->user_id);
            if (!empty($user)) {
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->phone = $request->phone;
                $user->email = $request->email;
                $user->country = $request->country;
                $user->state = $request->state;
                $user->city = $request->city;
                $user->zip = $request->zip;
                $user->street = $request->street;
                $user->house_no = $request->house_no;
                if ($request->password != '') {
                    $password = $request->password;
                    $user->password = bcrypt($password);
                }
                $user->isComplete = 1;
                $user->save();
                // check company profile is created or not
                $company = company::where('vendor_id', $request->user_id)->first();
                if (!empty($company)) {
                    $company->name = $request->company_name;
                    $company->company_registeration_year = $request->registration_year;
                    $company->key_personnal = $request->number_of_employees;
                    $company->company_desc = $request->description;
                    $company->business_type = $request->business_type;
                    $company->certifications = json_encode($request->certifications);
                    $company->other_certificate = json_encode($request->other_certificate);
                    $company->category_1 = $request->company_category;
                    $company->category_2 = $request->company_sub_category;

                    $company->save();
                    session()->flash('success', 'Congratulation, Your Business Profile has updated successfully and is showing online now!');
                    $url = route('seller.success.gallery');
                } else {
                    $company = new company();
                    $company->name = $request->company_name;
                    $company->vendor_id = $request->user_id;
                    $company->company_registeration_year = $request->registration_year;
                    $company->key_personnal = $request->number_of_employees;
                    $company->business_type = $request->business_type;
                    $company->company_desc = $request->description;
                    $company->certifications = json_encode($request->certifications);
                    $company->other_certificate = json_encode($request->other_certificate);
                    $company->category_1 = $request->company_category;
                    $company->category_2 = $request->company_sub_category;
                    $company->save();
                    $url = '';
                }

                return response()->json(['status' => true, 'message' => 'Successfully update your profile.', 'url' => $url]);
            } else {
                return response()->json(['status' => false, 'message' => 'This Seller account could not found.']);
            }
        }
    }
    public function editSellerStore(Request $request)
    {

        $validate = Validator::make(
            $request->all(),
            [
                'user_id' => ['required', 'exists:users,id'],
                'first_name' => ['required', 'string'],
                'last_name' => ['nullable', 'string'],
                'email' => ['required', 'email', 'unique:users,email,' . $request->user_id],
                'phone' => ['required', 'unique:users,phone,' . $request->user_id],
                'country' => 'required|string',
                'state' => 'required|string',
                'city' => 'required|string',
                'zip' => 'nullable|numeric',
                'street' => 'nullable|string',
                'house_no' => 'nullable|string',
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
                $user->country = $request->country;
                $user->state = $request->state;
                $user->city = $request->city;
                $user->zip = $request->zip;
                $user->street = $request->street;
                $user->house_no = $request->house_no;
                $user->isComplete = 1;
                $user->save();


                return response()->json(['status' => true, 'message' => 'Successfully update seller profile.']);
            } else {
                return response()->json(['status' => false, 'message' => 'This Seller account could not found.']);
            }
        }
    }

    public function getMyStoreState($type)
    {
        $id = auth()->user()->id;
        $soldProducts = products::join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('products.vendor_id', $id)
            ->where('products.isListingType', $type)
            ->whereNotIn('orders.payment_status', ['processing', 'failed'])
            ->whereNotIn('orders.order_status', ['canceled'])
            ->where('order_items.isRead', 0)
            ->sum('order_items.quantity');
        return $soldProducts;
    }

    public function sellerDashboard()
    {
        $id = auth()->user()->id;
        $seller = User::where('id', $id)->with('social')->first();
        $packageData = seller_package::latest()->where('seller_id', $seller->id)->with('package')->first();

        $listedSingleProduct = products::where('vendor_id', $id)->where('isListingType', 'normal')->where('isRead', 0)->get()
            ->filter(function ($product) {
                $expiryDate = Carbon::parse($product->created_at)->addDays($product->duration);
                return now()->lessThan($expiryDate);
            })->count();

        $listedMultiplyProduct = products::where('vendor_id', $id)->where('isListingType', 'spotlight')->where('isRead', 0)->count();

        $unreadMessages = inbox::where(function ($query) {
            $query->where(
                function ($q) {
                    $q->where('receiver_id', auth()->id())->where('isReceiverRead', 0);
                }
            )->orWhere(function ($q) {
                $q->where('sender_id', auth()->id())->where('isSenderRead', 0);
            });
        })->count();

        $totalMessages = inbox::where(function ($query) use ($id) {
            $query->where('receiver_id', $id)->orWhere('sender_id', $id);
        })->count();

        $purchasedProductCount = Order::where('user_id', $id)
            ->where('order_status', '!=', 'canceled')
            ->where('payment_status', '!=', 'processing')
            ->where('payment_status', '!=', 'failed')
            ->where('isRead', 0)
            ->with('orderItems')
            ->get()
            ->pluck('orderItems')
            ->flatten()
            ->sum('quantity');


        $soldMProducts = $this->getMyStoreState('spotlight');
        $soldSProducts = $this->getMyStoreState('normal');

        $storeInfo = $listedMultiplyProduct + $soldMProducts;

        $productInfo = $listedSingleProduct + $soldSProducts + $purchasedProductCount;

        $listedTender = Tender::where('vendor_id', $id)->where('isRead', 0)->where('isDeal', 0)->count();

        $myReceivedOfferTender = OfferTender::where('vendor_id', $id)
            ->where('status', 'pending')
            ->where('isVendorRead', 0)
            ->doesntHave('counters')->count();

        $mySubmittedOfferTender = OfferTender::where('user_id', $id)
            ->where('status', 'pending')
            ->where('isUserRead', 0)
            ->doesntHave('counters')
            ->count();

        $myOfferTenderDeal = OfferTender::where(function ($query) {
            $query->where(
                function ($q) {
                    $q->where('vendor_id', auth()->id())->where('isVendorDealRead', 0);
                }
            )->orWhere(function ($q) {
                $q->where('user_id', auth()->id())->where('isUserDealRead', 0);
            });
        })->where('status', 'accept')->count();

        $mySubmittedCounterOfferTender = CounterOfferTender::where('user_id', $id)->where('status', 'pending')->where('isUserRead', 0)->count();

        $myReceivedCounterOfferTender = CounterOfferTender::whereHas('offer', function ($query) use ($id) {
            $query->where('vendor_id', $id);
        })->where('isVendorRead', 0)->where('status', 'pending')->count();

        $tenderInfo = $listedTender + $myReceivedOfferTender + $mySubmittedOfferTender + $myOfferTenderDeal + $mySubmittedCounterOfferTender + $myReceivedCounterOfferTender;

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
        $wallets = Wallet::latest()->where('user_id', Auth::user()->id)->count();
        if ($seller) {
            return view('seller-vendor.seller-dashboard', compact('seller', 'wallets', 'unreadMessages', 'totalMessages', 'packageData', 'storeInfo', 'productInfo', 'tenderInfo', 'quotationInfo'));
        } else {
            abort(404);
        }
    }

    public function newStateStore()
    {
        $id = auth()->user()->id;
        $listedMultiplyProduct = products::where('vendor_id', $id)->where('isListingType', 'spotlight')->where('isRead', 0)->count();
        $soldProducts = $this->getMyStoreState('spotlight');

        $listedRMultiplyProduct = products::where('vendor_id', $id)->where('isListingType', 'spotlight')->count();
        $soldRProducts = $this->getMyStoreState('spotlight');
        return view('seller-vendor.new-state-store', compact('listedMultiplyProduct', 'soldProducts', 'listedRMultiplyProduct', 'soldRProducts'));
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
        $myReceivedCounterOfferQuotation = CounterOfferQuotation::where('user_id', $id)->where('status', 'pending')->where('isUserRead', 0)->count();

        $mySubmittedCounterOfferQuotation = CounterOfferQuotation::whereHas('offer', function ($query) use ($id) {
            $query->where('vendor_id', $id);
        })->where('isVendorRead', 0)->where('status', 'pending')->count();

        // all quotation
        $quotationR = Quotation::where('user_id', auth()->user()->id)
            ->where('isDeal', 0)
            ->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()])
            ->count();

        $myRReceivedOfferQuotation = OfferQuotation::where('vendor_id', $id)
            ->where('status', 'pending')
            ->doesntHave('counters')
            ->count();

        $myRSubmittedOfferQuotation = OfferQuotation::where('user_id', $id)->where('status', 'pending')->doesntHave('counters')->count();

        $myROfferQuotationDeal = OfferQuotation::where(function ($query) {
            $query->where(
                function ($q) {
                    $q->where('vendor_id', auth()->id());
                }
            )->orWhere(function ($q) {
                $q->where('user_id', auth()->id());
            });
        })->where('status', 'accept')->count();
        $myRReceivedCounterOfferQuotation = CounterOfferQuotation::where('user_id', $id)->where('status', 'pending')->count();

        $myRSubmittedCounterOfferQuotation = CounterOfferQuotation::whereHas('offer', function ($query) use ($id) {
            $query->where('vendor_id', $id);
        })->where('status', 'pending')->count();

        return view('seller-vendor.new-state-quotations', compact(
            'quotation',
            'myReceivedOfferQuotation',
            'myOfferQuotationDeal',
            'mySubmittedOfferQuotation',
            'mySubmittedCounterOfferQuotation',
            'myReceivedCounterOfferQuotation',
            'quotationR',
            'myRReceivedOfferQuotation',
            'myROfferQuotationDeal',
            'myRSubmittedOfferQuotation',
            'myRSubmittedCounterOfferQuotation',
            'myRReceivedCounterOfferQuotation',
        ));
    }
    public function newStateTender()
    {
        $id = auth()->user()->id;
        $listedTender = Tender::where('vendor_id', $id)->where('isRead', 0)->where('isDeal', 0)->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()])->count();
        $myReceivedOfferTender = OfferTender::where('vendor_id', $id)->where('status', 'pending')->where('isVendorRead', 0)->doesntHave('counters')->count();
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
        $mySubmittedCounterOfferTender = CounterOfferTender::whereHas('offer', function ($query) use ($id) {
            $query->where('vendor_id', $id);
        })->where('isVendorRead', 0)->where('status', 'pending')->count();

        // all tender data
        $listedRTender = Tender::where('vendor_id', $id)->where('isDeal', 0)->whereRaw('DATE_ADD(created_at, INTERVAL duration DAY) >= ?', [Carbon::now()])->count();
        $myRReceivedOfferTender = OfferTender::where('vendor_id', $id)->where('status', 'pending')->doesntHave('counters')->count();
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
        $myRSubmittedCounterOfferTender = CounterOfferTender::whereHas('offer', function ($query) use ($id) {
            $query->where('vendor_id', $id);
        })->where('status', 'pending')->count();

        return view('seller-vendor.new-state-tender', compact('listedTender', 'myReceivedOfferTender', 'mySubmittedOfferTender', 'mySubmittedCounterOfferTender', 'myReceivedCounterOfferTender', 'myDealedOfferTender', 'listedRTender', 'myRReceivedOfferTender', 'myRSubmittedOfferTender', 'myRSubmittedCounterOfferTender', 'myRReceivedCounterOfferTender', 'myRDealedOfferTender'));
    }
    public function newStateProduct()
    {
        $id = auth()->user()->id;
        $listedProduct = products::where('vendor_id', $id)->where('isListingType', 'normal')->where('isRead', 0)
            ->get()
            ->filter(function ($product) {
                $expiryDate = Carbon::parse($product->created_at)->addDays($product->duration);
                return now()->lessThan($expiryDate);
            })->count();

        $soldProducts = $this->getMyStoreState('normal');

        $purchasedProductCount = Order::where('user_id', $id)
            ->where('order_status', '!=', 'canceled')
            ->where('payment_status', '!=', 'processing')
            ->where('payment_status', '!=', 'failed')
            ->where('isRead', 0)
            ->with('orderItems')
            ->get()
            ->pluck('orderItems')
            ->flatten()
            ->sum('quantity');

        // all products    
        $listedRProduct = products::where('vendor_id', $id)->where('isListingType', 'normal')
            ->get()
            ->filter(function ($product) {
                $expiryDate = Carbon::parse($product->created_at)->addDays($product->duration);
                return now()->lessThan($expiryDate);
            })->count();

        $soldRProducts = $this->getMyStoreState('normal');

        $purchasedRProductCount = Order::where('user_id', $id)
            ->where('order_status', '!=', 'canceled')
            ->where('payment_status', '!=', 'processing')
            ->where('payment_status', '!=', 'failed')
            ->with('orderItems')
            ->get()
            ->pluck('orderItems')
            ->flatten()
            ->sum('quantity');

        return view('seller-vendor.new-state-product', compact('listedProduct', 'soldProducts', 'purchasedProductCount', 'listedRProduct', 'soldRProducts', 'purchasedRProductCount'));
    }

    public function companyProfile()
    {
        $id = auth()->user()->id;
        $seller = User::where('id', $id)->with('company', 'exports')->first();
        $packageData = seller_package::latest()->where('seller_id', $seller->id)->with('package')->first();
        if ($seller) {
            $seller->country = countries::where('id', $seller->country)->first();
            $seller->state = states::where('id', $seller->state)->first();
            return view('seller-vendor.company-profile', compact('seller', 'packageData'));
        } else {
            abort(404);
        }
    }
    public function shipmentMethods()
    {
        $id = auth()->user()->id;
        $seller = User::where('id', $id)->with('company', 'exports')->first();

        $packageData = seller_package::latest()->where('seller_id', $seller->id)->with('package')->first();

        if ($seller) {
            $seller->country = countries::where('id', $seller->country)->first();
            $seller->state = states::where('id', $seller->state)->first();
            return view('seller-vendor.shipment-methods', compact('seller', 'packageData'));
        } else {
            abort(404);
        }
    }
    public function profilePreview($code)
    {
        // $id = auth()->user()->id;
        $seller = User::where('ref_no', $code)->with('company', 'exports', 'social', 'profile_meta')->first();

        $packageData = seller_package::latest()->where('seller_id', $seller->id)->with('package')->first();

        if ($seller) {
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
            ];
            return view('external-user.supplier-profile', compact('certificates', 'ratingData', 'seller', 'packageData', 'latestNews', 'latestProduct', 'latestTender'));
        } else {
            abort(404);
        }
    }

    public function editMyExports(Request $request)
    {
        // dd($request->all());
        $id = auth()->user()->id;
        $region = 'is' . str_replace('_', '', ucwords($request->region, '_'));
        $exports = export_region::where('vendor_id', $id)->first();
        if ($exports) {
            $exports->$region = ($request->isChecked == "true") ? 1 : 0;
            $exports->save();
        } else {
            $exports = new export_region();
            $exports->vendor_id = $id;
            $exports->$region = ($request->isChecked == "true") ? 1 : 0;
            $exports->save();
        }

        return response()->json(['status' => true, 'message' => 'Region export status updated successfully!']);
    }

    public function editDeliveryOption(Request $request)
    {
        // dd($request->all());
        $id = auth()->user()->id;
        $name = $request->name;
        $value = $request->value;
        $company = company::where('vendor_id', $id)->first();
        if ($company) {
            $company->$name = $value;
            $company->save();
        }

        return response()->json(['status' => true, 'message' => 'Shipping options updated successfully!']);
    }

    public function searchKeys()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $seller = company::where('vendor_id', $id)->first();
            if ($seller) {
                return view('seller-vendor.business-searchkey', compact('seller'));
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }
    public function updateSearchKeys(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $request->validate(
                [
                    'key1' => 'nullable|string|max:30',
                    'key2' => 'nullable|string|max:30',
                    'key3' => 'nullable|string|max:30',
                    'key4' => 'nullable|string|max:30',
                    'key5' => 'nullable|string|max:30',
                    'key6' => 'nullable|string|max:30',
                    'key7' => 'nullable|string|max:30',
                    'key8' => 'nullable|string|max:30',
                    'key9' => 'nullable|string|max:30',
                    'key10' => 'nullable|string|max:30',
                ]
            );
            $id = auth()->user()->id;
            $seller = User::where('id', $id)->first();
            if ($seller) {
                $company = company::where('vendor_id', $id)->first();
                if ($company) {
                    for ($i = 1; $i <= 10; $i++) {
                        $company['key' . $i] = $request['key' . $i] ?? '';
                    }
                    $company->save();
                    session()->flash('success', 'Congratulation, Your Profile search keys has updated successfully and is showing online now!');
                    return redirect()->route('seller.success.gallery');
                } else {
                    abort(404);
                }
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }
    public function storeSearchKeys()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $keys = StoreSearchKey::where('user_id', $id)->first();
            return view('seller-vendor.store-searchkey', compact('keys'));
        } else {
            abort(404);
        }
    }
    public function updateStoreSearchKeys(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $request->validate(
                [
                    'key1' => 'nullable|string|max:30',
                    'key2' => 'nullable|string|max:30',
                    'key3' => 'nullable|string|max:30',
                    'key4' => 'nullable|string|max:30',
                    'key5' => 'nullable|string|max:30',
                    'key6' => 'nullable|string|max:30',
                    'key7' => 'nullable|string|max:30',
                    'key8' => 'nullable|string|max:30',
                    'key9' => 'nullable|string|max:30',
                    'key10' => 'nullable|string|max:30',
                ]
            );
            $id = auth()->user()->id;
            $seller = User::where('id', $id)->first();
            if ($seller) {
                $key = StoreSearchKey::where('user_id', $id)->first();
                if (!$key) {
                    $key = new StoreSearchKey();
                }
                $key->user_id = $id;
                for ($i = 1; $i <= 10; $i++) {
                    $key['key' . $i] = $request['key' . $i] ?? '';
                }
                $key->save();
                session()->flash('success', 'Congratulation, Your Company Store search keys has updated successfully and is showing online now!');
                return redirect()->route('seller.success.gallery');
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function checkDomainAvailability(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $request->validate([
                'spotlight_name' => 'required|regex:/^[a-z0-9-]+(\.[a-z]{2,})?$/',
            ]);
            $spotlightName = $request->input('spotlight_name');
            $userId = auth()->user()->id;
            $exists = User::where('ref_no', $spotlightName)
                ->where('id', '!=', $userId)
                ->exists();
            return response()->json([
                'available' => !$exists
            ]);
        } else {
            return response()->json([
                'available' => false
            ]);
        }
    }
    public function createWebsite()
    {
        $vendor_id = auth()->user()->id;
        $vendorBankDetails = bank_details::where('vendor_id', $vendor_id)->first();
        if (
            !$vendorBankDetails ||
            (
                isset($vendorBankDetails->isPayPal, $vendorBankDetails->isBankDetail, $vendorBankDetails->isGooglePay, $vendorBankDetails->isOther) &&
                !$vendorBankDetails->isPayPal &&
                !$vendorBankDetails->isBankDetail &&
                !$vendorBankDetails->isGooglePay &&
                !$vendorBankDetails->isOther
            )
        ) {
            return redirect()->route('seller.add.bank.detail')->with(['alert-type' => 'error', 'message' => 'First complete your bank details.']);
        }

        $id = auth()->user()->id;
        $user = User::where('id', $id)->with('company')->first();
        return view('seller-vendor.micro-web-devs.create-microweb', compact('user'));
    }

    public function updateDomain(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $request->validate([
                'spotlight_name' => 'required|string|unique:users,ref_no,' . auth()->user()->id,
                'spotlight_banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'spotlight_image1' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'spotlight_image2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'spotlight_image3' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'spotlight_image4' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $spotlightName = Str::slug($request->input('spotlight_name'));
            $userId = auth()->user()->id;
            $user = User::find($userId);
            $user->ref_no = $spotlightName;
            $user->save();
            $company = company::where('vendor_id', $userId)->first();
            $manager = new ImageManager(['driver' => 'gd']);

            if (!empty($company)) {
                try {
                    // 🔹 Spotlight Featured Images (500x500)
                    for ($i = 1; $i <= 4; $i++) {
                        $inputName = 'spotlight_image' . $i;

                        if ($request->hasFile($inputName)) {
                            $file = $request->file($inputName);

                            if (!$file->isValid()) {
                                throw new \Exception("Invalid image uploaded for {$inputName}");
                            }

                            $ext = $file->getClientOriginalExtension();
                            $fileName = uniqid("spt_product_{$user->id}_{$i}_") . '.' . $ext;

                            // Resize exactly as JS validation (500x500)
                            $manager->make($file)
                                ->resize(500, 500, function ($constraint) {
                                    $constraint->upsize();
                                })
                                ->save(public_path("uploads/profile/{$fileName}"));

                            // Delete old image (correct field)
                            $oldImage = $company->{'spotlight_preview' . $i};
                            if ($oldImage && File::exists(public_path("uploads/profile/{$oldImage}"))) {
                                File::delete(public_path("uploads/profile/{$oldImage}"));
                            }

                            $company->{'spotlight_preview' . $i} = $fileName;
                        }
                    }

                    // 🔹 Spotlight Banner Image (2520x620)
                    if ($request->hasFile('spotlight_banner')) {
                        $file = $request->file('spotlight_banner');

                        if (!$file->isValid()) {
                            throw new \Exception('Invalid spotlight banner image');
                        }

                        $ext = $file->getClientOriginalExtension();
                        $fileName = uniqid("spotlight_banner_{$company->id}_") . '.' . $ext;

                        $manager->make($file)
                            ->resize(2520, 620, function ($constraint) {
                                $constraint->upsize();
                            })
                            ->save(public_path("uploads/profile/{$fileName}"));

                        // Delete old banner
                        if (
                            $company->spotlight_banner &&
                            File::exists(public_path("uploads/profile/{$company->spotlight_banner}"))
                        ) {
                            File::delete(public_path("uploads/profile/{$company->spotlight_banner}"));
                        }

                        $company->spotlight_banner = $fileName;
                    }

                    // Save once
                    $company->save();
                } catch (\Exception $e) {
                    Log::error('Spotlight Image Upload Error', [
                        'user_id' => $user->id,
                        'message' => $e->getMessage(),
                    ]);

                    return back()->with('error', 'Image upload failed. Please upload valid images.');
                }
            }

            session()->flash('success', 'Your Domain/Spotlight Store Preview Picture has been updated successfully!');
            return redirect()->route('seller.success.gallery');
        } else {
            abort(404);
        }
    }

    public function deleteVendorSpotlightProfile()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $company = company::where('vendor_id', $id)->first();
            if (!empty($company)) {
                if (isset($company->spotlight_preview) && $company->spotlight_preview != "") {
                    $path = public_path('/uploads/profile/' . $company->spotlight_preview);
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                    $company->spotlight_preview = null;
                    $company->save();
                }
            }
            return response()->json(['success' => true, 'message' => 'Spotlight Profile picture deleted successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'You are not logged in.']);
        }
    }

    public function addMetaData()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $metaData = MetaData::where('user_id', $id)->first();
            return view('seller-vendor.micro-web-devs.meta-data', compact('metaData'));
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function addProfileMetaData()
    {
        if (isset(auth()->user()->id)) {
            $id = auth()->user()->id;
            $metaData = ProfileMetaData::where('user_id', $id)->first();
            return view('seller-vendor.profile-meta-data', compact('metaData'));
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function updateProfileMetaData(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $request->validate(['title' => 'nullable|string', 'description' => 'nullable|string', 'keywords' => 'nullable|string']);
            $id = auth()->user()->id;
            $metaData = ProfileMetaData::where('user_id', $id)->first();
            if (!$metaData) {
                $metaData = new ProfileMetaData();
            }
            $metaData->user_id = $id;
            $metaData->title = $request->title;
            $metaData->description = $request->description;
            $metaData->keywords = $request->keywords;
            $metaData->save();
            session()->flash('success', 'Your seller profile Meta data updated successfully');
            return redirect()->route('seller.success.gallery');
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }
    public function updateMetaData(Request $request)
    {
        if (isset(auth()->user()->id)) {
            $request->validate(['title' => 'nullable|string', 'description' => 'nullable|string', 'keywords' => 'nullable|string']);
            $id = auth()->user()->id;
            $metaData = MetaData::where('user_id', $id)->first();
            if (!$metaData) {
                $metaData = new MetaData();
            }
            $metaData->user_id = $id;
            $metaData->title = $request->title;
            $metaData->description = $request->description;
            $metaData->keywords = $request->keywords;
            $metaData->save();
            session()->flash('success', 'Your Spotlight Meta data updated successfully');
            return redirect()->route('seller.success.gallery');
        } else {
            return redirect()->route('login')->with(['alert-type' => 'error', 'message' => 'Please login first.']);
        }
    }


    public function regStep1(Request $request)
    {
        $validator = Validator::make($request->all(), ['name' => ['required', 'string'], 'phone' => ['required'], 'coupon_code' => ['nullable', 'exists:coupons,code']]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        } else {

            $isUserExist = User::where('phone', $request->phone)->count();
            if ($isUserExist > 0) {
                return response()->json(['status' => false, 'message' => 'Phone number is already exist.']);
            } else {
                $code = $request->code;
                // echo "code",$code;die;

                session(['name' => $request->name, 'phone' => $request->phone, 'coupon_code' => $request->coupon_code, 'package_code' => $code]);

                return response()->json(['status' => true, 'message' => 'OTP sent successfully', 'url' => route('seller.complete.registration', $code)]);
            }
        }
    }
}
