<?php

namespace App\Models;

use App\Support\ImagePathResolver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Destination extends Model
{
    use HasFactory;

    public const STATUSES = ['DRAFT', 'PUBLISHED', 'HIDDEN'];

    protected $fillable = [
        'name',
        'slug',
        'description',
        'province',
        'region',
        'status',
        'thumbnail_path',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    protected $appends = [
        'thumbnail_url',
    ];

    protected static function booted(): void
    {
        static::saving(function (Destination $destination) {
            if (empty($destination->slug) && $destination->name) {
                $destination->slug = Str::slug($destination->name);
            }
        });
    }

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function getThumbnailUrlAttribute(): string
    {
        return ImagePathResolver::destinationUrl(
            $this->thumbnail_path,
            $this->slug,
            $this->name
        );
    }
}
