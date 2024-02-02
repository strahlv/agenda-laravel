@include('layout.header')

@if (request()->query('display') == 'list')
    @include('year_list')
@else
    @include('year_grid')
@endif

@include('layout.footer')
