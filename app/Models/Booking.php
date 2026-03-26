<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Booking extends Model
{
    use HasFactory;

    protected static ?bool $supportsCustomerNotifications = null;
    protected static ?bool $supportsExtendedWorkflowFields = null;

    public const STATUSES = ['PENDING', 'CONFIRMED', 'CANCELED', 'COMPLETED'];
    public const PAYMENT_STATUSES = ['UNPAID', 'PENDING', 'PAID', 'FAILED', 'REFUNDED'];

    protected $fillable = [
        'user_id',
        'tour_id',
        'booking_code',
        'customer_name',
        'customer_phone',
        'customer_email',
        'travel_date',
        'adult_qty',
        'child_qty',
        'note',
        'admin_note',
        'total_amount',
        'discount_amount',
        'booking_status',
        'payment_status',
        'payment_ready_at',
        'customer_notice',
        'customer_notice_read_at',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'adult_qty' => 'integer',
        'child_qty' => 'integer',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'payment_ready_at' => 'datetime',
        'customer_notice_read_at' => 'datetime',
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

    public function hasUnreadCustomerNotice(): bool
    {
        return !empty($this->customer_notice) && $this->customer_notice_read_at === null;
    }

    public function canUserPay(): bool
    {
        return $this->booking_status === 'CONFIRMED'
            && in_array($this->payment_status, ['UNPAID', 'FAILED'], true);
    }

    public static function supportsCustomerNotifications(): bool
    {
        if (static::$supportsCustomerNotifications !== null) {
            return static::$supportsCustomerNotifications;
        }

        static::$supportsCustomerNotifications = Schema::hasTable('bookings')
            && Schema::hasColumns('bookings', ['customer_notice', 'customer_notice_read_at']);

        return static::$supportsCustomerNotifications;
    }

    public static function supportsExtendedWorkflowFields(): bool
    {
        if (static::$supportsExtendedWorkflowFields !== null) {
            return static::$supportsExtendedWorkflowFields;
        }

        static::$supportsExtendedWorkflowFields = Schema::hasTable('bookings')
            && Schema::hasColumns('bookings', ['admin_note', 'payment_ready_at']);

        return static::$supportsExtendedWorkflowFields;
    }
}
