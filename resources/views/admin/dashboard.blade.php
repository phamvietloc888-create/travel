@php
    $title = 'Bảng điều khiển';
@endphp
@extends('admin.layouts.app')

@section('content')
    <x-admin.card class="overflow-hidden border-0 bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-300">Tổng quan</p>
                <h1 class="mt-1 text-3xl font-black tracking-tight">Bảng điều khiển quản trị</h1>
                <p class="mt-2 text-sm text-slate-300">Theo dõi vận hành tour, booking và doanh thu theo thời gian thực.</p>
            </div>
            <span class="rounded-full border border-white/20 bg-white/10 px-3 py-1 text-xs font-semibold">Dữ liệu trực tiếp</span>
        </div>
    </x-admin.card>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <x-admin.card>
            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-500">Điểm đến</p>
            <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ number_format($stats['destinations']) }}</p>
            <p class="mt-1 text-xs font-medium text-emerald-600">Mở rộng bản đồ sản phẩm</p>
        </x-admin.card>
        <x-admin.card>
            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-500">Tour</p>
            <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ number_format($stats['tours']) }}</p>
            <p class="mt-1 text-xs font-medium text-sky-600">Sẵn sàng mở bán</p>
        </x-admin.card>
        <x-admin.card>
            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-500">Booking</p>
            <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ number_format($stats['bookings']) }}</p>
            <p class="mt-1 text-xs font-medium text-amber-600">Cần xác nhận sớm</p>
        </x-admin.card>
        <x-admin.card>
            <p class="text-xs font-semibold uppercase tracking-[0.08em] text-slate-500">Đánh giá</p>
            <p class="mt-2 text-3xl font-black tracking-tight text-slate-900">{{ number_format($stats['reviews']) }}</p>
            <p class="mt-1 text-xs font-medium text-violet-600">Phản hồi khách hàng</p>
        </x-admin.card>
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
        <x-admin.card class="lg:col-span-2 overflow-hidden border-0 bg-gradient-to-br from-white via-slate-50 to-sky-50">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-900">Xu hướng booking</p>
                    <p class="text-xs text-slate-500">Booking và doanh thu trong 12 tháng gần nhất</p>
                </div>
                <span class="rounded-full border border-sky-200 bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">12 tháng</span>
            </div>
            <canvas id="bookingChart" class="h-72 w-full"></canvas>
        </x-admin.card>

        <x-admin.card>
            <div class="mb-4 flex items-center justify-between">
                <p class="text-sm font-semibold text-slate-900">Tour nổi bật</p>
                <a href="{{ route('admin.tours.index') }}" class="text-xs font-semibold text-sky-600">Xem tất cả</a>
            </div>
            <div class="space-y-4">
                @forelse($topTours as $tour)
                    <div class="flex items-center gap-3">
                        <div class="h-12 w-12 overflow-hidden rounded-xl bg-slate-100">
                            @if($tour->thumbnail_path)
                                <img src="{{ $tour->thumbnail_url }}" alt="{{ $tour->name }}" class="h-full w-full object-cover">
                            @else
                                <div class="grid h-full w-full place-items-center text-xs text-slate-500">Không ảnh</div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-slate-900">{{ $tour->name }}</p>
                            <p class="text-xs text-slate-500">{{ $tour->bookings_count }} booking</p>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Chưa có tour.</p>
                @endforelse
            </div>
        </x-admin.card>
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <x-admin.card>
            <div class="mb-3 flex items-center justify-between">
                <p class="text-sm font-semibold text-slate-900">Booking gần đây</p>
                <a href="{{ route('admin.bookings.index') }}" class="text-xs font-semibold text-sky-600">Xem</a>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($recentBookings as $booking)
                    <div class="flex items-center justify-between py-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">{{ $booking->customer_name }}</p>
                            <p class="text-xs text-slate-500">{{ $booking->tour?->name }} · {{ $booking->travel_date?->format('d/m/Y') }}</p>
                        </div>
                        <x-admin.badge :type="$booking->booking_status === 'CONFIRMED' ? 'success' : ($booking->booking_status === 'CANCELED' ? 'warning' : 'neutral')">
                            {{ ucfirst(strtolower($booking->booking_status)) }}
                        </x-admin.badge>
                    </div>
                @empty
                    <p class="py-4 text-sm text-slate-500">Chưa có booking nào.</p>
                @endforelse
            </div>
        </x-admin.card>

        <x-admin.card>
            <div class="mb-3 flex items-center justify-between">
                <p class="text-sm font-semibold text-slate-900">Gợi ý vận hành</p>
                <span class="rounded-full border border-slate-200 bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">UX</span>
            </div>
            <ul class="space-y-2 text-sm text-slate-600">
                <li>• Giữ mô tả tour ngắn gọn và ảnh thumbnail sắc nét.</li>
                <li>• Tăng hiển thị điểm đến có nhu cầu cao theo mùa.</li>
                <li>• Ưu tiên xử lý booking pending trong vòng 2 giờ.</li>
            </ul>
        </x-admin.card>
    </div>
@endsection

@push('scripts')
    <script type="module">
        const ctx = document.getElementById('bookingChart');
        if (window.Chart && ctx) {
            const context = ctx.getContext('2d');
            const bookingGradient = context.createLinearGradient(0, 0, 0, 280);
            bookingGradient.addColorStop(0, 'rgba(14, 165, 233, 0.35)');
            bookingGradient.addColorStop(1, 'rgba(14, 165, 233, 0.02)');

            new Chart(ctx, {
                data: {
                    labels: @json($chart['labels']),
                    datasets: [
                        {
                            type: 'line',
                            label: 'Booking',
                            data: @json($chart['values']),
                            borderColor: '#0ea5e9',
                            backgroundColor: bookingGradient,
                            fill: true,
                            tension: 0.36,
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            pointBackgroundColor: '#0ea5e9',
                            yAxisID: 'y',
                        },
                        {
                            type: 'bar',
                            label: 'Doanh thu',
                            data: @json($chart['revenues']),
                            backgroundColor: 'rgba(16, 185, 129, 0.28)',
                            borderRadius: 8,
                            yAxisID: 'y1',
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: {
                            display: true,
                            labels: {
                                boxWidth: 12,
                                color: '#334155',
                                usePointStyle: true,
                                pointStyle: 'circle',
                            }
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(148, 163, 184, 0.18)' },
                            ticks: { color: '#64748b' },
                            title: { display: true, text: 'Số booking', color: '#475569' },
                        },
                        y1: {
                            beginAtZero: true,
                            position: 'right',
                            grid: { drawOnChartArea: false },
                            ticks: {
                                color: '#64748b',
                                callback: (value) => new Intl.NumberFormat('vi-VN').format(value),
                            },
                            title: { display: true, text: 'Doanh thu (VND)', color: '#475569' },
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#64748b' }
                        }
                    }
                }
            });
        }
    </script>
@endpush
