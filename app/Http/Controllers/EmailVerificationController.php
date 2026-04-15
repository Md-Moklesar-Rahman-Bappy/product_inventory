<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\SendCredentialsNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class EmailVerificationController extends Controller
{
    /**
     * Display the email verification notice.
     */
    public function show()
    {
        return view('auth.verify');
    }

    /**
     * Resend the email verification notification.
     */
    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', '📧 Verification link sent!');
    }

    /**
     * Mark the user's email address as verified.
     */
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid verification link.');
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));

            if ($user->shouldSendCredentials()) {
                try {
                    $password = Crypt::decryptString($user->initial_password);
                    $user->notify(new SendCredentialsNotification($password));

                    $user->update([
                        'credentials_sent_at' => now(),
                        'initial_password' => null,
                    ]);

                    ActivityLogController::logAction(
                        'send-credentials',
                        'User',
                        $user->id,
                        '<span class="text-info fw-bold">Verified email</span> and sent credentials to user: <strong>' . e($user->name) . '</strong>'
                    );
                } catch (\Exception $e) {
                    Log::error('Credential decryption failed for user ID ' . $user->id, ['error' => $e->getMessage()]);
                }
            }
        }

        return redirect()->route('login')->with('message', '✅ Your email has been verified. Please check your inbox for login credentials.');
    }
}
