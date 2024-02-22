@props(['name', 'label'])

@php
    $id = str_replace('_', '-', $name);
@endphp

<div class="flex-col flex-1">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <input {{ $attributes }} type="time" name="{{ $name }}" id="{{ $id }}"
        value="{{ old($name) }}">
</div>
