@props(['href', 'active'])

<a href="{{ $href }}" @class(['btn', 'navbar-active' => $active])>{{ $slot }}</a>
