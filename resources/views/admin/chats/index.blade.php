@php
    $title = 'Tin nhắn';
@endphp
@extends('admin.layouts.app')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500">Hộp thoại khách hàng</p>
            <h1 class="text-2xl font-semibold tracking-tight">Danh sách hội thoại</h1>
        </div>
    </div>

    <div class="admin-table-wrap mt-4">
        <table class="w-full min-w-[800px] table-auto">
            <thead class="table-head">
                <tr>
                    <th class="px-4 py-3">Khách hàng</th>
                    <th class="px-4 py-3">Trạng thái</th>
                    <th class="px-4 py-3">Tin nhắn cuối</th>
                    <th class="px-4 py-3 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($threads as $thread)
                    <tr class="table-row">
                        <td class="px-4 py-3 text-sm">
                            <div class="font-semibold">{{ $thread->user?->name }}</div>
                            <div class="text-xs text-slate-500">{{ $thread->user?->email }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm">{{ $thread->status }}</td>
                        <td class="px-4 py-3 text-sm">{{ $thread->last_message_at }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.chats.show', $thread) }}" class="btn-ghost">Xem chi tiết</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-sm text-slate-500">Chưa có chủ đề nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $threads->links() }}</div>
@endsection

