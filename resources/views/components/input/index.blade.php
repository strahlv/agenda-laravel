@props(['type' => 'text', 'name', 'label' => ''])

@php
    $id = str_replace('_', '-', $name);
@endphp

<div class="flex-col form-input">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" value="{{ old($name) }}"
        {{ $attributes }}>
    <x-form-error error="{{ $name }}" />
</div>
