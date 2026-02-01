@php($title = 'Thêm điểm đến')
@extends('admin.layouts.app')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500">Thêm điểm đến mới</p>
            <h1 class="text-2xl font-semibold">Create destination</h1>
        </div>
        <a href="{{ route('admin.destinations.index') }}" class="btn-secondary">Quay lại</a>
    </div>

    <form method="POST" action="{{ route('admin.destinations.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <x-admin.card>
            <div class="grid gap-4 md:grid-cols-2">
                <x-admin.input label="Tên" name="name" value="{{ old('name') }}" required />
                <x-admin.input label="Slug" name="slug" value="{{ old('slug') }}" hint="Tự sinh từ tên nếu bỏ trống" />
                <x-admin.input label="Tỉnh/Thành" name="province" value="{{ old('province') }}" />
                <div class="space-y-1">
                    <label class="label">Trạng thái</label>
                    <select name="status" class="input">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" @selected(old('status') === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-1">
                    <label class="label">Thumbnail</label>
                    <input type="file" name="thumbnail" class="input" />
                    @error('thumbnail')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="space-y-1">
                <label class="label">Mô tả</label>
                <textarea name="description" rows="4" class="input">{{ old('description') }}</textarea>
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
