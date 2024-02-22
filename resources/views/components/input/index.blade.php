@props(['type' => 'text', 'name', 'label'])

@php
    $id = str_replace('_', '-', $name);
@endphp

<div class="flex-col">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <input {{ $attributes }} type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
        value="{{ old($name) }}">
    <x-form-error error="{{ $name }}" />
</div>
