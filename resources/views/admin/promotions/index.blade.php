@php
    $title = 'Khuyến mãi';
@endphp
@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Mã khuyến mãi</p>
            <h1 class="text-2xl font-semibold tracking-tight">Danh sách khuyến mãi</h1>
        </div>
        <a href="{{ route('admin.promotions.create') }}" class="btn-primary">Thêm khuyến mãi</a>
    </div>

    <div class="admin-table-wrap mt-4">
        <table class="w-full min-w-[860px] table-auto">
            <thead class="table-head">
                <tr>
                    <th class="px-4 py-3">Mã</th>
                    <th class="px-4 py-3">Tiêu đề</th>
                    <th class="px-4 py-3">Loại</th>
                    <th class="px-4 py-3">Giá trị</th>
                    <th class="px-4 py-3">Trạng thái</th>
                    <th class="px-4 py-3">Thời gian</th>
                    <th class="px-4 py-3 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($promotions as $promotion)
                    <tr class="table-row">
                        <td class="px-4 py-3 font-semibold">{{ $promotion->code }}</td>
                        <td class="px-4 py-3 text-sm">{{ $promotion->title }}</td>
                        <td class="px-4 py-3 text-sm">{{ $promotion->type }}</td>
                        <td class="px-4 py-3 text-sm">{{ $promotion->value }}</td>
                        <td class="px-4 py-3">
                            <x-admin.badge :type="$promotion->status === 'ACTIVE' ? 'success' : 'warning'">{{ $promotion->status }}</x-admin.badge>
                        </td>
                        <td class="px-4 py-3 text-xs text-slate-500">
                            {{ optional($promotion->start_at)->format('d/m/Y') }} - {{ optional($promotion->end_at)->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.promotions.edit', $promotion) }}" class="btn-ghost">Sửa</a>
                                <form method="POST" action="{{ route('admin.promotions.destroy', $promotion) }}" onsubmit="return confirm('Xóa khuyến mãi này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-ghost text-rose-600" type="submit">Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">Chưa có khuyến mãi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $promotions->links() }}</div>
@endsection
