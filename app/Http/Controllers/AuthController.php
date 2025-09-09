<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Services\TwilioService;

class AuthController extends Controller
{
    //
    protected $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }

    public function showLogin()
    {
        return view('external-user.login');
    }
    public function forgetPassword()
    {
        return view('external-user.forget-password');
    }

    // Buyer auth
    public function buyerQuickRegister()
    {

        return view('external-user.buyer-quick-register');
    }
    public function buyerRegistrationAfterValidation(Request $request)
    {
        return view('external-user.complete-buyer-register');
    }
    // send otp 
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), ['first_name' => ['required', 'string'], 'email' => ['required', 'email']]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()]);
        } else {
            $otp = rand(10000, 99999);
            // check number is not exist
           
            $isUserExist = User::where('email', $request->email)->first();
            
            if (isset($isUserExist->id)) {
                return response()->json(['status' => false, 'message' => 'Email address is already exist.']);
            } else {
                Mail::send('mail.send-otp', ['otp' => $otp], function ($message) use ($request) {
                    $message->to($request->email)
                        ->subject('Your OTP Code');
                });
                if($request->phone)
                  $this->twilio->sendSms( trim($request->phone), `Your OTP is ${otp}`);
                session(['otp' => $otp, 'first_name' => $request->first_name, 'email' => $request->email]);
                return response()->json(['status' => true, 'message' => 'OTP sent successfully']);
            }
        }
    }
    public function sendOtpForget(Request $request)
    {
        $validator = Validator::make($request->all(), ['email' => ['required']]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Please fill required field.']);
        } else {
            $otp = rand(10000, 99999);
            // check number is not exist
            $user = User::where('email', $request->email)->first();
            if ($user) {
                Cache::put('otp', ['otp' => $otp, 'user_id' => $user->id], now()->addMinutes(10));
                try {
                    Mail::send('mail.send-otp', ['otp' => $otp], function ($message) use ($user) {
                        $message->to($user->email)
                            ->subject('Your OTP Code');
                    });
                    return response()->json(['success' => true, 'message' => 'OTP sent successfully']);
                } catch (\Exception $e) {
                    return response()->json(['success' => false, 'message' => 'Failed to send OTP. Please try again.']);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Email id does not exist.']);
            }
        }
    }
    public function verifyOtpForget(Request $request)
    {
        if (isset($request->otp) && $request->otp != "") {
            $inputOtp = $request->otp;
            $storedOtp = Cache::get('otp');
            if (isset($storedOtp['otp']) && $storedOtp && $storedOtp['otp'] == $inputOtp) {
                $userId = $storedOtp['user_id'];
                Cache::forget('otp');
                session(['isAble' => true, 'user_id' => $userId]);
                return response()->json(['success' => true, 'message' => 'OTP verified successfully']);
            }
            return response()->json(['success' => false, 'message' => 'Invalid or expired OTP']);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid or expired OTP']);
        }
    }

    public function updatePasswordForget(Request $request)
    {
        if (session('isAble')) {
            $validator = Validator::make($request->all(), [
                'newPassword' => 'required|min:8',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => 'Please fill required field']);
            } else {
                $userId = session('user_id');
                $user = User::find($userId);
                $user->password = bcrypt($request->newPassword);
                $user->save();
                session()->forget('isAble');
                session()->forget('user_id');
                if ($user->isComplete == 1) {
                    if (Auth::check()) {
                        Auth::logout();
                    }
                    Auth::login($user);

                    if ($user->account_type == "seller") {
                        $url = route('seller.dashboard');
                    } elseif ($user->account_type == "buyer") {
                        $url = route('buyer.dashboard');
                    } else {
                        $url = route('home');
                    }
                } else {
                    $url = route('home');
                }
                return response()->json(['success' => true, 'message' => 'Password updated successfully', 'url' => $url]);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Please verify OTP first']);
        }
    }
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), ['otp' => ['required', 'max:99999', 'min:10000', 'numeric']]);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'Please fill OTP']);
        } else {
            // get otp from session
            $sessionOtp = session('otp');
            $first_name = session('first_name');
            $email = session('email');
            if ($request->otp == $sessionOtp) {
                $user = new User;
                $user->first_name = $first_name;
                $user->email = $email;
                $user->password = Hash::make('12345678');
                $user->account_type = 'buyer';
                $user->ref_no = uniqid(true);
                $user->save();

                return response()->json(['status' => true, 'message' => 'OTP Successfully Valid', 'url' => route('buyer.complete.profile', $user->ref_no)]);
            } else {
                return response()->json(['status' => false, 'message' => 'Invalid OTP']);
            }
        }
    }

    public function buyerCompleteProfile($ref_no)
    {
        $user = User::latest()->where('ref_no', $ref_no)->first();
        if (empty($user)) {
            abort(404);
        } else {

            return view('external-user.complete-buyer-register', compact('user'));
        }
    }
    public function completeMyProfile(Request $request)
    {
        $is_user = User::where('id', $request->id)->where('isComplete', 1)->first();
        if (!$is_user) {
            $rules =  [
                'id' => 'required|exists:users,id',
                'first_name' => 'required|string',
                'last_name' => 'nullable|string',
                'phone' => 'required|unique:users,phone,' . $request->id,
                'email' => 'required|email|unique:users,email,' . $request->id,
                'password' => ['required', 'min:8', 'confirmed'],
                'country' => 'required|string',
                'state' => 'required|string',
                'city' => 'required|string',
                'zip' => 'nullable|numeric',
                'street_name' => 'nullable|string',
                'house_no' => 'nullable|string',
            ];
        } else {
            $rules =  [
                'id' => 'required|exists:users,id',
                'first_name' => 'required|string',
                'last_name' => 'nullable|string',
                'phone' => 'required|unique:users,phone,' . $request->id,
                'email' => 'required|email|unique:users,email,' . $request->id,
                'password' => ['nullable', 'min:8', 'confirmed'],
                'country' => 'required|string',
                'state' => 'required|string',
                'city' => 'required|string',
                'zip' => 'nullable|numeric',
                'street_name' => 'nullable|string',
                'house_no' => 'nullable|string',
            ];
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first(), 'error' => $validator->errors()]);
        } else {
            $user = User::where('id', $request->id)->first();
            if (!empty($user)) {
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->phone = $request->phone;
                $user->email = $request->email;
                $password = $request->password;
                if ($request->filled('password')) {
                    $user->password = bcrypt($password);
                }
                $user->country = $request->country;
                $user->state = $request->state;
                $user->city = $request->city;
                $user->zip = $request->zip;
                $user->street = $request->street_name;
                $user->house_no = $request->house_no;
                $user->isComplete = 1;
                $user->save();
                Auth::login($user);
                
                if (isset($is_user->id)) {
                    session()->flash('success', 'Congratulation, Your Profile has updated successfuly!');
                    $url = route('buyer.success');
                    $msg="Successfully complete your profile.";
                }else{
                    $url = route('buyer.dashboard');
                    $msg="Successfully update your profile.";
                }
                return response()->json(['status' => true, 'message' => $msg,'url'=>$url]);
            } else {
                return response()->json(['status' => false, 'message' => 'This Buyer account could not found.']);
            }
        }
    }

    public function loginNow(Request $request)
    {
        $validator = Validator::make($request->all(), ['email_phone' => ['required'], 'password' => ['required', 'min:8']]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput($request->all());
        } else {
            // check user 
            $user = User::where('email', $request->email_phone)->orWhere('phone', $request->email_phone)->first();
            if (!empty($user)) {

                if (Hash::check($request->password, $user->password)) {
                    if ($user->isComplete == 1) {
                        if (Auth::check()) {
                            Auth::logout();
                        }
                        Auth::login($user);
                        if ($user->account_type == "seller") {
                            return redirect()->route('seller.dashboard');
                        } elseif ($user->account_type == "buyer") {
                            return redirect()->route('buyer.dashboard');
                        } else {
                            return redirect()->route('home');
                        }
                    } else {

                        if ($user->account_type == "seller") {
                            // dd($user);
                            return redirect()->route('seller.complete.registration', $user->ref_no)->with(['alert-type' => 'warning', 'message' => 'Please complete profile!']);
                        } elseif ($user->account_type == "buyer") {
                            return redirect()->route('buyer.complete.profile', $user->ref_no)->with(['alert-type' => 'warning', 'message' => 'Please complete profile!']);
                        } else {
                            return back()->with(['alert-type' => 'warning', 'message' => 'Something went to wrong!']);
                        }
                    }
                } else {

                    return back()->withErrors(['email_phone' => 'Credential are wrong. Try again with correct.'])->withInput($request->all());
                }
            } else {
                return back()->withErrors(['email_phone' => 'Provided email or phone does not matched.'])->withInput($request->all());
            }
        }
    }
    public function logout()
    {
        Auth::logout();


        return redirect()->route('home');
    }
}
