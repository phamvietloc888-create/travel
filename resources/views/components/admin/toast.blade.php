@php
    $toast = session('toast');
@endphp

@if($toast)
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition.opacity.duration.300ms
        x-init="setTimeout(() => show = false, 3000)"
        class="flex items-center gap-3 rounded-2xl border border-emerald-200/70 bg-emerald-50/90 px-4 py-3 text-sm font-semibold text-emerald-800 shadow-lg shadow-emerald-100/70 dark:border-emerald-800 dark:bg-emerald-950/70 dark:text-emerald-100 dark:shadow-none"
    >
        <span class="grid h-7 w-7 place-items-center rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/60 dark:text-emerald-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M5 13l4 4L19 7" />
            </svg>
        </span>
        <span>{{ $toast }}</span>
    </div>
@endif
