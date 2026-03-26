@php
    $title = 'Chi tiết booking';
@endphp
@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Theo dõi đơn đặt tour</p>
            <h1 class="text-2xl font-semibold tracking-tight">#{{ $booking->booking_code }} - {{ $booking->customer_name }}</h1>
        </div>
        <div class="flex flex-wrap gap-2">
            @if($booking->booking_status === 'PENDING')
                <form method="POST" action="{{ route('admin.bookings.status', $booking) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="booking_status" value="CONFIRMED">
                    <input type="hidden" name="payment_status" value="{{ $booking->payment_status }}">
                    <button type="submit" class="btn-primary">Xác nhận tour</button>
                </form>
            @endif
            @if($booking->booking_status === 'CONFIRMED' && in_array($booking->payment_status, ['PENDING', 'UNPAID'], true))
                <form method="POST" action="{{ route('admin.bookings.status', $booking) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="booking_status" value="{{ $booking->booking_status }}">
                    <input type="hidden" name="payment_status" value="PAID">
                    <button type="submit" class="btn-secondary">Xác nhận thanh toán</button>
                </form>
            @endif
            <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn-primary">Chỉnh sửa</a>
            <a href="{{ route('admin.bookings.index') }}" class="btn-secondary">Quay lại</a>
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
        <x-admin.card class="lg:col-span-2" title="Thông tin khách hàng">
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <p class="label">Khách hàng</p>
                    <p class="mt-1 text-lg font-semibold">{{ $booking->customer_name }}</p>
                    <p class="text-sm text-slate-500">{{ $booking->customer_email }}</p>
                    <p class="text-sm text-slate-500">{{ $booking->customer_phone }}</p>
                </div>
                <div>
                    <p class="label">Tour đã chọn</p>
                    <p class="mt-1 font-semibold">{{ $booking->tour?->name }}</p>
                    <p class="text-sm text-slate-500">{{ $booking->tour?->destination?->name }}</p>
                </div>
                <div>
                    <p class="label">Ngày đi</p>
                    <p class="mt-1">{{ $booking->travel_date?->format('d/m/Y') ?? 'Chưa cập nhật' }}</p>
                </div>
                <div>
                    <p class="label">Số lượng khách</p>
                    <p class="mt-1">Người lớn: {{ $booking->adult_qty }} | Trẻ em: {{ $booking->child_qty }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="label">Ghi chú của khách</p>
                    <p class="mt-1 text-sm text-slate-500">{{ $booking->note ?: 'Không có ghi chú.' }}</p>
                </div>
                <div class="md:col-span-2">
                    <p class="label">Thông báo gửi cho khách</p>
                    <p class="mt-1 text-sm text-slate-500">{{ $booking->customer_notice ?: 'Chưa gửi thông báo.' }}</p>
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Trạng thái & thanh toán">
            <div class="space-y-4">
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-500">Trạng thái booking</p>
                    <div class="mt-2">
                        <x-admin.badge :type="$booking->booking_status === 'CONFIRMED' ? 'success' : ($booking->booking_status === 'CANCELED' ? 'warning' : 'neutral')">{{ $booking->booking_status }}</x-admin.badge>
                    </div>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-500">Trạng thái thanh toán</p>
                    <div class="mt-2">
                        <x-admin.badge :type="$booking->payment_status === 'PAID' ? 'success' : ($booking->payment_status === 'PENDING' ? 'warning' : 'neutral')">{{ $booking->payment_status }}</x-admin.badge>
                    </div>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-500">Tổng tiền</p>
                    <p class="mt-2 text-2xl font-black tracking-tight text-slate-900">{{ number_format($booking->total_amount, 0, ',', '.') }} đ</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-500">Mở thanh toán</p>
                    <p class="mt-2 text-sm text-slate-700">{{ $booking->payment_ready_at?->format('d/m/Y H:i') ?? 'Chưa mở thanh toán' }}</p>
                </div>
                @if($booking->admin_note)
                    <div class="rounded-2xl border border-sky-200 bg-sky-50/70 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.08em] text-sky-600">Ghi chú từ admin</p>
                        <p class="mt-2 text-sm text-slate-700">{{ $booking->admin_note }}</p>
                    </div>
                @endif
            </div>
        </x-admin.card>
    </div>
@endsection
