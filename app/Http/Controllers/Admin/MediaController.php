<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function __construct(protected MediaService $mediaService)
    {
    }

    public function index(): View
    {
        $media = Media::latest()->paginate(20);

        return view('admin.media.index', ['media' => $media]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'image', 'max:4096'],
        ]);

        $this->mediaService->upload($request->file('file'), 'media', $request->user()?->id);

        return redirect()->route('admin.media.index')->with('toast', 'Upload thanh cong.');
    }

    public function destroy(Media $media): RedirectResponse
    {
        $this->mediaService->delete($media);
        return redirect()->route('admin.media.index')->with('toast', 'Da xoa file.');
    }

    public function setAuthBackground(Media $media): RedirectResponse
    {
        Media::query()->update(['is_auth_background' => false]);
        $media->update(['is_auth_background' => true]);

        return redirect()->route('admin.media.index')->with('toast', 'Da chon lam anh nen dang nhap/dang ky.');
    }
}
