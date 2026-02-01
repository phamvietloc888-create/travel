@php($title = 'Bookings')
@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Quản lý đơn đặt</p>
            <h1 class="text-2xl font-semibold">Bookings</h1>
        </div>
    </div>

    <x-admin.card>
        <form method="GET" class="grid gap-3 md:grid-cols-4">
            <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Tên, email, phone, mã đặt" class="input">
            <select name="status" class="input">
                <option value="">Trạng thái booking</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst(strtolower($status)) }}</option>
                @endforeach
            </select>
            <select name="payment_status" class="input">
                <option value="">Trạng thái thanh toán</option>
                @foreach($paymentStatuses as $status)
                    <option value="{{ $status }}" @selected(($filters['payment_status'] ?? '') === $status)>{{ ucfirst(strtolower($status)) }}</option>
                @endforeach
            </select>
            <div class="flex gap-2">
                <button class="btn-secondary" type="submit">Lọc</button>
                <a href="{{ route('admin.bookings.index') }}" class="btn-ghost">Reset</a>
            </div>
        </form>
    </x-admin.card>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm dark:border-slate-800">
        <table class="w-full min-w-[1000px] table-auto">
            <thead class="table-head">
                <tr>
                    <th class="px-4 py-3">Mã</th>
                    <th class="px-4 py-3">Khách</th>
                    <th class="px-4 py-3">Tour</th>
                    <th class="px-4 py-3">Ngày đi</th>
                    <th class="px-4 py-3">SL</th>
                    <th class="px-4 py-3">Thành tiền</th>
                    <th class="px-4 py-3">Booking</th>
                    <th class="px-4 py-3">Thanh toán</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr class="table-row">
                        <td class="px-4 py-3 text-sm font-semibold">{{ $booking->booking_code }}</td>
                        <td class="px-4 py-3">
                            <div class="font-semibold">{{ $booking->customer_name }}</div>
                            <p class="text-xs text-slate-500">{{ $booking->customer_email }}</p>
                            <p class="text-xs text-slate-500">{{ $booking->customer_phone }}</p>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <p class="font-semibold">{{ $booking->tour?->name }}</p>
                            <p class="text-xs text-slate-500">{{ $booking->tour?->destination?->name }}</p>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $booking->travel_date?->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-sm">A: {{ $booking->adult_qty }} | C: {{ $booking->child_qty }}</td>
                        <td class="px-4 py-3 text-sm font-semibold">{{ number_format($booking->total_amount, 0, ',', '.') }} đ</td>
                        <td class="px-4 py-3">
                            <x-admin.badge :type="$booking->booking_status === 'CONFIRMED' ? 'success' : ($booking->booking_status === 'CANCELED' ? 'warning' : 'neutral')">
                                {{ ucfirst(strtolower($booking->booking_status)) }}
                            </x-admin.badge>
                        </td>
                        <td class="px-4 py-3">
                            <x-admin.badge :type="$booking->payment_status === 'PAID' ? 'success' : 'neutral'">
                                {{ ucfirst(strtolower($booking->payment_status)) }}
                            </x-admin.badge>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn-ghost">👁️</a>
                                <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn-ghost">✏️</a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="px-4 py-8 text-center text-sm text-slate-500">Chưa có booking.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $bookings->links() }}</div>
@endsection
