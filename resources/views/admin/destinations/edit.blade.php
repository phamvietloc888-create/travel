@php($title = 'Sửa điểm đến')
@extends('admin.layouts.app')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500">Chỉnh sửa thông tin</p>
            <h1 class="text-2xl font-semibold">{{ $destination->name }}</h1>
        </div>
        <a href="{{ route('admin.destinations.index') }}" class="btn-secondary">Quay lại</a>
    </div>

    <form method="POST" action="{{ route('admin.destinations.update', $destination) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <x-admin.card>
            <div class="grid gap-4 md:grid-cols-2">
                <x-admin.input label="Tên" name="name" value="{{ old('name', $destination->name) }}" required />
                <x-admin.input label="Slug" name="slug" value="{{ old('slug', $destination->slug) }}" />
                <x-admin.input label="Tỉnh/Thành" name="province" value="{{ old('province', $destination->province) }}" />
                <div class="space-y-1">
                    <label class="label">Trạng thái</label>
                    <select name="status" class="input">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" @selected(old('status', $destination->status) === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label class="label">Thumbnail</label>
                    <input type="file" name="thumbnail" class="input" />
                    @if($destination->thumbnail_path)
                        <img src="{{ Storage::url($destination->thumbnail_path) }}" class="mt-2 h-24 rounded-lg object-cover" alt="">
                    @endif
                    @error('thumbnail')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="space-y-1">
                <label class="label">Mô tả</label>
                <textarea name="description" rows="4" class="input">{{ old('description', $destination->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </x-admin.card>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Lưu</button>
            <a href="{{ route('admin.destinations.index') }}" class="btn-secondary">Hủy</a>
        </div>
    </form>
@endsection
