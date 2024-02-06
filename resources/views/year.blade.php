{{-- @extends('layout')

@section('main')
    @if (request()->query('display') == 'list')
        @include('year_list')
    @else
        @include('year_grid')
    @endif
@endsection --}}

<x-layout calendar-view="year" :date="$date">
    @if (request()->query('display') == 'list')
        @include('year-list-view')
    @else
        @include('year-grid-view')
    @endif
</x-layout>
