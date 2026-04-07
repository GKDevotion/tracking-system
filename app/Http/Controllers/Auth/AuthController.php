<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ─── Login ───────────────────────────────────────────────────────────────

    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [$fieldType => $request->login, 'password' => $request->password];

        $user = User::where($fieldType, $request->login)->first();

        if (!$user || $user->status !== 'active') {
            return back()->withErrors(['login' => 'Account not found or inactive.'])->withInput();
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('web.dashboard'));
        }

        return back()->withErrors(['login' => 'Invalid credentials.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // ─── Forgot Password ─────────────────────────────────────────────────────

    public function forgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Invalidate old OTPs
        PasswordResetOtp::where('email', $request->email)->delete();

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        PasswordResetOtp::create([
            'email'      => $request->email,
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($request->email)->send(new OtpMail($otp));

        return redirect()->route('otp.verify.form')
            ->with('email', $request->email)
            ->with('success', 'OTP sent to your email address.');
    }

    public function otpForm(Request $request)
    {
        return view('auth.otp-verify', ['email' => session('email')]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|string|size:6',
        ]);

        $record = PasswordResetOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'Invalid OTP.'])->with('email', $request->email);
        }

        $record->increment('attempts');

        if (!$record->isValid()) {
            return back()->withErrors(['otp' => 'OTP expired or too many attempts.'])->with('email', $request->email);
        }

        return redirect()->route('reset.password.form')
            ->with('email', $request->email)
            ->with('otp', $request->otp);
    }

    public function resetForm(Request $request)
    {
        return view('auth.reset-password', [
            'email' => session('email'),
            'otp'   => session('otp'),
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email|exists:users,email',
            'otp'      => 'required|string|size:6',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        $record = PasswordResetOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$record || !$record->isValid()) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        $record->update(['used_at' => now()]);

        return redirect()->route('login')->with('success', 'Password reset successfully. Please login.');
    }

    // ─── Change Password ──────────────────────────────────────────────────────

    public function changePasswordForm()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password'         => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        Auth::user()->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully.');
    }
}
