@php
    $title = 'Lịch sử';
@endphp
@extends('admin.layouts.app')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500">Nhật ký hoạt động</p>
            <h1 class="text-2xl font-semibold tracking-tight">Lịch sử hệ thống</h1>
        </div>
    </div>

    <x-admin.card class="mt-4">
        <form method="GET" class="grid gap-3 md:grid-cols-3">
            <input type="text" name="action" class="input" placeholder="Tìm theo action" value="{{ $filters['action'] ?? '' }}" />
            <div class="flex gap-2">
                <button class="btn-secondary" type="submit">Lọc</button>
                <a href="{{ route('admin.histories.index') }}" class="btn-ghost">Đặt lại</a>
            </div>
        </form>
    </x-admin.card>

    <div class="admin-table-wrap mt-4">
        <table class="w-full min-w-[900px] table-auto">
            <thead class="table-head">
                <tr>
                    <th class="px-4 py-3">Tác nhân</th>
                    <th class="px-4 py-3">Hành động</th>
                    <th class="px-4 py-3">Tham chiếu</th>
                    <th class="px-4 py-3">Thời gian</th>
                </tr>
            </thead>
            <tbody>
                @forelse($histories as $history)
                    <tr class="table-row">
                        <td class="px-4 py-3 text-sm">{{ $history->actor_type }} {{ $history->actor?->name }}</td>
                        <td class="px-4 py-3 text-sm">{{ $history->action }}</td>
                        <td class="px-4 py-3 text-sm">{{ $history->ref_table }} #{{ $history->ref_id }}</td>
                        <td class="px-4 py-3 text-sm">{{ $history->created_at }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-sm text-slate-500">Chưa có lịch sử.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $histories->links() }}</div>
@endsection

