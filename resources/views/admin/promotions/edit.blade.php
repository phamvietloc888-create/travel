@php($title = 'S?a promotion')
@extends('admin.layouts.app')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500">Chỉnh sửa khuyến mãi</p>
            <h1 class="text-2xl font-semibold">{{ $promotion->code }}</h1>
        </div>
        <a href="{{ route('admin.promotions.index') }}" class="btn-secondary">Quay lại</a>
    </div>

    <form method="POST" action="{{ route('admin.promotions.update', $promotion) }}" class="space-y-6">
        @csrf
        @method('PUT')
        <x-admin.card>
            <div class="grid gap-4 md:grid-cols-2">
                <x-admin.input label="Code" name="code" value="{{ old('code', $promotion->code) }}" required />
                <x-admin.input label="Title" name="title" value="{{ old('title', $promotion->title) }}" required />
                <div class="space-y-1">
                    <label class="label">Type</label>
                    <select name="type" class="input">
                        @foreach($types as $type)
                            <option value="{{ $type }}" @selected(old('type', $promotion->type) === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <x-admin.input label="Value" name="value" type="number" step="0.01" value="{{ old('value', $promotion->value) }}" required />
                <x-admin.input label="Min total" name="min_total" type="number" step="0.01" value="{{ old('min_total', $promotion->min_total) }}" />
                <x-admin.input label="Max discount" name="max_discount" type="number" step="0.01" value="{{ old('max_discount', $promotion->max_discount) }}" />
                <x-admin.input label="Total limit" name="total_limit" type="number" value="{{ old('total_limit', $promotion->total_limit) }}" />
                <div class="space-y-1">
                    <label class="label">Trạng thái</label>
                    <select name="status" class="input">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" @selected(old('status', $promotion->status) === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <x-admin.input label="Start at" name="start_at" type="datetime-local" value="{{ old('start_at', optional($promotion->start_at)->format('Y-m-d\TH:i')) }}" />
                <x-admin.input label="End at" name="end_at" type="datetime-local" value="{{ old('end_at', optional($promotion->end_at)->format('Y-m-d\TH:i')) }}" />
            </div>
        </x-admin.card>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Lưu</button>
            <a href="{{ route('admin.promotions.index') }}" class="btn-secondary">Hủy</a>
        </div>
    </form>
@endsection
