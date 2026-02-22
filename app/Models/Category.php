<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['category_name', 'status'];

    // ──────── Relationships ─────────
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // ──────── Accessors for UI ─────────
    public function getDisplayBadgeAttribute()
    {
        return "<span class='badge bg-warning text-dark'>{$this->category_name}</span>";
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'active'   => "<span class='badge bg-success'>Active</span>",
            'inactive' => "<span class='badge bg-secondary'>Inactive</span>",
            default    => "<span class='badge bg-light text-muted'>Unknown</span>",
        };
    }

    public function getTrashedBadgeAttribute()
    {
        return $this->trashed()
            ? "<span class='badge bg-danger'>Archived</span>"
            : '';
    }

    public function getNameDisplayAttribute()
    {
        return $this->category_name ?? '<span class="text-muted">—</span>';
    }

    public function getStatusDisplayAttribute()
    {
        return $this->status ?? '<span class="text-muted">—</span>';
    }
}
