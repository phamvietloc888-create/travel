@php($title = 'Promotions')
@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Mã khuyến mãi</p>
            <h1 class="text-2xl font-semibold">Promotions</h1>
        </div>
        <a href="{{ route('admin.promotions.create') }}" class="btn-primary">Thêm promotion</a>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm dark:border-slate-800 mt-4">
        <table class="w-full min-w-[800px] table-auto">
            <thead class="table-head">
                <tr>
                    <th class="px-4 py-3">Code</th>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Value</th>
                    <th class="px-4 py-3">Trạng thái</th>
                    <th class="px-4 py-3">Thời gian</th>
                    <th class="px-4 py-3 text-right">Actions</th>
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
                                <form method="POST" action="{{ route('admin.promotions.destroy', $promotion) }}" onsubmit="return confirm('Xóa promotion?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-ghost text-red-500" type="submit">Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-8 text-center text-sm text-slate-500">Chưa có promotion.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $promotions->links() }}</div>
@endsection
