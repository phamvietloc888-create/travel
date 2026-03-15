<?php

namespace App\Models;

use App\Support\ImagePathResolver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'image_path',
        'sort_order',
    ];

    protected $appends = [
        'image_url',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function getImageUrlAttribute(): string
    {
        return ImagePathResolver::tourUrl($this->image_path);
    }
}
