<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_email',
        'license_key',
        'product_id',
        'site_url',
        'app_url',
        'machine_id',
        'server_ip',
        'status',
        'expires_at',
        'activated_at',
        'last_check_at',
        'revoked_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'activated_at' => 'datetime',
        'last_check_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    public static function generateKey(): string
    {
        $segments = [];
        for ($i = 0; $i < 4; $i++) {
            $segments[] = strtoupper(Str::random(4));
        }

        return implode('-', $segments);
    }

    public function activations(): HasMany
    {
        return $this->hasMany(LicenseActivation::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForProduct($query, string $productId)
    {
        return $query->where('product_id', $productId);
    }
}
