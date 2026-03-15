@php
    $title = 'Chỉnh sửa booking';
@endphp
@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Cập nhật trạng thái booking và thanh toán</p>
            <h1 class="text-2xl font-semibold tracking-tight">#{{ $booking->booking_code }} - {{ $booking->customer_name }}</h1>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="btn-secondary">Quay lại</a>
    </div>

    <form method="POST" action="{{ route('admin.bookings.update', $booking) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <x-admin.card title="Thông tin booking">
            <div class="grid gap-4 md:grid-cols-2">
                <div class="space-y-1">
                    <label class="label">Tour</label>
                    <select name="tour_id" class="input" required>
                        @foreach($tours as $tour)
                            <option value="{{ $tour->id }}" @selected(old('tour_id', $booking->tour_id) == $tour->id)>{{ $tour->name }}</option>
                        @endforeach
                    </select>
                </div>

                <x-admin.input label="Tên khách" name="customer_name" value="{{ old('customer_name', $booking->customer_name) }}" required />
                <x-admin.input label="Điện thoại" name="customer_phone" value="{{ old('customer_phone', $booking->customer_phone) }}" required />
                <x-admin.input label="Email" name="customer_email" value="{{ old('customer_email', $booking->customer_email) }}" required />
                <x-admin.input label="Người lớn" name="adult_qty" type="number" value="{{ old('adult_qty', $booking->adult_qty) }}" required />
                <x-admin.input label="Trẻ em" name="child_qty" type="number" value="{{ old('child_qty', $booking->child_qty) }}" required />
                <x-admin.input label="Ngày đi" name="travel_date" type="date" value="{{ old('travel_date', $booking->travel_date?->format('Y-m-d')) }}" required />

                <div class="space-y-1">
                    <label class="label">Trạng thái booking</label>
                    <select name="booking_status" class="input">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" @selected(old('booking_status', $booking->booking_status) === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="label">Trạng thái thanh toán</label>
                    <select name="payment_status" class="input">
                        @foreach($paymentStatuses as $status)
                            <option value="{{ $status }}" @selected(old('payment_status', $booking->payment_status) === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </x-admin.card>

        <x-admin.card title="Ghi chú & thông báo">
            <div class="grid gap-4 md:grid-cols-2">
                <x-admin.input label="Tổng tiền" name="total_amount" type="number" step="1000" value="{{ old('total_amount', $booking->total_amount) }}" />
                <x-admin.input label="Giảm giá" name="discount_amount" type="number" step="1000" value="{{ old('discount_amount', $booking->discount_amount) }}" />

                <div class="space-y-1 md:col-span-2">
                    <label class="label">Ghi chú của khách</label>
                    <textarea name="note" rows="4" class="input">{{ old('note', $booking->note) }}</textarea>
                </div>

                <div class="space-y-1 md:col-span-2">
                    <label class="label">Tin nhắn từ admin hiển thị cho khách</label>
                    <textarea name="admin_note" rows="4" class="input">{{ old('admin_note', $booking->admin_note) }}</textarea>
                    <p class="text-xs text-slate-500">Khi bạn chuyển booking sang `CONFIRMED` hoặc `PAID`, hệ thống sẽ tự tạo thông báo cho khách và mở bước thanh toán khi cần.</p>
                </div>
            </div>
        </x-admin.card>

        <div class="flex flex-wrap gap-3">
            <button type="submit" class="btn-primary">Cập nhật booking</button>
            <a href="{{ route('admin.bookings.index') }}" class="btn-secondary">Hủy</a>
        </div>
    </form>
@endsection
