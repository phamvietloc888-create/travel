@php($title = 'Chats')
@extends('admin.layouts.app')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500">Threads</p>
            <h1 class="text-2xl font-semibold">Chat threads</h1>
        </div>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm dark:border-slate-800 mt-4">
        <table class="w-full min-w-[800px] table-auto">
            <thead class="table-head">
                <tr>
                    <th class="px-4 py-3">User</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Last message</th>
                    <th class="px-4 py-3 text-right">Actions</th>
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
                            <a href="{{ route('admin.chats.show', $thread) }}" class="btn-ghost">Xem</a>
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
