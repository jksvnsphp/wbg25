<?php

namespace App\Http\Controllers;

use App\Models\business_profile_symbol;
use App\Models\Coupon;
use App\Models\memberPackage;
use App\Models\packageService;
use App\Models\seller_package;
use App\Models\User;
use App\Models\company;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Quotation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
class PayPalController extends Controller
{
    private function createUniqueSlug1($title, $id = null)
    {

        $slug = Str::slug($title);
        if ($id) {
            $existing = Quotation::find($id);
            if ($existing && $existing->slug === $slug) {
                return $slug;
            }
        }
        $count = Quotation::where('slug', 'LIKE', "{$slug}%")
            ->when($id, function ($query) use ($id) {
                return $query->where('id', '!=', $id);
            })
            ->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }
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
    // ---------------------------------------------------
    // GET SESSION DATA (Set earlier during registration step)
    // ---------------------------------------------------
    $signupData = Session::get('signup_data');  // <-- all form data
    $packageCode = Session::get('package_code');
    $couponCode = Session::get('coupon_code');

    if (!$signupData || !$packageCode) {
        return redirect()->route('register')->with('error', 'Session expired. Please register again.');
    }

    // ---------------------------------------------------
    // GET PACKAGE
    // ---------------------------------------------------
    $packageData = memberPackage::where('code', $packageCode)->first();
    if (!$packageData) {
        //return redirect()->route('home')->with('error', 'Invalid package.');
		return back()->with('error', 'Invalid package.');
    }

    // ---------------------------------------------------
    // COUPON LOGIC (unchanged)
    // ---------------------------------------------------
    $discount = 0;
    if ($couponCode) {
        $coupon = Coupon::where('code', $couponCode)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('is_active', 1)
            ->first();

        if ($coupon) {
            if ($coupon->percent_type == 'percentage') {
                $discount = ($packageData->price * $coupon->discount) / 100;
            } else {
                $discount = $coupon->discount; // flat discount
            }
        }
    }

    $amount = number_format(($packageData->price - $discount), 2, '.', '');


    // ---------------------------------------------------
    // SAVE PAYMENT TEMP SESSION (to use after PayPal success)
    // ---------------------------------------------------
    Session::put('payment_temp', [
        'package_id'   => $packageData->id,
        'package_code' => $packageCode,
        'package_price'=> $packageData->price,
        'discount'     => $discount,
        'coupon_code'  => $couponCode,
        'final_price'  => $amount,
        'validDays'    => $packageData->validDays ?? 90,
        'trade_credits'=> $packageData->tradeLeadsInclude,
        'package_type' => $packageData->type,
    ]);

    // ---------------------------------------------------
    // CASE 1: Amount > 0 → Go to PayPal
    // ---------------------------------------------------
    if ($amount > 0) {
        try {
            $provider = new PayPalClient();
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
                    [
                        "amount" => [
                            "currency_code" => "EUR",
                            "value" => (string)$amount
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
            }

            return back()->with('error', 'Payment error. Please try again.');
        } catch (\Exception $e) {
            Log::error('PayPal createOrder error: ' . $e->getMessage());
            return back()->with('error', 'Unable to initialize PayPal payment. Please try again later.');
        }
    }

    // ---------------------------------------------------
    // CASE 2: Discount makes amount = 0 (FREE after coupon)
    // ---------------------------------------------------
    elseif ($amount <= 0 && $packageData->price > 0) {

        // Payment will be "discount"
        Session::put('payment_temp.payment_mode', 'DISCOUNT');

        // Redirect directly to PayPal success (no payment)
        return redirect()->route('paypal.free.success');
    }

    // ---------------------------------------------------
    // CASE 3: FREE PACKAGE (price = 0)
    // ---------------------------------------------------
    else {

        Session::put('payment_temp.payment_mode', 'FREE');
 
        // Redirect directly to PayPal success (no payment)
       // die('Feee package debug');
        return redirect()->route('paypal.free.success');
    }
}

public function paypalStatus(Request $request)
{
    $signup = Session::get('signup_data');
    $paymentTemp = Session::get('payment_temp');

    if (!$signup || !$paymentTemp) {
        return redirect()->route('register')->with('error', 'Session expired. Please register again.');
    }

    // -------------------------------
    // VERIFY PAYPAL PAYMENT
    // -------------------------------
    $provider = new PayPalClient();
    $provider->setApiCredentials(config('paypal'));
    $token = $provider->getAccessToken();
    $provider->setAccessToken($token);

    $response = $provider->capturePaymentOrder($request->token);

    if (!isset($response['status']) || $response['status'] !== "COMPLETED") {
        //return redirect()->route('home')->with('error', 'Payment failed.');
	return back()->with('error', 'Payment failed.');
    }

    // PAYMENT SUCCESS → Create User
    //return $this->finalizeUserAndPackage($signup, $paymentTemp, $response['id']);
	//print_r($signup);
	$paymentId = $response['id'] ?? null;
    DB::beginTransaction();

    try {
        //--------------------------------
        // 1. CREATE USER
        //--------------------------------
        $user = new User();
        $user->first_name = $signup['first_name'];
        //$user->last_name = $signup['last_name'];
        $user->email = $signup['email'];
        $user->phone = $signup['phone'];
        $user->password = bcrypt($signup['password']);
        $user->country = $signup['country'];
        $user->state = $signup['state'];
        $user->city = $signup['city'];
        $user->zip = $signup['zip'];
        $user->street = $signup['street'];
        $user->house_no = $signup['house_no'];
        $user->account_type = 'seller';
        $user->ref_no = uniqid(true);
        $user->isComplete = 1;
        $user->save();

        //--------------------------------
        // 2. CREATE COMPANY
        //--------------------------------
        $company = new company();
        $company->name = $signup['company_name'];
        $company->slug = $this->createUniqueSlug1($signup['company_name']);
        $company->vendor_id = $user->id;
        $company->company_registeration_year = $signup['registration_year'];
        $company->key_personnal = $signup['number_of_employees'];
        $company->business_type = $signup['business_type'];
        $company->certifications = json_encode($signup['certifications'] ?? []);
        $company->other_certificate = json_encode($signup['other_certificate'] ?? []);
        $company->category_1 = $signup['company_category'];
        $company->category_2 = $signup['company_sub_category'];
        $company->save();

        //--------------------------------
        // 3. CREATE PACKAGE ENTRY
        //--------------------------------
        $packageSeller = new seller_package();
        $packageSeller->seller_id = $user->id;
        $packageSeller->package_id = $paymentTemp['package_id'];
        $packageSeller->payment_id = $paymentId;
        $packageSeller->payment_status = 'paid';
        $packageSeller->price = $paymentTemp['package_price'];
        $packageSeller->coupon_code = $paymentTemp['coupon_code'];
        $packageSeller->discount = $paymentTemp['discount'];

        $packageSeller->billing_detail = json_encode([]);
        $packageSeller->package_info = json_encode([]);

        $packageSeller->expire_at = now()->addDays($paymentTemp['validDays'])->format('Y-m-d');
        $packageSeller->save();
        $package_type= getMemberPackageType($paymentTemp['package_id']);

        //--------------------------------
        // 4. WALLET CREDITS
        //--------------------------------
        $wallet = new Wallet();
        $wallet->user_id = $user->id;
        $wallet->credit = $paymentTemp['trade_credits'];
        $wallet->save();

        //--------------------------------
        // 5. BUSINESS SYMBOL
        //--------------------------------
        $this->functionHandleBusinessSymbole($paymentTemp['package_type'], $user->id);
        $type ='welcome_mail__silver_package';
         //--------------------------------
        if($package_type=='gold'){    
            $type = 'welcome_mail__gold_package';
        }else if($package_type=='silver'){    
            $type = 'welcome_mail__silver_package';    
        }   else if($package_type=='platinum'){    
            $type = 'welcome_mail__platinum_package';    
        }

        //sendWelcomeMail($user->id, $type,$signup['password'] = null);

        sendDynamicMail(
            $user->id,
            $type, // slug from email_templates
            [
                '[User Name]' =>$user->first_name, 
                '[Email]'     =>$user->email,
                '[Password]'  => $signup['password']
            ]
        );
        //--------------------------------
        // 6. LOGIN USER
        //--------------------------------
        Auth::login($user);

        //--------------------------------
        // 7. CLEAR SESSIONS
        //--------------------------------
        Session::forget('signup_data');
        Session::forget('payment_temp');
        Session::forget('package_code');
        Session::forget('coupon_code');

        DB::commit();

        return redirect()->route('seller.dashboard')->with('success', 'Account created successfully.');

    } catch (\Exception $e) {
        DB::rollback();
		//dd($e->getMessage(), $e->getTraceAsString());
		//echo 'error';
        return redirect()->route('home')->with('error', $e->getMessage());
    }

	
	
	
	
	
	
}
public function paypalFreeSuccess()
{
    $signup = Session::get('signup_data');
    $paymentTemp = Session::get('payment_temp');
    

    if (!$signup || !$paymentTemp) {
        return redirect()->route('register')->with('error', 'Session expired. Please register again.');
    }

    // No PayPal payment ID for free package.
    $paymentId = strtoupper($paymentTemp['payment_mode']) . '_' . uniqid();

      $this->finalizeUserAndPackage($signup, $paymentTemp, $paymentId);
      
       return redirect()->route('home')->with('success', 'Account created successfully.');
}
private function finalizeUserAndPackage($signup, $paymentTemp, $paymentId)
{         

    
    DB::beginTransaction();

    try {
        //--------------------------------
        // 1. CREATE USER
        //--------------------------------
        $user = new User();
        $user->first_name = $signup['first_name'];
        //$user->last_name = $signup['first_name'];
        $user->email = $signup['email'];
        $user->phone = $signup['phone'];
        $user->password = bcrypt($signup['password']);
        $user->country = $signup['country'];
        $user->state = $signup['state'];
        $user->city = $signup['city'];
        $user->zip = $signup['zip'];
        $user->street = $signup['street'];
        $user->house_no = $signup['house_no'];
        $user->account_type = 'seller';
        $user->ref_no = uniqid(true);
        $user->isComplete = 1;
        $user->save();
         

        //--------------------------------
        // 2. CREATE COMPANY
        //--------------------------------
        $company = new Company();
        $company->name = $signup['company_name'];
        $company->slug = $this->createUniqueSlug1($signup['company_name']);
        $company->vendor_id = $user->id;
        $company->company_registeration_year = $signup['registration_year'];
        $company->key_personnal = $signup['number_of_employees'];
        $company->business_type = $signup['business_type'];
        $company->certifications = json_encode($signup['certifications']);
        $company->other_certificate = json_encode($signup['other_certificate']);
        $company->category_1 = $signup['company_category'];
        $company->category_2 = $signup['company_sub_category'];
        $company->save();

        //--------------------------------
        // 3. CREATE PACKAGE ENTRY
        //--------------------------------
        $packageSeller = new seller_package();
        $packageSeller->seller_id = $user->id;
        $packageSeller->package_id = $paymentTemp['package_id'];
        $packageSeller->payment_id = $paymentId;
        $packageSeller->payment_status = 'paid';
        $packageSeller->price = $paymentTemp['package_price'];
        $packageSeller->coupon_code = $paymentTemp['coupon_code'];
        $packageSeller->discount = $paymentTemp['discount'];

        $packageSeller->billing_detail = json_encode([]);
        $packageSeller->package_info = json_encode([]);

        $packageSeller->expire_at = now()->addDays($paymentTemp['validDays'])->format('Y-m-d');
        $packageSeller->save();

        //--------------------------------
        // 4. WALLET CREDITS
        //--------------------------------
        $wallet = new Wallet();
        $wallet->user_id = $user->id;
        $wallet->credit = $paymentTemp['trade_credits'];
        $wallet->save();

        //--------------------------------
        // 5. BUSINESS SYMBOL
        //--------------------------------
        $this->functionHandleBusinessSymbole($paymentTemp['package_type'], $user->id);
        //sendBronzeWelcomeMail($user->id, $signup['password'] = null);
     
        sendDynamicMail(
            $user->id,
            'welcome_mail__bronce_package', // slug from email_templates
            [
                '[User Name]' =>$user->first_name, 
                '[Email]'     =>$user->email,
                '[Password]'  => $signup['password']
            ]
        );

        //--------------------------------
        // 6. LOGIN USER
        //--------------------------------
        Auth::login($user);

        //--------------------------------
        // 7. CLEAR SESSIONS
        //--------------------------------
        Session::forget('signup_data');
        Session::forget('payment_temp');
        Session::forget('package_code');
        Session::forget('coupon_code');

        DB::commit();

        //return redirect()->route('home')->with('success', 'Account created successfully.');

    } catch (\Exception $e) {
        DB::rollback();
         
		//dd($e->getMessage(), $e->getTraceAsString());
    
      /// print_r($e->getMessage());die;
        
        return redirect()->route('home')->with('error', $e->getMessage());
    }
}


   public function payWithPayPal_old()
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
            if ($coupon->percent_type == 'percentage') {
                // e.g., 10% off
                $discount = ($packageData->price * $coupon->discount) / 100;
            } else {
                // flat discount, e.g., ₹100 off
                $discount = $coupon->discount;
            }

            //$finalPrice = max($cartTotal - $discountAmount, 0);
        }
       
        $amount = $packageData->price - $discount;
        $validDays = $packageData->validDays ?? 90;
 
      //  echo "amount=>". $amount;die;
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
                return redirect()->route('home')->with('error', 'Payment error. Please try again.');
            } else {
                return redirect()->route('home')->with('error', $response['message'] ?? 'Something went wrong.');
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

    public function payPalStatus_old(Request $request)
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
