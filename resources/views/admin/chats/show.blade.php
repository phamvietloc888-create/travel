@php
    $title = 'Chi tiết hội thoại';
@endphp
@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-sm text-slate-500">Hỗ trợ khách hàng</p>
            <h1 class="text-2xl font-semibold tracking-tight">Hội thoại #{{ $thread->id }}</h1>
            <p class="text-xs text-slate-500">{{ $thread->user?->name }} · {{ $thread->user?->email }}</p>
        </div>
        <a href="{{ route('admin.chats.index') }}" class="btn-secondary">Quay lại</a>
    </div>

    <x-admin.card class="space-y-4" title="Nội dung trao đổi">
        @forelse($thread->messages as $message)
            @php($isAdmin = strtoupper((string) $message->sender_type) === 'ADMIN')
            <div class="flex {{ $isAdmin ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[90%] rounded-2xl border px-4 py-3 text-sm shadow-sm {{ $isAdmin ? 'border-sky-200 bg-sky-50 text-slate-800 dark:border-sky-700 dark:bg-sky-900/30 dark:text-slate-100' : 'border-slate-200 bg-white text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200' }}">
                    <div class="mb-1 flex items-center justify-between gap-3 text-xs text-slate-500">
                        <span class="font-semibold">{{ $message->sender_type }} {{ $message->sender?->name }}</span>
                        <span>{{ $message->created_at?->format('d/m/Y H:i') }}</span>
                    </div>
                    <p class="whitespace-pre-line">{{ $message->message }}</p>
                </div>
            </div>
        @empty
            <p class="text-sm text-slate-500">Chưa có tin nhắn nào trong hội thoại này.</p>
        @endforelse
    </x-admin.card>

    <x-admin.card title="Phản hồi khách hàng">
        <form method="POST" action="{{ route('admin.chats.reply', $thread) }}" class="space-y-3">
            @csrf
            <textarea name="message" class="input" rows="4" placeholder="Nhập nội dung phản hồi..."></textarea>
            @error('message')
                <p class="text-xs text-red-500">{{ $message }}</p>
            @enderror
            <div class="flex justify-end">
                <button class="btn-primary" type="submit">Gửi phản hồi</button>
            </div>
        </form>
    </x-admin.card>
@endsection

