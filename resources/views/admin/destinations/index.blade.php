@php($title = 'Destinations')
@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Quản lý danh sách điểm đến</p>
            <h1 class="text-2xl font-semibold">Destinations</h1>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.destinations.create') }}" class="btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
                </svg>
                Thêm mới
            </a>
        </div>
    </div>

    <x-admin.card>
        <form method="GET" class="grid gap-3 md:grid-cols-3">
            <div>
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Tìm kiếm tên, tỉnh..."
                       class="input">
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
                <a href="{{ route('admin.destinations.index') }}" class="btn-ghost">Reset</a>
            </div>
        </form>
    </x-admin.card>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm dark:border-slate-800">
        <table class="w-full min-w-[720px] table-auto">
            <thead class="table-head">
                <tr>
                    <th class="px-4 py-3">Tên</th>
                    <th class="px-4 py-3">Tỉnh</th>
                    <th class="px-4 py-3">Tours</th>
                    <th class="px-4 py-3">Trạng thái</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($destinations as $destination)
                    <tr class="table-row">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="h-12 w-16 overflow-hidden rounded-lg bg-slate-100 dark:bg-slate-800">
                                    @if($destination->thumbnail_path)
                                        <img src="{{ Storage::url($destination->thumbnail_path) }}" class="h-full w-full object-cover" alt="{{ $destination->name }}">
                                    @else
                                        <div class="grid h-full w-full place-items-center text-xs text-slate-500">No img</div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold">{{ $destination->name }}</p>
                                    <p class="text-xs text-slate-500">/{{ $destination->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">{{ $destination->province ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm">{{ $destination->tours_count }}</td>
                        <td class="px-4 py-3">
                            <x-admin.badge :type="$destination->status === 'published' ? 'success' : 'neutral'">
                                {{ ucfirst($destination->status) }}
                            </x-admin.badge>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.destinations.edit', $destination) }}" class="btn-ghost" title="Edit">
                                    ✏️
                                </a>
                                <form method="POST" action="{{ route('admin.destinations.destroy', $destination) }}" onsubmit="return confirm('Xóa điểm đến này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-ghost text-red-500" type="submit">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-sm text-slate-500">Chưa có điểm đến nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $destinations->links() }}
    </div>
@endsection
