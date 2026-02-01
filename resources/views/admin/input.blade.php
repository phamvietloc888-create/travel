@props(['label' => null, 'name' => null, 'hint' => null])

<div class="space-y-1">
    @if($label)
        <label for="{{ $attributes->get('id') ?? $name }}" class="label">{{ $label }}</label>
    @endif
    <input {{ $attributes->merge(['class' => 'input', 'name' => $name, 'id' => $name]) }}>
    @error($name)
        <p class="text-xs text-red-500">{{ $message }}</p>
    @enderror
    @if($hint)
        <p class="text-xs text-slate-500">{{ $hint }}</p>
    @endif
</div>
