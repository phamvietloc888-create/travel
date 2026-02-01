@php($title = 'Tours')
@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Danh sách tour</p>
            <h1 class="text-2xl font-semibold">Tours</h1>
        </div>
        <a href="{{ route('admin.tours.create') }}" class="btn-primary">Thêm tour</a>
    </div>

    <x-admin.card>
        <form method="GET" class="grid gap-3 md:grid-cols-4">
            <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Tìm kiếm tour..." class="input">
            <select name="destination_id" class="input">
                <option value="">Điểm đến</option>
                @foreach($destinations as $destination)
                    <option value="{{ $destination->id }}" @selected(($filters['destination_id'] ?? '') == $destination->id)>{{ $destination->name }}</option>
                @endforeach
            </select>
            <select name="status" class="input">
                <option value="">Trạng thái</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst(strtolower($status)) }}</option>
                @endforeach
            </select>
            <div class="flex gap-2">
                <button class="btn-secondary" type="submit">Lọc</button>
                <a href="{{ route('admin.tours.index') }}" class="btn-ghost">Reset</a>
            </div>
        </form>
    </x-admin.card>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm dark:border-slate-800">
        <table class="w-full min-w-[900px] table-auto">
            <thead class="table-head">
                <tr>
                    <th class="px-4 py-3">Tour</th>
                    <th class="px-4 py-3">Điểm đến</th>
                    <th class="px-4 py-3">Giá NL/TE</th>
                    <th class="px-4 py-3">Ngày</th>
                    <th class="px-4 py-3">Chỗ còn</th>
                    <th class="px-4 py-3">Trạng thái</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tours as $tour)
                    <tr class="table-row">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="h-12 w-16 overflow-hidden rounded-lg bg-slate-100 dark:bg-slate-800">
                                    @if($tour->thumbnail_path)
                                        <img src="{{ Storage::url($tour->thumbnail_path) }}" class="h-full w-full object-cover" alt="{{ $tour->name }}">
                                    @else
                                        <div class="grid h-full w-full place-items-center text-xs text-slate-500">No img</div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold">{{ $tour->name }}</p>
                                    <p class="text-xs text-slate-500">/{{ $tour->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $tour->destination?->name }}</td>
                        <td class="px-4 py-3 text-sm">{{ number_format($tour->price_adult) }} / {{ number_format($tour->price_child) }}</td>
                        <td class="px-4 py-3 text-sm">{{ $tour->duration_days }} ngày</td>
                        <td class="px-4 py-3 text-sm">{{ $tour->available_seats }}</td>
                        <td class="px-4 py-3">
                            <x-admin.badge :type="$tour->status === 'PUBLISHED' ? 'success' : 'neutral'">
                                {{ ucfirst(strtolower($tour->status)) }}
                            </x-admin.badge>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.tours.edit', $tour) }}" class="btn-ghost">✏️</a>
                                <form method="POST" action="{{ route('admin.tours.destroy', $tour) }}" onsubmit="return confirm('Xóa tour này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-ghost text-red-500" type="submit">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">Chưa có tour.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $tours->links() }}</div>
@endsection
