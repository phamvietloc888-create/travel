@php
    $title = 'Cấu hình thanh toán';
@endphp
@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Quản trị thanh toán</p>
            <h1 class="text-2xl font-semibold tracking-tight">Thông tin chuyển khoản</h1>
        </div>
    </div>

    @if (isset($settingsTableReady) && ! $settingsTableReady)
        <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
            Bảng <code>payment_settings</code> chưa tồn tại trong cơ sở dữ liệu. Cần chạy migration trước khi lưu cấu hình thanh toán.
        </div>
    @endif

    @error('payment_settings')
        <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ $message }}
        </div>
    @enderror

    <form method="POST" action="{{ route('admin.media.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <x-admin.card title="Thông tin tài khoản nhận tiền">
            <div class="grid gap-4 md:grid-cols-2">
                <x-admin.input label="Tên ngân hàng" name="bank_name" value="{{ old('bank_name', $settings->bank_name) }}" required />
                <x-admin.input label="Tên chủ tài khoản" name="account_name" value="{{ old('account_name', $settings->account_name) }}" required />
                <x-admin.input label="Số tài khoản" name="account_number" value="{{ old('account_number', $settings->account_number) }}" required />
                <div class="space-y-1">
                    <label class="label">Kích hoạt thanh toán</label>
                    <label class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2.5 dark:border-slate-700 dark:bg-slate-900">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $settings->is_active))>
                        <span class="text-sm">Cho phép khách thanh toán chuyển khoản</span>
                    </label>
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Hướng dẫn và mã QR">
            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-1 md:col-span-2">
                    <label class="label">Hướng dẫn hiển thị cho khách</label>
                    <textarea name="instructions" rows="4" class="input">{{ old('instructions', $settings->instructions) }}</textarea>
                    @error('instructions')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="label">Ảnh QR chuyển khoản</label>
                    <input type="file" name="qr_code" class="input" accept="image/*">
                    @error('qr_code')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="label">QR hiện tại</label>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-800/50">
                        @if($settings->qr_code_path)
                            <img src="{{ route('payment.qr') }}" alt="QR thanh toán" class="h-44 w-auto rounded-xl object-contain">
                        @else
                            <p class="text-sm text-slate-500">Chưa có ảnh QR.</p>
                        @endif
                    </div>
                </div>
            </div>
        </x-admin.card>

        <div class="flex flex-wrap gap-3">
            <button class="btn-primary" type="submit">Lưu cấu hình thanh toán</button>
        </div>
    </form>
@endsection
