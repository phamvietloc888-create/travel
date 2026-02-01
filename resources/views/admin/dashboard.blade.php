@php($title = 'Dashboard')
@extends('admin.layouts.app')

@section('content')
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <x-admin.card>
            <div class="space-y-2">
                <p class="text-xs uppercase text-slate-500">Destinations</p>
                <p class="text-3xl font-bold">{{ number_format($stats['destinations']) }}</p>
                <p class="text-xs text-emerald-500">Mở rộng map du lịch</p>
            </div>
        </x-admin.card>
        <x-admin.card>
            <div class="space-y-2">
                <p class="text-xs uppercase text-slate-500">Tours</p>
                <p class="text-3xl font-bold">{{ number_format($stats['tours']) }}</p>
                <p class="text-xs text-sky-500">Sẵn sàng bán</p>
            </div>
        </x-admin.card>
        <x-admin.card>
            <div class="space-y-2">
                <p class="text-xs uppercase text-slate-500">Bookings</p>
                <p class="text-3xl font-bold">{{ number_format($stats['bookings']) }}</p>
                <p class="text-xs text-amber-500">Cần xác nhận</p>
            </div>
        </x-admin.card>
        <x-admin.card>
            <div class="space-y-2">
                <p class="text-xs uppercase text-slate-500">Reviews</p>
                <p class="text-3xl font-bold">{{ number_format($stats['reviews']) }}</p>
                <p class="text-xs text-slate-500">Module coming soon</p>
            </div>
        </x-admin.card>
    </div>

    <div class="grid gap-4 lg:grid-cols-3">
        <x-admin.card class="lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm font-semibold">Booking trend</p>
                <span class="badge badge-neutral">12 months</span>
            </div>
            <canvas id="bookingChart" class="h-72 w-full"></canvas>
        </x-admin.card>

        <x-admin.card>
            <div class="flex items-center justify-between mb-4">
                <p class="text-sm font-semibold">Top tours</p>
                <a href="{{ route('admin.tours.index') }}" class="text-xs text-sky-500">Xem tất cả</a>
            </div>
            <div class="space-y-4">
                @forelse($topTours as $tour)
                    <div class="flex items-center gap-3">
                        <div class="h-12 w-12 overflow-hidden rounded-xl bg-slate-100 dark:bg-slate-800">
                            @if($tour->thumbnail_path)
                                <img src="{{ Storage::url($tour->thumbnail_path) }}" alt="{{ $tour->name }}" class="h-full w-full object-cover">
                            @else
                                <div class="grid h-full w-full place-items-center text-xs text-slate-500">No img</div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-semibold">{{ $tour->name }}</p>
                            <p class="text-xs text-slate-500">{{ $tour->bookings_count }} bookings</p>
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
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-semibold">Bookings gần đây</p>
                <a href="{{ route('admin.bookings.index') }}" class="text-xs text-sky-500">Xem</a>
            </div>
            <div class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($recentBookings as $booking)
                    <div class="flex items-center justify-between py-3">
                        <div>
                            <p class="text-sm font-semibold">{{ $booking->customer_name }}</p>
                            <p class="text-xs text-slate-500">{{ $booking->tour?->name }} · {{ $booking->travel_date->format('d/m/Y') }}</p>
                        </div>
                        <x-admin.badge :type="$booking->status === 'confirmed' ? 'success' : ($booking->status === 'canceled' ? 'warning' : 'neutral')">
                            {{ ucfirst($booking->status) }}
                        </x-admin.badge>
                    </div>
                @empty
                    <p class="py-4 text-sm text-slate-500">Chưa có booking nào.</p>
                @endforelse
            </div>
        </x-admin.card>
        <x-admin.card>
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-semibold">Tips</p>
                <span class="badge badge-neutral">UX</span>
            </div>
            <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-300">
                <li>• Giữ mô tả tour gọn gàng, ảnh sắc nét.</li>
                <li>• Ưu tiên các tỉnh có nhu cầu theo mùa.</li>
                <li>• Phản hồi booking pending trong 2h.</li>
            </ul>
        </x-admin.card>
    </div>
@endsection

@push('scripts')
    <script type="module">
        const ctx = document.getElementById('bookingChart');
        if (window.Chart && ctx) {
            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chart['labels']),
                    datasets: [{
                        label: 'Bookings',
                        data: @json($chart['values']),
                        borderColor: '#38bdf8',
                        backgroundColor: 'rgba(56, 189, 248, 0.15)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                    }]
                },
                options: {
                    plugins: {
                        legend: { display: false },
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(148,163,184,0.2)' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }
    </script>
@endpush
