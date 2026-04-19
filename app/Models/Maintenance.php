<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Maintenance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'description',
        'performed_at',
        'start_time',
        'end_time',
        'user_id',
    ];

    protected $casts = [
        'performed_at' => 'datetime',
        'start_time'   => 'datetime',
        'end_time'     => 'datetime',
        'description'  => 'string',
    ];

    protected $dates = ['deleted_at'];

    // ──────── Relationships ─────────
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ──────── Accessors ─────────
    public function getPerformedAtFormattedAttribute(): string
    {
        return $this->performed_at
            ? $this->performed_at->format('d M Y, h:i A')
            : '—';
    }

    public function getUserNameAttribute(): string
    {
        return $this->user?->name ?? 'Unknown';
    }

    public function getDurationAttribute(): string
    {
        if ($this->start_time && $this->end_time) {
            $minutes = $this->end_time->diffInMinutes($this->start_time);
            return $minutes . ' min';
        }
        return '—';
    }
}
