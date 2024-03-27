@props(['method' => 'POST', 'action' => '/', 'title' => 'Formulário sem título'])

@php
    $spoofMethod = '';
    $method = Str::of($method)->upper();
    if ($method == 'PUT' || $method == 'PATCH' || $method == 'DELETE') {
        $spoofMethod = $method;
        $method = 'POST';
    }
@endphp

<form method="{{ $method }}" action="{{ $errors->get('action')[0] ?? $action }}" onsubmit="onSubmitForm(event)"
    {{ $attributes }}>
    @csrf
    @method($spoofMethod)
    {{ $slot }}
</form>
