<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Tour extends Model
{
    use HasFactory;

    public const STATUSES = ['DRAFT', 'PUBLISHED', 'HIDDEN'];

    protected $fillable = [
        'destination_id',
        'name',
        'slug',
        'price_adult',
        'price_child',
        'duration_days',
        'start_location',
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
        'max_people' => 'integer',
        'available_seats' => 'integer',
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
}
