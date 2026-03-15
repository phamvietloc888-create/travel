<div {{ $attributes->merge(['class' => 'glass-card p-5 sm:p-6']) }}>
    @if(isset($title))
        <div class="mb-4 flex items-center justify-between gap-3">
            <h3 class="text-base font-semibold tracking-tight text-slate-900 dark:text-slate-100">{{ $title }}</h3>
            {{ $action ?? '' }}
        </div>
    @endif
    {{ $slot }}
</div>
