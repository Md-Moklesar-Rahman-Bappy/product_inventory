<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LicenseActivation extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_id',
        'site_url',
        'app_url',
        'machine_id',
        'server_ip',
        'product_id',
        'app_version',
        'status',
        'message',
    ];

    public function license(): BelongsTo
    {
        return $this->belongsTo(License::class);
    }
}
