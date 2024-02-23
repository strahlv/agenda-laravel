<x-calendar-layout calendar-view="day" :date="$date">
    @if (request()->query('display') == 'list')
        @include('day-list-view')
    @else
        @include('day-grid-view')
    @endif
</x-calendar-layout>
