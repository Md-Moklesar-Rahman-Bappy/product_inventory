<?php

namespace App\Http\Controllers;

use App\Services\PasswordRecoveryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    public function __construct(
        protected PasswordRecoveryService $recoveryService
    ) {}

    public function showMethodForm()
    {
        return view('auth.forgot-password-method');
    }

    public function showEmailForm()
    {
        return view('auth.forgot-password-email');
    }

    public function sendEmailOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = $this->recoveryService->findUserByEmail($request->email);

        if (!$user) {
            return back()->withErrors(['email' => 'No account found with that email address.']);
        }

        $sent = $this->recoveryService->sendEmailOtp(
            user: $user,
            ipAddress: $request->ip(),
            userAgent: $request->userAgent()
        );

        if (!$sent) {
            return back()->withErrors(['email' => 'Failed to send verification email. Please try again.']);
        }

        Session::put('recovery_method', 'email');
        Session::put('recovery_identifier', $request->email);

        return redirect()->route('password.forgot.otp.form')
            ->with('success', 'A verification code has been sent to your email.');
    }

    public function showPhoneForm()
    {
        return view('auth.forgot-password-phone');
    }

    public function sendPhoneOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        $user = $this->recoveryService->findUserByPhone($request->phone);

        if (!$user) {
            return back()->withErrors(['phone' => 'No account found with that phone number.']);
        }

        $sent = $this->recoveryService->sendPhoneOtp(
            user: $user,
            ipAddress: $request->ip(),
            userAgent: $request->userAgent()
        );

        if (!$sent) {
            return back()->withErrors(['phone' => 'Failed to send SMS. Please try again.']);
        }

        Session::put('recovery_method', 'phone');
        Session::put('recovery_identifier', $request->phone);

        return redirect()->route('password.forgot.otp.form')
            ->with('success', 'A verification code has been sent to your phone.');
    }

    public function showOtpForm()
    {
        $method = Session::get('recovery_method');
        $identifier = Session::get('recovery_identifier');

        if (!$method || !$identifier) {
            return redirect()->route('password.forgot');
        }

        $masked = $method === 'email'
            ? $this->maskEmail($identifier)
            : $this->maskPhone($identifier);

        return view('auth.forgot-password-otp', [
            'method' => $method,
            'identifier' => $identifier,
            'masked_identifier' => $masked,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $method = Session::get('recovery_method');
        $identifier = Session::get('recovery_identifier');

        if (!$method || !$identifier) {
            return redirect()->route('password.forgot');
        }

        $result = $this->recoveryService->verifyOtp($method, $identifier, $request->otp);

        if (!$result['success']) {
            return back()->withErrors(['otp' => $result['error']]);
        }

        Session::forget(['recovery_method', 'recovery_identifier']);
        Session::put('reset_token', $result['token']);
        Session::put('reset_email', $result['email']);

        return redirect()->route('password.forgot.reset.form')
            ->with('success', 'Identity verified. You may now set a new password.');
    }

    public function showResetForm()
    {
        $token = Session::get('reset_token');
        $email = Session::get('reset_email');

        if (!$token || !$email) {
            return redirect()->route('password.forgot');
        }

        return view('auth.forgot-password-reset', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $result = $this->recoveryService->resetPassword(
            token: $request->token,
            email: $request->email,
            newPassword: $request->password
        );

        if (!$result) {
            return back()->withErrors(['password' => 'Invalid or expired reset link. Please start over.']);
        }

        Session::forget(['reset_token', 'reset_email']);

        return redirect()->route('login')
            ->with('success', 'Password has been reset successfully. You may now log in.');
    }

    protected function maskEmail(string $email): string
    {
        [$local, $domain] = explode('@', $email, 2);
        $maskedLocal = substr($local, 0, 2) . str_repeat('*', max(strlen($local) - 2, 3));

        return "{$maskedLocal}@{$domain}";
    }

    protected function maskPhone(string $phone): string
    {
        $clean = preg_replace('/[^0-9]/', '', $phone);
        $len = strlen($clean);

        if ($len <= 4) {
            return str_repeat('*', $len);
        }

        $visible = substr($clean, -4);
        $masked = str_repeat('*', $len - 4);

        return str_repeat('*', max(0, $len - 4)) . $visible;
    }
}
