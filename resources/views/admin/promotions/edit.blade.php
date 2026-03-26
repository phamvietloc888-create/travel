@php
    $title = 'Sửa khuyến mãi';
@endphp
@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Cập nhật khuyến mãi</p>
            <h1 class="text-2xl font-semibold tracking-tight">{{ $promotion->code }}</h1>
        </div>
        <a href="{{ route('admin.promotions.index') }}" class="btn-secondary">Quay lại</a>
    </div>

    <form method="POST" action="{{ route('admin.promotions.update', $promotion) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <x-admin.card title="Thông tin mã khuyến mãi">
            <div class="grid gap-4 md:grid-cols-2">
                <x-admin.input label="Mã code" name="code" value="{{ old('code', $promotion->code) }}" required />
                <x-admin.input label="Tiêu đề" name="title" value="{{ old('title', $promotion->title) }}" required />

                <div class="space-y-1">
                    <label class="label">Loại giảm giá</label>
                    <select name="type" class="input">
                        @foreach($types as $type)
                            <option value="{{ $type }}" @selected(old('type', $promotion->type) === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <x-admin.input label="Giá trị" name="value" type="number" step="0.01" value="{{ old('value', $promotion->value) }}" required />
                <x-admin.input label="Đơn tối thiểu" name="min_total" type="number" step="0.01" value="{{ old('min_total', $promotion->min_total) }}" />
                <x-admin.input label="Giảm tối đa" name="max_discount" type="number" step="0.01" value="{{ old('max_discount', $promotion->max_discount) }}" />
                <x-admin.input label="Giới hạn lượt dùng" name="total_limit" type="number" value="{{ old('total_limit', $promotion->total_limit) }}" />

                <div class="space-y-1">
                    <label class="label">Trạng thái</label>
                    <select name="status" class="input">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" @selected(old('status', $promotion->status) === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Thời gian áp dụng">
            <div class="grid gap-4 md:grid-cols-2">
                <x-admin.input label="Bắt đầu" name="start_at" type="datetime-local" value="{{ old('start_at', optional($promotion->start_at)->format('Y-m-d\TH:i')) }}" />
                <x-admin.input label="Kết thúc" name="end_at" type="datetime-local" value="{{ old('end_at', optional($promotion->end_at)->format('Y-m-d\TH:i')) }}" />
            </div>
        </x-admin.card>

        <div class="flex flex-wrap gap-3">
            <button type="submit" class="btn-primary">Cập nhật khuyến mãi</button>
            <a href="{{ route('admin.promotions.index') }}" class="btn-secondary">Há»§y</a>
        </div>
    </form>
@endsection

