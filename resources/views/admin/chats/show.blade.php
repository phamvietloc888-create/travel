@php
    $title = 'Chi tiet hoi thoai';
@endphp
@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Ho tro khach hang</p>
            <h1 class="text-2xl font-semibold tracking-tight">Hoi thoai #{{ $thread->id }}</h1>
            <p class="text-xs text-slate-500">{{ $thread->user?->name ?? 'Khach hang' }} · {{ $thread->user?->email ?? 'Chua co email' }}</p>
        </div>
        <div class="flex items-center gap-3">
            @if($thread->requiresAdminAttention())
                <span class="inline-flex rounded-full bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-600">Dang co tin moi tu khach</span>
            @endif
            <a href="{{ route('admin.chats.index') }}" class="btn-secondary">Quay lai</a>
        </div>
    </div>

    <x-admin.card class="space-y-4" title="Noi dung trao doi">
        <div id="adminChatMessages" class="space-y-3">
            @forelse($thread->messages->sortBy('created_at') as $message)
                @php($isAdmin = strtoupper((string) $message->sender_type) === 'ADMIN')
                <div class="flex {{ $isAdmin ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[90%] rounded-2xl border px-4 py-3 text-sm shadow-sm {{ $isAdmin ? 'border-sky-200 bg-sky-50 text-slate-800 dark:border-sky-700 dark:bg-sky-900/30 dark:text-slate-100' : 'border-slate-200 bg-white text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200' }}">
                        <div class="mb-1 flex items-center justify-between gap-3 text-xs text-slate-500">
                            <span class="font-semibold">{{ strtoupper((string) $message->sender_type) === 'ADMIN' ? 'ADMIN' : 'USER' }} {{ $message->sender?->name }}</span>
                            <span>{{ $message->created_at?->format('d/m/Y H:i') }}</span>
                        </div>
                        <p class="whitespace-pre-line">{{ $message->message }}</p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-500">Chua co tin nhan nao trong hoi thoai nay.</p>
            @endforelse
        </div>
    </x-admin.card>

    <x-admin.card title="Phan hoi khach hang">
        <form method="POST" action="{{ route('admin.chats.reply', $thread) }}" class="space-y-3">
            @csrf
            <textarea id="adminReplyMessage" name="message" class="input" rows="4" placeholder="Nhap noi dung phan hoi..."></textarea>
            @error('message')
                <p class="text-xs text-red-500">{{ $message }}</p>
            @enderror
            <div class="flex items-center justify-between gap-3">
                <p class="text-xs text-slate-500">Trang se tu dong cap nhat tin nhan moi sau moi 12 giay.</p>
                <button class="btn-primary" type="submit">Gui phan hoi</button>
            </div>
        </form>
    </x-admin.card>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const messagesWrap = document.getElementById('adminChatMessages');
            const replyInput = document.getElementById('adminReplyMessage');
            let lastMessageId = {{ (int) ($thread->messages->sortBy('created_at')->last()?->id ?? 0) }};

            const renderMessages = (messages) => {
                if (!messagesWrap) {
                    return;
                }

                if (!messages.length) {
                    messagesWrap.innerHTML = '<p class="text-sm text-slate-500">Chua co tin nhan nao trong hoi thoai nay.</p>';
                    return;
                }

                messagesWrap.innerHTML = messages.map((message) => {
                    const isAdmin = message.sender_type === 'ADMIN';

                    return `
                        <div class="flex ${isAdmin ? 'justify-end' : 'justify-start'}">
                            <div class="max-w-[90%] rounded-2xl border px-4 py-3 text-sm shadow-sm ${isAdmin ? 'border-sky-200 bg-sky-50 text-slate-800 dark:border-sky-700 dark:bg-sky-900/30 dark:text-slate-100' : 'border-slate-200 bg-white text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200'}">
                                <div class="mb-1 flex items-center justify-between gap-3 text-xs text-slate-500">
                                    <span class="font-semibold">${message.sender_name || message.sender_type}</span>
                                    <span>${message.created_at || ''}</span>
                                </div>
                                <p class="whitespace-pre-line">${String(message.message || '').replace(/</g, '&lt;').replace(/>/g, '&gt;')}</p>
                            </div>
                        </div>
                    `;
                }).join('');
            };

            const pollFeed = async () => {
                if (replyInput && document.activeElement === replyInput && replyInput.value.trim() !== '') {
                    return;
                }

                try {
                    const response = await fetch(@json(route('admin.chats.feed', $thread)), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                    });

                    if (!response.ok) {
                        return;
                    }

                    const payload = await response.json();

                    if ((payload.last_message_id || 0) !== lastMessageId) {
                        lastMessageId = payload.last_message_id || 0;
                        renderMessages(payload.messages || []);
                    }
                } catch (error) {
                    console.warn('Admin chat polling failed', error);
                }
            };

            window.setInterval(pollFeed, 12000);
        });
    </script>
@endsection
