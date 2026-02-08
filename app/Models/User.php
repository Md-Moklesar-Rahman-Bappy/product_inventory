<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    // ──────── Fillable Fields ─────────
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'designation',
        'about',
        'address',
        'profile_photo_path',
        'permission',
        'utype',
        'initial_password',
        'credentials_sent_at',
        'status',
    ];

    // ──────── Hidden Fields ─────────
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ──────── Casts ─────────
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ──────── Accessors ─────────

    public function getFormattedMobileAttribute(): string
    {
        if (!$this->mobile) {
            return '<span class="text-muted">—</span>';
        }

        $code = $this->country_code ?? '880'; // fallback to Bangladesh
        return "+{$code} {$this->mobile}";
    }
    public function getProfilePhotoUrlAttribute(): string
    {
        return $this->profile_photo_path && Storage::disk('public')->exists($this->profile_photo_path)
            ? Storage::url($this->profile_photo_path)
            : asset('images/default-profile.png');
    }

    public function getMobileDisplayAttribute(): string
    {
        return $this->mobile ?: '<span class="text-muted">—</span>';
    }

    public function getDesignationDisplayAttribute(): string
    {
        return $this->designation ?: '<span class="text-muted">—</span>';
    }

    public function getRoleLabelAttribute(): string
    {
        return match($this->permission) {
            0 => 'Super Admin',
            1 => 'Admin',
            2 => 'User',
            default => 'Unknown',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return $this->status === 'active'
            ? '<span class="badge bg-success">Active</span>'
            : '<span class="badge bg-danger">Deactivated</span>';
    }

    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    // ──────── Role Helpers ─────────
    public function isSuperadmin(): bool
    {
        return $this->permission === 0;
    }

    public function isAdmin(): bool
    {
        return $this->permission === 1;
    }

    public function isUser(): bool
    {
        return $this->permission === 2;
    }

    // ──────── Status & Verification Helpers ─────────
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isVerified(): bool
    {
        return !is_null($this->email_verified_at);
    }

    public function hasVerifiedEmail(): bool
    {
        return $this->isVerified(); // alias for consistency
    }

    public function shouldSendCredentials(): bool
    {
        return $this->hasVerifiedEmail() &&
            is_null($this->credentials_sent_at) &&
            !is_null($this->initial_password);
    }

    public function sendCredentialsAndLog(string $password): void
    {
        $this->notify(new \App\Notifications\SendCredentialsNotification($password));

        $this->update([
            'credentials_sent_at' => now(),
            'initial_password' => null,
        ]);

        \App\Http\Controllers\ActivityLogController::logAction(
            'send-credentials',
            'User',
            $this->id,
            '<span class="text-info fw-bold">Sent credentials</span> to user: <strong>' . e($this->name) . '</strong>'
        );
    }

    public function credentialsDelivered(): bool
    {
        return !is_null($this->credentials_sent_at);
    }

    // ──────── Query Scopes ─────────
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeDeactivated($query)
    {
        return $query->where('status', 'deactive');
    }

    // ──────── Verification + Audit Wrapper ─────────
    public function sendVerificationAndLog(): void
    {
        $this->sendEmailVerificationNotification();

        \App\Http\Controllers\ActivityLogController::logAction(
            'verification-init',
            'User',
            $this->id,
            '<span class="text-warning fw-bold">Verification email sent</span> to user: <strong>' . e($this->name) . '</strong>'
        );
    }

    // ──────── Create New User ─────────
    public static function newUser($request): self
    {
        $user = new self();

        $user->fill([
            'name'        => $request->name,
            'email'       => $request->email,
            'mobile'      => $request->mobile,
            'designation' => $request->designation,
            'about'       => $request->about,
            'address'     => $request->address,
            'permission'  => $request->permission,
            'utype'       => $request->permission === 1 ? 'ADM' : 'USR',
            'password'    => bcrypt($request->password),
            'status'      => 'active',
        ]);

        if ($request->hasFile('profile_photo_path')) {
            $image = $request->file('profile_photo_path')->store('uploads/users', 'public');
            $user->profile_photo_path = $image;
        }

        $user->save();
        return $user;
    }

    // ──────── Update Existing User ─────────
    public static function updateUser($request, $id): self
    {
        $user = self::findOrFail($id);

        $user->fill([
            'name'        => $request->name,
            'email'       => $request->email,
            'mobile'      => $request->mobile,
            'designation' => $request->designation,
            'about'       => $request->about,
            'address'     => $request->address,
            'permission'  => $request->permission,
            'utype'       => $request->permission === 1 ? 'ADM' : 'USR',
        ]);

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('profile_photo_path')) {
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $image = $request->file('profile_photo_path')->store('uploads/users', 'public');
            $user->profile_photo_path = $image;
        }

        $user->save();
        return $user;
    }

    // ──────── Delete User (Soft Delete) ─────────
    public static function deleteUser($id): void
    {
        $user = self::findOrFail($id);

        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $user->delete();
    }

    // ──────── Restore Soft-Deleted User ─────────
    public static function restoreUser($id): void
    {
        $user = self::withTrashed()->findOrFail($id);
        $user->restore();
    }

    // ──────── Force Delete User ─────────
    public static function forceDeleteUser($id): void
    {
        $user = self::withTrashed()->findOrFail($id);

        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        $user->forceDelete();
    }

    // ──────── Custom Verification Notification ─────────
    public function sendEmailVerificationNotification()
    {
        $this->notify(new class($this) extends VerifyEmail {
            protected $user;

            public function __construct($user)
            {
                $this->user = $user;
            }

            public function toMail($notifiable)
            {
                $verificationUrl = URL::temporarySignedRoute(
                    'verification.verify.public',
                    now()->addMinutes(60),
                    ['id' => $this->user->id, 'hash' => sha1($this->user->getEmailForVerification())]
                );

                                return (new MailMessage)
                    ->subject('Verify Your Email Address')
                    ->line('Click the button below to verify your email.')
                    ->action('Verify Email', $verificationUrl)
                    ->line('If you did not create an account, no further action is required.');
            }
        });
    }
}
