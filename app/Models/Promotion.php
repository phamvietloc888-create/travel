<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    public const TYPES = ['PERCENT', 'FIXED'];
    public const STATUSES = ['ACTIVE', 'INACTIVE'];

    protected $fillable = [
        'code',
        'title',
        'type',
        'value',
        'min_total',
        'max_discount',
        'total_limit',
        'used_count',
        'start_at',
        'end_at',
        'status',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_total' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'total_limit' => 'integer',
        'used_count' => 'integer',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function usages()
    {
        return $this->hasMany(PromotionUsage::class);
    }
}
