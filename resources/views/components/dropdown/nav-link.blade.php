@props(['href' => '#', 'active' => false])

<a href="{{ $href }}" @class(['btn', 'navbar-active' => $active])>{{ $slot }}</a>
