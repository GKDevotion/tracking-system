<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user = User::where($fieldType, $request->login)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->error('Invalid credentials.', 401);
        }

        if ($user->status !== 'active') {
            return $this->error('Account is inactive.', 403);
        }

        $token = $user->createToken('mobile-app')->plainTextToken;

        return $this->success('Login successful.', [
            'token' => $token,
            'user'  => $user->load('role'),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->success('Logged out successfully.');
    }

    public function me(Request $request)
    {
        return $this->success('Authenticated user.', $request->user()->load('role'));
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        PasswordResetOtp::where('email', $request->email)->delete();

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        PasswordResetOtp::create([
            'email'      => $request->email,
            'otp'        => $otp,
            'expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($request->email)->send(new OtpMail($otp));

        return $this->success('OTP sent to your email.');
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
            return $this->error('Invalid OTP.', 422);
        }

        $record->increment('attempts');

        if (!$record->isValid()) {
            return $this->error('OTP expired or too many attempts.', 422);
        }

        return $this->success('OTP verified.', ['verified' => true]);
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
            return $this->error('Invalid or expired OTP.', 422);
        }

        User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
        $record->update(['used_at' => now()]);

        return $this->success('Password reset successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password'         => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        if (!Hash::check($request->current_password, $request->user()->password)) {
            return $this->error('Current password is incorrect.', 422);
        }

        $request->user()->update(['password' => Hash::make($request->password)]);

        return $this->success('Password changed successfully.');
    }

    private function success(string $message, $data = null)
    {
        return response()->json(['status' => true, 'message' => $message, 'data' => $data]);
    }

    private function error(string $message, int $code = 400)
    {
        return response()->json(['status' => false, 'message' => $message, 'data' => null], $code);
    }
}
