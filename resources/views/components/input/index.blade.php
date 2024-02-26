@props(['type' => 'text', 'name', 'label' => ''])

@php
    $id = str_replace('_', '-', $name);
@endphp

<div class="flex-col form-input">
    <label for="{{ $id }}" class="form-label">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" value="{{ old($name) }}"
        {{ $attributes }}>
    <x-form-error error="{{ $name }}" />
    @if ($type == 'password')
        <button type="button" class="btn btn-icon password-toggle"
            @@click="togglePasswordVisibility('{{ $id }}')"><i class="fa-solid fa-eye"
                id="{{ $id }}"></i></button>
    @endif
</div>
