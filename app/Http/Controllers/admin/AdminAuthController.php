<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    //
    public function loginPage()
    {
        return view('admin.login');
    }
    public function loginNow(Request $request)
    {
        $validator = Validator::make($request->all(), ['username' => ['required'], 'password' => ['required', 'min:8']]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withInput($request->all());
        } else {
            // check user 
            $user = User::where('email', $request->username)->orWhere('phone', $request->username)->first();
            if (!empty($user)) {
                if ($user->account_type == 'admin') {

                    if (Hash::check($request->password, $user->password)) {
                        if (Auth::check()) {

                            Auth::logout();
                        }
                        Auth::login($user);
                        return redirect()->route('admin.dashboard')->with(['alert-type' => 'success', 'message' => 'Logged in successfully']);
                    } else {

                        return back()->withErrors($validator->errors())->withInput($request->all())->with(['alert-type' => 'error', 'message' => 'Admin credentials are wrong!']);
                    }
                } else {

                    return back()->with(['alert-type' => 'error', 'message' => 'Admin not found!'])->withInput($request->all());
                }
            } else {
                return back()->withErrors($validator->errors())->with(['alert-type' => 'error', 'message' => 'Admin credential mismatched!'])->withInput($request->all());
            }
        }
    }
    public function logout()
    {
        Auth::logout();


        return redirect()->route('admin.login');
    }
    public function adminPassword()
    {
        return view('admin.admin_profile.change-password');
    }
    public function updateAdminPassword(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'email' => 'required|exists:users,email',
            'current_password' => ['required', 'min:8'],
            'new_password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'min:8', 'same:new_password'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->with(['alert-type' => 'error', 'message' => 'Validation failed!'])->withInput($request->all());
        } else {
            $admin = User::where('email', $request->email)->where('account_type', 'admin')->first();
            if (!empty($admin)) {
                if (Hash::check($request->current_password, $admin->password)) {
                    $admin->password = Hash::make($request->new_password);
                    $admin->save();
                    return back()->with(['alert-type' => 'success', 'message' => 'Password updated successfully!']);
                } else {
                    return back()->with(['alert-type' => 'error', 'message' => 'Current password is wrong!']);
                }
            }
        }
    }
}
