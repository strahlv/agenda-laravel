<x-layout calendar-view="week" :date="$date">
    @if (request()->query('display') == 'list')
        {{-- @include('week-list-view') --}}
        @include('week-grid-view')
    @else
        @include('week-grid-view')
    @endif
</x-layout>
