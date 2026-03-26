@php
    $title = 'Quản lý booking';
@endphp
@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Theo dõi và xử lý đơn đặt tour</p>
            <h1 class="text-2xl font-semibold tracking-tight">Bookings</h1>
        </div>
    </div>

    <x-admin.card class="overflow-hidden">
        <div class="mb-4 grid gap-3 md:grid-cols-4">
            <div class="rounded-3xl border border-emerald-100 bg-emerald-50/70 p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600">Tổng booking</p>
                <p class="mt-2 text-3xl font-black text-emerald-800">{{ number_format($bookings->total()) }}</p>
            </div>
            <div class="rounded-3xl border border-amber-100 bg-amber-50/70 p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-amber-600">Chờ duyệt</p>
                <p class="mt-2 text-3xl font-black text-amber-800">{{ number_format($bookings->where('booking_status', 'PENDING')->count()) }}</p>
            </div>
            <div class="rounded-3xl border border-sky-100 bg-sky-50/70 p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-sky-600">Chờ thanh toán</p>
                <p class="mt-2 text-3xl font-black text-sky-800">{{ number_format($bookings->where('booking_status', 'CONFIRMED')->where('payment_status', 'UNPAID')->count()) }}</p>
            </div>
            <div class="rounded-3xl border border-violet-100 bg-violet-50/70 p-5">
                <p class="text-xs font-semibold uppercase tracking-wide text-violet-600">Đã gửi thanh toán</p>
                <p class="mt-2 text-3xl font-black text-violet-800">{{ number_format($bookings->where('payment_status', 'PENDING')->count()) }}</p>
            </div>
        </div>

        <form method="GET" class="grid gap-3 xl:grid-cols-[minmax(0,2fr)_minmax(220px,1fr)_minmax(220px,1fr)_auto]">
            <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Tên khách, email, số điện thoại, mã booking..." class="input">
            <select name="status" class="input">
                <option value="">Tất cả trạng thái booking</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ $status }}</option>
                @endforeach
            </select>
            <select name="payment_status" class="input">
                <option value="">Tất cả trạng thái thanh toán</option>
                @foreach($paymentStatuses as $status)
                    <option value="{{ $status }}" @selected(($filters['payment_status'] ?? '') === $status)>{{ $status }}</option>
                @endforeach
            </select>
            <div class="flex gap-2">
                <button class="btn-secondary" type="submit">Lọc</button>
                <a href="{{ route('admin.bookings.index') }}" class="btn-ghost">Đặt lại</a>
            </div>
        </form>
    </x-admin.card>

    <div class="grid gap-4">
        @forelse($bookings as $booking)
            @php
                $badgeType = match($booking->booking_status) {
                    'CONFIRMED', 'COMPLETED' => 'success',
                    'CANCELED' => 'warning',
                    default => 'neutral',
                };
                $paymentBadgeType = match($booking->payment_status) {
                    'PAID' => 'success',
                    'PENDING', 'FAILED' => 'warning',
                    default => 'neutral',
                };
                $bookingLabel = match($booking->booking_status) {
                    'PENDING' => 'Chờ duyệt',
                    'CONFIRMED' => 'Đã xác nhận',
                    'CANCELED' => 'Đã hủy',
                    'COMPLETED' => 'Hoàn tất',
                    default => $booking->booking_status,
                };
                $paymentLabel = match($booking->payment_status) {
                    'UNPAID' => 'Chưa thanh toán',
                    'PENDING' => 'Đã gửi thanh toán',
                    'PAID' => 'Đã thanh toán',
                    'FAILED' => 'Thanh toán lỗi',
                    'REFUNDED' => 'Đã hoàn tiền',
                    default => $booking->payment_status,
                };
                $isOpen = $booking->booking_status === 'PENDING' || ($booking->booking_status === 'CONFIRMED' && in_array($booking->payment_status, ['UNPAID', 'PENDING'], true));
            @endphp

            <x-admin.card class="overflow-hidden booking-accordion-card" data-booking-card>
                <details class="group" @if($isOpen) open @endif>
                    <summary class="flex cursor-pointer list-none flex-wrap items-start justify-between gap-4 rounded-3xl border border-slate-100 bg-white p-5 marker:hidden">
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ $booking->booking_code }}</span>
                                <x-admin.badge :type="$badgeType">{{ $bookingLabel }}</x-admin.badge>
                                <x-admin.badge :type="$paymentBadgeType">{{ $paymentLabel }}</x-admin.badge>
                            </div>
                            <div class="mt-3 grid gap-3 lg:grid-cols-4">
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-400">Khách hàng</p>
                                    <p class="mt-2 text-lg font-bold text-slate-900">{{ $booking->customer_name }}</p>
                                    <p class="text-sm text-slate-500 break-all">{{ $booking->customer_email }}</p>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-400">Tour</p>
                                    <p class="mt-2 text-lg font-bold text-slate-900 break-words">{{ $booking->tour?->name }}</p>
                                    <p class="text-sm text-slate-500">{{ $booking->tour?->destination?->name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-400">Ngày đi</p>
                                    <p class="mt-2 text-lg font-bold text-slate-900">{{ $booking->travel_date?->format('d/m/Y') ?? '-' }}</p>
                                    <p class="text-sm text-slate-500">Người lớn: {{ $booking->adult_qty }} | Trẻ em: {{ $booking->child_qty }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-400">Tổng tiền</p>
                                    <p class="mt-2 text-2xl font-black text-slate-900">{{ number_format($booking->total_amount, 0, ',', '.') }} đ</p>
                                    <p class="text-sm text-slate-500">{{ $booking->payment_ready_at?->format('d/m/Y H:i') ?? 'Chưa mở thanh toán' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 group-open:hidden">Bấm để mở</span>
                            <span class="hidden rounded-full bg-slate-900 px-3 py-1 text-xs font-semibold text-white group-open:inline-flex">Đang mở</span>
                        </div>
                    </summary>

                    <div class="mt-4 rounded-3xl border border-slate-100 bg-slate-50/70 p-5">
                        <div class="grid gap-4 xl:grid-cols-[minmax(0,1.1fr)_minmax(0,.9fr)]">
                            <div class="grid gap-4 md:grid-cols-2">
                                <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-100">
                                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-400">Thông tin khách</p>
                                    <p class="mt-2 font-semibold text-slate-900">{{ $booking->customer_name }}</p>
                                    <p class="text-sm text-slate-500">{{ $booking->customer_phone }}</p>
                                    <p class="text-sm text-slate-500 break-all">{{ $booking->customer_email }}</p>
                                </div>

                                <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-100">
                                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-400">Ghi chú khách</p>
                                    <p class="mt-2 text-sm leading-7 text-slate-600">{{ $booking->note ?: 'Khách chưa để lại ghi chú.' }}</p>
                                </div>

                                <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-100 md:col-span-2">
                                    <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-400">Thông báo gửi khách</p>
                                    <p class="mt-2 text-sm leading-7 text-slate-600">{{ $booking->customer_notice ?: 'Chưa có thông báo gửi khách.' }}</p>
                                </div>
                            </div>

                            <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-100">
                                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-400">Thao tác nhanh</p>
                                <div class="mt-4 flex flex-wrap gap-2">
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

                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="btn-ghost">Chi tiết</a>
                                    <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn-ghost">Chỉnh sửa</a>
                                    <button type="button" class="btn-ghost" data-hide-booking>Ẩn block</button>
                                </div>
                                <p class="mt-4 text-sm text-slate-500">Booking đã xử lý xong có thể bấm Ẩn block để thu gọn khỏi màn hình hiện tại.</p>
                            </div>
                        </div>
                    </div>
                </details>
            </x-admin.card>
        @empty
            <x-admin.card>
                <div class="py-10 text-center text-sm text-slate-500">Chưa có booking nào.</div>
            </x-admin.card>
        @endforelse
    </div>

    <div class="mt-4">{{ $bookings->links() }}</div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-hide-booking]').forEach(function (button) {
                button.addEventListener('click', function () {
                    const card = this.closest('[data-booking-card]');
                    if (card) {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection
