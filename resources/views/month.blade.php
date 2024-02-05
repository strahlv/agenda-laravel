@extends('layout')

@section('main')
    @if (request()->query('display') == 'list')
        @include('month_list')
    @else
        @include('month_grid')
    @endif
@endsection
