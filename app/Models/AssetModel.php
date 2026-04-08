<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'model_name',
        'status',
    ];

    protected $dates = ['deleted_at']; // Optional: for Carbon formatting

    // ──────── Relationships ─────────
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
