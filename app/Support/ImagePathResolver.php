<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImagePathResolver
{
    private const DEFAULT_FALLBACK = 'clients/images/destination-1.jpg';

    private const DESTINATION_DIRECTORIES = [
        'clients/images/dulich/destinations',
        'clients/imgae/dulich/destinations',
        'clients/imgae/destinations',
        'clients/images/destinations',
    ];

    private const TOUR_DIRECTORIES = [
        'clients/images/dulich/Tour',
        'clients/images/dulich/tour',
        'clients/imgae/dulich/Tour',
        'clients/imgae/dulich/tour',
        'clients/imgae/tour',
        'clients/images/tour',
    ];

    public static function resolve(?string $path, ?string $fallback = null): string
    {
        $fallbackUrl = asset($fallback ?: self::DEFAULT_FALLBACK);

        if (empty($path)) {
            return $fallbackUrl;
        }

        $path = trim($path);

        if ($path === '') {
            return $fallbackUrl;
        }

        if (preg_match('/^(https?:)?\/\//i', $path) || str_starts_with($path, 'data:')) {
            return $path;
        }

        $normalized = ltrim(str_replace('\\', '/', $path), '/');

        foreach (self::candidatePublicPaths($normalized) as $candidate) {
            if (is_file(public_path($candidate))) {
                return asset($candidate);
            }
        }

        $storagePath = preg_replace('#^storage/#', '', $normalized);
        if (!empty($storagePath) && Storage::disk('public')->exists($storagePath)) {
            return Storage::disk('public')->url($storagePath);
        }

        $baseName = basename($normalized);
        foreach (array_merge(self::DESTINATION_DIRECTORIES, self::TOUR_DIRECTORIES) as $directory) {
            $candidate = $directory.'/'.$baseName;
            if (is_file(public_path($candidate))) {
                return asset($candidate);
            }
        }

        return $fallbackUrl;
    }

    public static function destinationUrl(?string $path, ?string $slug = null, ?string $name = null, ?string $fallback = null): string
    {
        if (!empty($path)) {
            $resolved = self::resolve($path, null);
            if ($resolved !== asset(self::DEFAULT_FALLBACK)) {
                return $resolved;
            }
        }

        $matched = self::findByName(self::DESTINATION_DIRECTORIES, $slug, $name);
        if ($matched) {
            return $matched;
        }

        return asset($fallback ?: self::DEFAULT_FALLBACK);
    }

    public static function tourUrl(?string $path, ?string $slug = null, ?string $name = null, ?string $fallback = null): string
    {
        if (!empty($path)) {
            $resolved = self::resolve($path, null);
            if ($resolved !== asset(self::DEFAULT_FALLBACK)) {
                return $resolved;
            }
        }

        $matched = self::findByName(self::TOUR_DIRECTORIES, $slug, $name);
        if ($matched) {
            return $matched;
        }

        return asset($fallback ?: self::DEFAULT_FALLBACK);
    }

    private static function findByName(array $directories, ?string ...$keys): ?string
    {
        $targets = collect($keys)
            ->filter()
            ->map(fn (string $value) => self::normalizeKey($value))
            ->filter()
            ->unique()
            ->values();

        if ($targets->isEmpty()) {
            return null;
        }

        foreach ($directories as $directory) {
            $pattern = public_path($directory).'/*.{jpg,jpeg,png,webp,gif,avif,JPG,JPEG,PNG,WEBP,GIF,AVIF}';
            $files = glob($pattern, GLOB_BRACE) ?: [];

            foreach ($files as $file) {
                $basename = pathinfo($file, PATHINFO_FILENAME);
                $normalizedBasename = self::normalizeKey($basename);

                if ($normalizedBasename === '') {
                    continue;
                }

                foreach ($targets as $target) {
                    if (
                        $normalizedBasename === $target
                        || str_contains($normalizedBasename, $target)
                        || str_contains($target, $normalizedBasename)
                    ) {
                        return asset($directory.'/'.basename($file));
                    }
                }
            }
        }

        return null;
    }

    private static function candidatePublicPaths(string $normalized): array
    {
        $baseName = basename($normalized);

        return array_values(array_unique(array_filter([
            $normalized,
            'storage/'.$normalized,
            'clients/images/'.$normalized,
            'clients/imgae/'.$normalized,
            'clients/images/dulich/'.$normalized,
            'clients/imgae/dulich/'.$normalized,
            'clients/images/dulich/destinations/'.$normalized,
            'clients/images/dulich/Tour/'.$normalized,
            'clients/imgae/dulich/destinations/'.$normalized,
            'clients/imgae/dulich/Tour/'.$normalized,
            'clients/images/dulich/destinations/'.$baseName,
            'clients/images/dulich/Tour/'.$baseName,
            'clients/imgae/dulich/destinations/'.$baseName,
            'clients/imgae/dulich/Tour/'.$baseName,
        ])));
    }

    private static function normalizeKey(?string $value): string
    {
        $ascii = Str::of((string) $value)->ascii()->lower()->value();

        return (string) preg_replace('/[^a-z0-9]+/', '', $ascii);
    }
}
