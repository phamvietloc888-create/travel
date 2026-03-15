@php
    $title = 'Đánh giá';
@endphp
@extends('admin.layouts.app')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500">Quản lý đánh giá</p>
            <h1 class="text-2xl font-semibold tracking-tight">Danh sách đánh giá</h1>
        </div>
    </div>

    <x-admin.card class="mt-4">
        <form method="GET" class="grid gap-3 md:grid-cols-3">
            <select name="status" class="input">
                <option value="">Trạng thái</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected(($filters['status'] ?? '') === $status)>{{ $status }}</option>
                @endforeach
            </select>
            <div class="flex gap-2">
                <button class="btn-secondary" type="submit">Lọc</button>
                <a href="{{ route('admin.reviews.index') }}" class="btn-ghost">Đặt lại</a>
            </div>
        </form>
    </x-admin.card>

    <div class="admin-table-wrap mt-4">
        <table class="w-full min-w-[900px] table-auto">
            <thead class="table-head">
                <tr>
                    <th class="px-4 py-3">Người dùng</th>
                    <th class="px-4 py-3">Tour</th>
                    <th class="px-4 py-3">Điểm</th>
                    <th class="px-4 py-3">Ná»™i dung</th>
                    <th class="px-4 py-3">Trạng thái</th>
                    <th class="px-4 py-3 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                    <tr class="table-row">
                        <td class="px-4 py-3 text-sm">
                            <div class="font-semibold">{{ $review->user?->name }}</div>
                            <div class="text-xs text-slate-500">{{ $review->user?->email }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $review->tour?->name }}</td>
                        <td class="px-4 py-3 text-sm">{{ $review->rating }}/5</td>
                        <td class="px-4 py-3 text-sm">{{ Illuminate\Support\Str::limit($review->comment, 120) }}</td>
                        <td class="px-4 py-3">
                            <x-admin.badge :type="$review->status === 'APPROVED' ? 'success' : 'neutral'">{{ $review->status }}</x-admin.badge>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <form method="POST" action="{{ route('admin.reviews.status', $review) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="input" onchange="this.form.submit()">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status }}" @selected($review->status === $status)>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </form>
                                <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" onsubmit="return confirm('Xóa đánh giá này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-ghost text-red-500" type="submit">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-sm text-slate-500">Chưa có đánh giá.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $reviews->links() }}</div>
@endsection

