<x-calendar-layout calendar-view="week" :date="$date">
    @if (request()->query('display') == 'list')
        @include('week-list-view')
    @else
        @include('week-grid-view')
    @endif
</x-calendar-layout>
