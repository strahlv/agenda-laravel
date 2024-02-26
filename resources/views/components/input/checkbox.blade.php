@props(['name', 'label', 'checked' => false])

@php
    $id = str_replace('_', '-', $name);
@endphp

<div class="flex-row">
    <label for="{{ $id }}">
        <input type="hidden" name="{{ $name }}" value="false">
        <input type="checkbox" {{ $checked ? 'checked' : null }} name="{{ $name }}" id="{{ $id }}"
            value="true" {{ $attributes }}>
        <span>{{ $label }}</span>
    </label>
</div>
