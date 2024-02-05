@extends('layout')

@section('main')
    @if (request()->query('display') == 'list')
        @include('year_list')
    @else
        @include('year_grid')
    @endif
@endsection
