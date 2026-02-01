@php($title = 'Thêm promotion')
@extends('admin.layouts.app')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500">T?o m� khuy?n m�i</p>
            <h1 class="text-2xl font-semibold">Create promotion</h1>
        </div>
        <a href="{{ route('admin.promotions.index') }}" class="btn-secondary">Quay l?i</a>
    </div>

    <form method="POST" action="{{ route('admin.promotions.store') }}" class="space-y-6">
        @csrf
        <x-admin.card>
            <div class="grid gap-4 md:grid-cols-2">
                <x-admin.input label="Code" name="code" value="{{ old('code') }}" required />
                <x-admin.input label="Title" name="title" value="{{ old('title') }}" required />
                <div class="space-y-1">
                    <label class="label">Type</label>
                    <select name="type" class="input">
                        @foreach($types as $type)
                            <option value="{{ $type }}" @selected(old('type') === $type)>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <x-admin.input label="Value" name="value" type="number" step="0.01" value="{{ old('value') }}" required />
                <x-admin.input label="Min total" name="min_total" type="number" step="0.01" value="{{ old('min_total') }}" />
                <x-admin.input label="Max discount" name="max_discount" type="number" step="0.01" value="{{ old('max_discount') }}" />
                <x-admin.input label="Total limit" name="total_limit" type="number" value="{{ old('total_limit') }}" />
                <div class="space-y-1">
                    <label class="label">Tr?ng th�i</label>
                    <select name="status" class="input">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" @selected(old('status') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <x-admin.input label="Start at" name="start_at" type="datetime-local" value="{{ old('start_at') }}" />
                <x-admin.input label="End at" name="end_at" type="datetime-local" value="{{ old('end_at') }}" />
            </div>
        </x-admin.card>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Luu</button>
            <a href="{{ route('admin.promotions.index') }}" class="btn-secondary">H?y</a>
        </div>
    </form>
@endsection
