<x-calendar-layout calendar-view="month" :date="$date">
    @if (request()->query('display') == 'list')
        @include('month-list-view')
    @else
        @include('month-grid-view')
    @endif
</x-calendar-layout>
