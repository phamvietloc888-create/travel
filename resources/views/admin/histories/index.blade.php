@php($title = 'Histories')
@extends('admin.layouts.app')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm text-slate-500">Log hoạt động</p>
            <h1 class="text-2xl font-semibold">Histories</h1>
        </div>
    </div>

    <x-admin.card class="mt-4">
        <form method="GET" class="grid gap-3 md:grid-cols-3">
            <input type="text" name="action" class="input" placeholder="Tìm theo action" value="{{ $filters['action'] ?? '' }}" />
            <div class="flex gap-2">
                <button class="btn-secondary" type="submit">Lọc</button>
                <a href="{{ route('admin.histories.index') }}" class="btn-ghost">Reset</a>
            </div>
        </form>
    </x-admin.card>

    <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm dark:border-slate-800 mt-4">
        <table class="w-full min-w-[900px] table-auto">
            <thead class="table-head">
                <tr>
                    <th class="px-4 py-3">Actor</th>
                    <th class="px-4 py-3">Action</th>
                    <th class="px-4 py-3">Ref</th>
                    <th class="px-4 py-3">Time</th>
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
