<div {{ $attributes->merge(['class' => 'glass-card rounded-2xl p-5']) }}>
    @if(isset($title))
        <div class="flex items-center justify-between gap-3 mb-3">
            <h3 class="text-base font-semibold">{{ $title }}</h3>
            {{ $action ?? '' }}
        </div>
    @endif
    {{ $slot }}
</div>
