@php($title = 'Media')
@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Quản lý media</p>
            <h1 class="text-2xl font-semibold">Media</h1>
        </div>
    </div>

    <x-admin.card>
        <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="flex flex-col gap-3 md:flex-row md:items-center">
            @csrf
            <input type="file" name="file" required class="input md:w-80" />
            <button class="btn-primary" type="submit">Upload</button>
            @error('file')<p class="text-xs text-red-500">{{ $message }}</p>@enderror
        </form>
    </x-admin.card>

    <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @forelse($media as $item)
            <div class="glass-card rounded-xl p-3 space-y-2">
                <div class="aspect-video overflow-hidden rounded-lg bg-slate-100 dark:bg-slate-800">
                    <img src="{{ Storage::url($item->path) }}" alt="{{ $item->original_name }}" class="h-full w-full object-cover">
                </div>
                <div class="text-sm font-semibold truncate">{{ $item->original_name }}</div>
                <div class="flex items-center justify-between text-xs text-slate-500">
                    <span>{{ number_format($item->size / 1024, 1) }} KB</span>
                    <div class="flex items-center gap-2">
                        @if ($item->is_auth_background)
                            <span class="text-emerald-600 font-semibold">Auth BG</span>
                        @else
                            <form method="POST" action="{{ route('admin.media.auth-bg', $item) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-indigo-600 hover:text-indigo-500">Chon lam login</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.media.destroy', $item) }}" onsubmit="return confirm('Xóa file này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-400">Xóa</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-sm text-slate-500">Chưa có media.</p>
        @endforelse
    </div>

    <div class="mt-4">{{ $media->links() }}</div>
@endsection
