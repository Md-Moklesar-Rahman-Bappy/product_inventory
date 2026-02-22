<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    // ──────── Mass Assignable Attributes ─────────
    protected $fillable = [
        'product_name',
        'price',
        'category_id',
        'brand_id',
        'model_id',
        'serial_no',
        'project_serial_no',
        'position',
        'user_description',
        'remarks',
        'warranty_start',
        'warranty_end',
    ];

    // ──────── Casts ─────────
    protected $casts = [
        'created_at'     => 'datetime',
        'updated_at'     => 'datetime',
        'warranty_start' => 'datetime',
        'warranty_end'   => 'datetime',
    ];

    // ──────── Relationships ─────────
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function model()
    {
        return $this->belongsTo(AssetModel::class, 'model_id');
    }

    // ──────── Mutators ─────────
    public function setSerialNoAttribute($value)
    {
        $this->attributes['serial_no'] = strtoupper(trim($value));
    }

    public function setProjectSerialNoAttribute($value)
    {
        $this->attributes['project_serial_no'] = strtoupper(trim($value));
    }

    // ──────── Accessors for UI ─────────
    public function getCategoryNameAttribute()
    {
        return $this->category?->category_name ?? 'N/A';
    }

    public function getBrandNameAttribute()
    {
        return $this->brand?->brand_name ?? 'N/A';
    }

    public function getModelNameAttribute()
    {
        return $this->model?->model_name ?? 'N/A';
    }

    public function getProjectSerialAttribute()
    {
        return $this->project_serial_no ?? 'N/A';
    }

    public function getWarrantyStatusAttribute()
    {
        if (!$this->warranty_end) return 'unknown';
        return $this->warranty_end->isPast() ? 'expired' : 'active';
    }

    public function getWarrantyCountdownAttribute()
    {
        if (!$this->warranty_end || !$this->warranty_start) {
            return '<span class="text-muted">—</span>';
        }

        $now = Carbon::now(config('app.timezone'));
        $end = $this->warranty_end;
        $expired = $end->isPast();

        if ($expired) {
            return "<span class='badge bg-danger text-white' title='Expired on {$end->format('d M Y')}'>Expired</span>";
        }

        $totalMinutes = $now->diffInMinutes($end);
        $totalDays = floor($totalMinutes / (60 * 24));
        $remainingHours = floor(($totalMinutes % (60 * 24)) / 60);

        $badgeClass = match(true) {
            $totalDays <= 7  => 'bg-danger text-white',
            $totalDays <= 30 => 'bg-warning text-white',
            default          => 'bg-success text-white',
        };

        $tooltip = 'Ends on ' . $end->format('d M Y');
        $text = "{$totalDays} days {$remainingHours} hours";

        return "<span class='badge {$badgeClass}' title='{$tooltip}'>{$text}</span>";
    }

    public function getRemarksDisplayAttribute()
    {
        return $this->remarks
            ? e($this->remarks)
            : '<span class="text-muted">—</span>';
    }

    public function getPositionDisplayAttribute()
    {
        return $this->position
            ? e($this->position)
            : '<span class="text-muted">—</span>';
    }

    public function getUserDescriptionDisplayAttribute()
    {
        return $this->user_description
            ? e($this->user_description)
            : '<span class="text-muted">—</span>';
    }

    // ──────── Warranty Date Accessors ─────────
    public function getWarrantyStartDateAttribute()
    {
        return optional($this->warranty_start)->format('m/d/Y');
    }

    public function getWarrantyEndDateAttribute()
    {
        return optional($this->warranty_end)->format('m/d/Y');
    }

    public function getWarrantyEndTooltipAttribute()
    {
        return $this->warranty_end ? $this->warranty_end->format('d M Y') : '—';
    }

    // ──────── Urgency Helpers ─────────
    public function getUrgencyLevelAttribute()
    {
        if (!$this->warranty_end) return 4;
        if ($this->warranty_end->isPast()) return 0;

        $daysLeft = now()->diffInDays($this->warranty_end);
        return $daysLeft <= 7 ? 1 : ($daysLeft <= 30 ? 2 : 3);
    }

    public function getIsExpiringSoonAttribute()
    {
        if (!$this->warranty_end || $this->warranty_end->isPast()) return false;
        return $this->warranty_end->diffInDays(now()) <= 7;
    }

    // ──────── Scopes ─────────
    public function scopeWithUrgencyOrder($query)
    {
        return $query->select('*')
            ->selectRaw("
                CASE
                    WHEN warranty_end IS NULL THEN 4
                    WHEN warranty_end < NOW() THEN 0
                    WHEN DATEDIFF(warranty_end, NOW()) <= 7 THEN 1
                    WHEN DATEDIFF(warranty_end, NOW()) <= 30 THEN 2
                    ELSE 3
                END AS urgency_level
            ")
            ->orderBy('urgency_level')
            ->orderBy('warranty_end');
    }


    public function scopeExpiringSoon($query)
    {
        return $query->whereDate('warranty_end', '>=', now())
                     ->whereRaw('DATEDIFF(warranty_end, NOW()) <= 7');
    }
}
