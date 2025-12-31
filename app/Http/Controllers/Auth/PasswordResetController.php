<?php
// app/Http/Controllers/Auth/PasswordResetController.php
namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class PasswordResetController extends Controller
{
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        // Validate the request data
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Here you would typically handle the password reset logic,
        // such as verifying the token, updating the user's password, etc.

        // For now, we'll just redirect back with a success message.

        Mail::send('emails.password-change-confirmation', [ 'user_name' => $user->name,'reset_link' => url('/password/reset')], function ($message) use ($request) {
                    $message->to($request->email)
                        ->subject('Your Password Has Been Successfully Changed');
                });
        return redirect()->route('login')->with('status', 'Password has been reset successfully.');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Reset the password using Laravel's Password broker
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                // You can also automatically login the user here if desired
                // Auth::login($user);
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }
}