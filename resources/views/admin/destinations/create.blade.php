@php
    $title = 'Tạo điểm đến';
@endphp
@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Quản lý điểm đến</p>
            <h1 class="text-2xl font-semibold tracking-tight">Tạo điểm đến mới</h1>
        </div>
        <a href="{{ route('admin.destinations.index') }}" class="btn-secondary">Quay lại</a>
    </div>

    <form method="POST" action="{{ route('admin.destinations.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <x-admin.card title="Thông tin cơ bản">
            <div class="grid gap-4 md:grid-cols-2">
                <x-admin.input label="Tên điểm đến" name="name" value="{{ old('name') }}" required />
                <x-admin.input label="Slug" name="slug" value="{{ old('slug') }}" hint="Bỏ trống để hệ thống tự sinh" />
                <x-admin.input label="Tỉnh/Thành phố" name="province" value="{{ old('province') }}" />

                <div class="space-y-1">
                    <label class="label">Vùng miền</label>
                    <select name="region" class="input">
                        <option value="">Chọn vùng miền</option>
                        @foreach(['Miền Bắc', 'Miền Trung', 'Miền Nam'] as $region)
                            <option value="{{ $region }}" @selected(old('region') === $region)>{{ $region }}</option>
                        @endforeach
                    </select>
                    @error('region')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

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
                    <label class="label">Ảnh thumbnail</label>
                    <input type="file" name="thumbnail" class="input" />
                    @error('thumbnail')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Mô tả">
            <div class="space-y-1">
                <label class="label">Nội dung mô tả</label>
                <textarea name="description" rows="5" class="input">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </x-admin.card>

        <div class="flex flex-wrap gap-3">
            <button type="submit" class="btn-primary">Lưu điểm đến</button>
            <a href="{{ route('admin.destinations.index') }}" class="btn-secondary">Há»§y</a>
        </div>
    </form>
@endsection

