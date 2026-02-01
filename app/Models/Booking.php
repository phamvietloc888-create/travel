<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public const STATUSES = ['PENDING', 'CONFIRMED', 'CANCELED', 'COMPLETED'];
    public const PAYMENT_STATUSES = ['UNPAID', 'PENDING', 'PAID', 'FAILED', 'REFUNDED'];

    protected $fillable = [
        'booking_code',
        'user_id',
        'tour_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'travel_date',
        'adult_qty',
        'child_qty',
        'note',
        'promotion_id',
        'discount_amount',
        'total_amount',
        'booking_status',
        'payment_status',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'adult_qty' => 'integer',
        'child_qty' => 'integer',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
