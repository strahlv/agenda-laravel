{{-- @extends('layout')

@section('main')
    @if (request()->query('display') == 'list')
        @include('month_list')
    @else
        @include('month_grid')
    @endif
@endsection --}}

<x-layout calendar-view="month" :date="$date">
    @if (request()->query('display') == 'list')
        @include('month-list-view')
    @else
        @include('month-grid-view')
    @endif
</x-layout>
