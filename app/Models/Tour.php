<?php

namespace App\Models;

use App\Support\ImagePathResolver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Tour extends Model
{
    use HasFactory;

    public const STATUSES = ['DRAFT', 'PUBLISHED', 'HIDDEN'];
    public const TRANSPORT_OPTIONS = [
        'Xe khách',
        'Limousine',
        'Máy bay',
        'Tàu hỏa',
        'Tàu thủy',
        'Ô tô riêng',
    ];

    protected $fillable = [
        'destination_id',
        'name',
        'slug',
        'price_adult',
        'price_child',
        'duration_days',
        'start_location',
        'transport_type',
        'hotel_name',
        'hotel_stars',
        'max_people',
        'available_seats',
        'status',
        'thumbnail_path',
        'short_desc',
        'content',
    ];

    protected $casts = [
        'price_adult' => 'decimal:2',
        'price_child' => 'decimal:2',
        'duration_days' => 'integer',
        'hotel_stars' => 'integer',
        'max_people' => 'integer',
        'available_seats' => 'integer',
    ];

    protected $appends = [
        'thumbnail_url',
        'booked_seats',
        'remaining_seats',
    ];

    protected static function booted(): void
    {
        static::saving(function (Tour $tour) {
            if (empty($tour->slug) && $tour->name) {
                $tour->slug = Str::slug($tour->name);
            }
        });
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function images()
    {
        return $this->hasMany(TourImage::class);
    }

    public function schedules()
    {
        return $this->hasMany(TourSchedule::class)->orderBy('day_no');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)
            ->where('status', 'APPROVED')
            ->latest();
    }

    protected function bookedSeats(): Attribute
    {
        return Attribute::get(function (): int {
            return (int) $this->bookings()
                ->where('booking_status', '!=', 'CANCELED')
                ->selectRaw('COALESCE(SUM(adult_qty + child_qty), 0) as seats')
                ->value('seats');
        });
    }

    protected function remainingSeats(): Attribute
    {
        return Attribute::get(function (): int {
            return max(0, (int) $this->available_seats - (int) $this->booked_seats);
        });
    }

    public function getThumbnailUrlAttribute(): string
    {
        return ImagePathResolver::tourUrl(
            $this->thumbnail_path,
            $this->slug,
            $this->name
        );
    }
}
