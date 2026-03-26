@php
    $title = 'Destinations';
@endphp
@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Quản lý danh sách điểm đến</p>
            <h1 class="text-2xl font-semibold tracking-tight">Destinations</h1>
        </div>
        <a href="{{ route('admin.destinations.create') }}" class="btn-primary">Thêm mới</a>
    </div>

    <x-admin.card>
        <form method="GET" class="grid gap-3 md:grid-cols-3">
            <div>
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Tìm kiếm tên, tỉnh..." class="input">
            </div>
            <div>
                <select name="status" class="input">
                    <option value="">Trạng thái</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button class="btn-secondary" type="submit">Lọc</button>
                <a href="{{ route('admin.destinations.index') }}" class="btn-ghost">Đặt lại</a>
            </div>
        </form>
    </x-admin.card>

    <div class="admin-table-wrap">
        <table class="w-full min-w-[820px] table-auto">
            <thead class="table-head">
                <tr>
                    <th class="px-4 py-3">Tên</th>
                    <th class="px-4 py-3">Tỉnh</th>
                    <th class="px-4 py-3">Vùng miền</th>
                    <th class="px-4 py-3">Tours</th>
                    <th class="px-4 py-3">Trạng thái</th>
                    <th class="px-4 py-3 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($destinations as $destination)
                    <tr class="table-row">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="h-12 w-16 overflow-hidden rounded-xl bg-slate-100 dark:bg-slate-800">
                                    <img src="{{ $destination->thumbnail_url }}" class="h-full w-full object-cover" alt="{{ $destination->name }}">
                                </div>
                                <div>
                                    <p class="font-semibold">{{ $destination->name }}</p>
                                    <p class="text-xs text-slate-500">/{{ $destination->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">{{ $destination->province ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">{{ $destination->region ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm">{{ $destination->tours_count }}</td>
                        <td class="px-4 py-3">
                            <x-admin.badge :type="$destination->status === 'PUBLISHED' ? 'success' : 'neutral'">
                                {{ ucfirst($destination->status) }}
                            </x-admin.badge>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.destinations.edit', $destination) }}" class="btn-ghost" title="Sửa">Sửa</a>
                                <form method="POST" action="{{ route('admin.destinations.destroy', $destination) }}" onsubmit="return confirm('Xóa điểm đến này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-ghost text-rose-600" type="submit">Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">Chưa có điểm đến nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $destinations->links() }}
    </div>
@endsection
