@php
    $title = 'Tin nhan';
@endphp
@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Hop thoai khach hang</p>
            <h1 class="text-2xl font-semibold tracking-tight">Danh sach hoi thoai</h1>
        </div>
        @if($attentionCount > 0)
            <div class="inline-flex items-center rounded-full bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-600">
                {{ $attentionCount }} hoi thoai dang cho admin phan hoi
            </div>
        @endif
    </div>

    @unless($chatReady)
        <div class="mt-4 rounded-3xl border border-amber-200 bg-amber-50 px-4 py-4 text-sm text-amber-700">
            Bang chat chua san sang tren server. Can tao bang <code>chat_threads</code> va <code>chat_messages</code> truoc khi su dung tinh nang nhan tin.
        </div>
    @endunless

    <div class="admin-table-wrap mt-4">
        <table class="w-full min-w-[860px] table-auto">
            <thead class="table-head">
                <tr>
                    <th class="px-4 py-3">Khach hang</th>
                    <th class="px-4 py-3">Trang thai</th>
                    <th class="px-4 py-3">Tin nhan cuoi</th>
                    <th class="px-4 py-3 text-right">Thao tac</th>
                </tr>
            </thead>
            <tbody>
                @forelse($threads as $thread)
                    @php($needsAttention = $thread->requiresAdminAttention())
                    <tr class="table-row">
                        <td class="px-4 py-3 text-sm">
                            <div class="font-semibold">{{ $thread->user?->name ?? 'Khach hang' }}</div>
                            <div class="text-xs text-slate-500">{{ $thread->user?->email ?? 'Chua co email' }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div class="font-medium">{{ $thread->status }}</div>
                            @if($needsAttention)
                                <div class="mt-1 inline-flex rounded-full bg-rose-50 px-2 py-1 text-xs font-semibold text-rose-600">
                                    Tin moi tu khach
                                </div>
                            @else
                                <div class="mt-1 inline-flex rounded-full bg-emerald-50 px-2 py-1 text-xs font-semibold text-emerald-600">
                                    Da doc
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <div>{{ $thread->last_message_at?->format('d/m/Y H:i') ?? '-' }}</div>
                            <div class="mt-1 text-xs text-slate-500">
                                {{ \Illuminate\Support\Str::limit($thread->latestMessage?->message ?? 'Chua co tin nhan', 90) }}
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.chats.show', $thread) }}" class="btn-ghost">Xem chi tiet</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-sm text-slate-500">
                            Chua co hoi thoai nao.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $threads->links() }}</div>
@endsection
