@php($title = 'Chat thread')
@extends('admin.layouts.app')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500">Trao d?i</p>
            <h1 class="text-2xl font-semibold">Thread #{{ $thread->id }}</h1>
            <p class="text-xs text-slate-500">{{ $thread->user?->name }} · {{ $thread->user?->email }}</p>
        </div>
        <a href="{{ route('admin.chats.index') }}" class="btn-secondary">Quay l?i</a>
    </div>

    <x-admin.card class="mt-4 space-y-3">
        @forelse($thread->messages as $message)
            <div class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between text-xs text-slate-500">
                    <span>{{ $message->sender_type }} {{ $message->sender?->name }}</span>
                    <span>{{ $message->created_at }}</span>
                </div>
                <p class="mt-1">{{ $message->message }}</p>
            </div>
        @empty
            <p class="text-sm text-slate-500">Chua có tin nh?n.</p>
        @endforelse
    </x-admin.card>

    <x-admin.card>
        <form method="POST" action="{{ route('admin.chats.reply', $thread) }}" class="space-y-3">
            @csrf
            <textarea name="message" class="input" rows="3" placeholder="G?i ph?n h?i..."></textarea>
            <button class="btn-primary" type="submit">G?i</button>
        </form>
    </x-admin.card>
@endsection
