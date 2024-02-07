@props(['trigger'])

<div x-data="{ open: false }" class="dropdown">
    <div @click="open = !open" class="dropdown-trigger">{{ $trigger }}</div>

    <div x-show="open" @click.outside="open = false" class="dropdown-contents" style="display:none">
        {{ $slot }}
    </div>
</div>
