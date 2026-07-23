<?php

namespace App\Services;

use App\Models\User;
use App\Services\Sms\SmsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PasswordRecoveryService
{
    public function __construct(
        protected SmsService $smsService
    ) {}

    public function getAvailableMethods(User $user): array
    {
        $methods = [];

        if ($user->email) {
            $methods[] = 'email';
        }

        if ($user->mobile) {
            $methods[] = 'phone';
        }

        return $methods;
    }

    public function findUserByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function findUserByPhone(string $phone): ?User
    {
        return User::where('mobile', $phone)->first();
    }

    public function sendEmailOtp(User $user, string $ipAddress = null, string $userAgent = null): bool
    {
        $otp = $this->generateOtp();
        $expiryMinutes = config('sms.otp_expiry_minutes', 5);

        $this->createOtpRecord(
            user: $user,
            method: 'email',
            email: $user->email,
            phone: null,
            otp: $otp,
            ipAddress: $ipAddress,
            userAgent: $userAgent,
            expiryMinutes: $expiryMinutes
        );

        $appName = config('app.name', 'Application');
        $subject = "{$appName} Password Reset Code";

        try {
            Mail::raw(
                "Your {$appName} password reset code is: {$otp}\n\nThis code is valid for {$expiryMinutes} minutes.\nDo not share this code with anyone.\n\nIf you did not request a password reset, please ignore this email.",
                function ($message) use ($user, $subject) {
                    $message->to($user->email)
                        ->subject($subject);
                }
            );
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send password reset email', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }

        return true;
    }

    public function sendPhoneOtp(User $user, string $ipAddress = null, string $userAgent = null): bool
    {
        $otp = $this->generateOtp();
        $expiryMinutes = config('sms.otp_expiry_minutes', 5);

        $this->createOtpRecord(
            user: $user,
            method: 'phone',
            email: null,
            phone: $user->mobile,
            otp: $otp,
            ipAddress: $ipAddress,
            userAgent: $userAgent,
            expiryMinutes: $expiryMinutes
        );

        return $this->smsService->sendOtp($user->mobile, $otp);
    }

    public function verifyOtp(string $method, string $identifier, string $otp): array
    {
        $query = DB::table('password_reset_otps')
            ->where('recovery_method', $method)
            ->where('used_at', null)
            ->where('expires_at', '>', Carbon::now());

        if ($method === 'email') {
            $query->where('email', $identifier);
        } else {
            $query->where('phone', $identifier);
        }

        $record = $query->orderByDesc('id')->first();

        if (!$record) {
            return ['success' => false, 'error' => 'No valid recovery session found. Please try again.'];
        }

        if ($record->attempts >= $record->max_attempts) {
            return ['success' => false, 'error' => 'Too many failed attempts. Please request a new code.'];
        }

        DB::table('password_reset_otps')
            ->where('id', $record->id)
            ->increment('attempts');

        if (!Hash::check($otp, $record->otp_hash)) {
            return ['success' => false, 'error' => 'Invalid verification code. Please try again.'];
        }

        DB::table('password_reset_otps')
            ->where('id', $record->id)
            ->update(['used_at' => Carbon::now()]);

        $token = bin2hex(random_bytes(32));

        DB::table('password_reset_tokens')->insert([
            'email' => $record->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now(),
        ]);

        return [
            'success' => true,
            'token' => $token,
            'email' => $record->email,
        ];
    }

    public function resetPassword(string $token, string $email, string $newPassword): bool
    {
        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->orderByDesc('created_at')
            ->first();

        if (!$record || !Hash::check($token, $record->token)) {
            return false;
        }

        if (Carbon::parse($record->created_at)->addHours(6)->isPast()) {
            DB::table('password_reset_tokens')
                ->where('email', $email)
                ->delete();

            return false;
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return false;
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        DB::table('password_reset_tokens')
            ->where('email', $email)
            ->delete();

        DB::table('password_reset_otps')
            ->where('email', $email)
            ->orWhere('phone', $user->mobile)
            ->delete();

        return true;
    }

    protected function createOtpRecord(
        User $user,
        string $method,
        ?string $email,
        ?string $phone,
        string $otp,
        ?string $ipAddress,
        ?string $userAgent,
        int $expiryMinutes
    ): void {
        $maxAttempts = config('sms.max_attempts', 5);

        DB::table('password_reset_otps')->where(function ($query) use ($method, $email, $phone) {
            $query->where('recovery_method', $method);
            if ($method === 'email') {
                $query->where('email', $email);
            } else {
                $query->where('phone', $phone);
            }
        })->update(['used_at' => Carbon::now()]);

        DB::table('password_reset_otps')->insert([
            'user_id' => $user->id,
            'email' => $email,
            'phone' => $phone,
            'otp_hash' => Hash::make($otp),
            'recovery_method' => $method,
            'attempts' => 0,
            'max_attempts' => $maxAttempts,
            'expires_at' => Carbon::now()->addMinutes($expiryMinutes),
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    protected function generateOtp(): string
    {
        return $this->smsService->generateOtp();
    }
}
