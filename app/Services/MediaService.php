<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    public function upload(?UploadedFile $file, string $directory = 'media', ?int $userId = null): ?Media
    {
        if (!$file) {
            return null;
        }

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, 'public');

        return Media::create([
            'user_id' => $userId,
            'original_name' => $file->getClientOriginalName(),
            'path' => $path,
            'size' => $file->getSize(),
            'mime_type' => $file->getClientMimeType(),
        ]);
    }

    public function delete(Media $media): void
    {
        Storage::disk('public')->delete($media->path);
        $media->delete();
    }
}
