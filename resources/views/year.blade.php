<x-calendar-layout calendar-view="year" :date="$date">
    @if (request()->query('display') == 'list')
        @include('year-list-view')
    @else
        @include('year-grid-view')
    @endif
</x-calendar-layout>
