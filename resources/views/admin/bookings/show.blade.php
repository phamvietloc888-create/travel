@php($title = 'Chi tiết booking')
@extends('admin.layouts.app')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500">Chi tiết booking</p>
            <h1 class="text-2xl font-semibold">#{{ $booking->booking_code }} - {{ $booking->customer_name }}</h1>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="btn-secondary">Quay lại</a>
    </div>

    <x-admin.card>
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <p class="label">Khách</p>
                <p class="text-lg font-semibold">{{ $booking->customer_name }}</p>
                <p class="text-sm text-slate-500">{{ $booking->customer_email }} · {{ $booking->customer_phone }}</p>
            </div>
            <div>
                <p class="label">Tour</p>
                <p class="font-semibold">{{ $booking->tour?->name }}</p>
                <p class="text-sm text-slate-500">{{ $booking->tour?->destination?->name }}</p>
            </div>
            <div>
                <p class="label">Ngày đi</p>
                <p>{{ $booking->travel_date?->format('d/m/Y') }}</p>
            </div>
            <div>
                <p class="label">Số lượng</p>
                <p>Người lớn: {{ $booking->adult_qty }} | Trẻ em: {{ $booking->child_qty }}</p>
            </div>
            <div>
                <p class="label">Tổng tiền</p>
                <p class="font-semibold">{{ number_format($booking->total_amount, 0, ',', '.') }} đ (Giảm: {{ number_format($booking->discount_amount,0,',','.') }} đ)</p>
            </div>
            <div>
                <p class="label">Trạng thái</p>
                <p>Booking: {{ $booking->booking_status }} · Payment: {{ $booking->payment_status }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="label">Ghi chú</p>
                <p class="text-sm text-slate-500">{{ $booking->note ?? '—' }}</p>
            </div>
        </div>
    </x-admin.card>
@endsection
