@include('layout.header')

@if (request()->query('display') == 'list')
    @include('month_list')
@else
    @include('month_grid')
@endif

@include('layout.footer')
