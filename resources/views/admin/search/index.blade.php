@php
    $title = 'Tìm kiếm nhanh';
@endphp
@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Tìm kiếm toàn khu admin</p>
            <h1 class="text-2xl font-semibold tracking-tight">Kết quả tìm kiếm</h1>
        </div>
        @if($query !== '')
            <span class="rounded-full border border-sky-200 bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-700">
                {{ $resultCount }} kết quả cho "{{ $queryPreview }}"
            </span>
        @endif
    </div>

    <x-admin.card>
        <form method="GET" action="{{ route('admin.search') }}" class="flex flex-col gap-3 md:flex-row">
            <input
                type="search"
                name="q"
                value="{{ $query }}"
                placeholder="Nhập tên tour, mã booking, email khách, điểm đến..."
                class="input flex-1"
                autofocus
            >
            <div class="flex gap-2">
                <button type="submit" class="btn-secondary">Tìm kiếm</button>
                <a href="{{ route('admin.search') }}" class="btn-ghost">Đặt lại</a>
            </div>
        </form>
    </x-admin.card>

    @if($query === '')
        <x-admin.card>
            <p class="text-sm text-slate-500">Nhập từ khóa vào ô phía trên rồi nhấn Enter để tìm nhanh tour, booking hoặc điểm đến.</p>
        </x-admin.card>
    @elseif($resultCount === 0)
        <x-admin.card>
            <p class="text-sm font-semibold text-slate-900">Không tìm thấy dữ liệu phù hợp.</p>
            <p class="mt-2 text-sm text-slate-500">Thử lại với tên tour, mã booking, email khách hàng hoặc tên điểm đến.</p>
        </x-admin.card>
    @else
        <div class="grid gap-4 xl:grid-cols-3">
            <x-admin.card>
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Tours</p>
                        <p class="text-xs text-slate-500">{{ $tours->count() }} kết quả</p>
                    </div>
                    <a href="{{ route('admin.tours.index', ['search' => $query]) }}" class="text-xs font-semibold text-sky-600">Mở danh sách</a>
                </div>

                <div class="space-y-3">
                    @forelse($tours as $tour)
                        <a href="{{ route('admin.tours.edit', $tour) }}" class="block rounded-2xl border border-slate-200 p-3 transition hover:border-sky-200 hover:bg-sky-50/60">
                            <p class="text-sm font-semibold text-slate-900">{{ $tour->name }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $tour->destination?->name ?: 'Chưa có điểm đến' }} - /{{ $tour->slug }}</p>
                        </a>
                    @empty
                        <p class="text-sm text-slate-500">Không có tour phù hợp.</p>
                    @endforelse
                </div>
            </x-admin.card>

            <x-admin.card>
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Bookings</p>
                        <p class="text-xs text-slate-500">{{ $bookings->count() }} kết quả</p>
                    </div>
                    <a href="{{ route('admin.bookings.index', ['search' => $query]) }}" class="text-xs font-semibold text-sky-600">Mở danh sách</a>
                </div>

                <div class="space-y-3">
                    @forelse($bookings as $booking)
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="block rounded-2xl border border-slate-200 p-3 transition hover:border-sky-200 hover:bg-sky-50/60">
                            <p class="text-sm font-semibold text-slate-900">{{ $booking->booking_code }} - {{ $booking->customer_name }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $booking->customer_email }} - {{ $booking->tour?->name ?: 'Chưa gắn tour' }}</p>
                        </a>
                    @empty
                        <p class="text-sm text-slate-500">Không có booking phù hợp.</p>
                    @endforelse
                </div>
            </x-admin.card>

            <x-admin.card>
                <div class="mb-4 flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-900">Điểm đến</p>
                        <p class="text-xs text-slate-500">{{ $destinations->count() }} kết quả</p>
                    </div>
                    <a href="{{ route('admin.destinations.index', ['search' => $query]) }}" class="text-xs font-semibold text-sky-600">Mở danh sách</a>
                </div>

                <div class="space-y-3">
                    @forelse($destinations as $destination)
                        <a href="{{ route('admin.destinations.edit', $destination) }}" class="block rounded-2xl border border-slate-200 p-3 transition hover:border-sky-200 hover:bg-sky-50/60">
                            <p class="text-sm font-semibold text-slate-900">{{ $destination->name }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $destination->province ?: 'Chưa có tỉnh thành' }} - /{{ $destination->slug }}</p>
                        </a>
                    @empty
                        <p class="text-sm text-slate-500">Không có điểm đến phù hợp.</p>
                    @endforelse
                </div>
            </x-admin.card>
        </div>
    @endif
@endsection
