@props([
    'event',
    'startsBefore' => false,
    'endsAfter' => false,
    'isHoliday' => false,
    'yOffset' => 0,
    'width' => '100%',
    'updateRoute',
])

<li {{ $attributes->class(['calendar-event', 'holiday' => $event->is_holiday, 'starts-before' => $startsBefore, 'ends-after' => $endsAfter]) }}
    style="top: {{ $yOffset }}px; width: {{ $width }}"
    onclick='showEditForm(event, @json($event), "{{ $updateRoute }}")'>
    {{ $slot }}

    @can('delete', $event)
        <x-events.delete-form :eventId="$event->id">
            <button type="submit" class="btn btn-icon-sm" onclick="stopPropagation(event)"><i
                    class="fa-solid fa-xmark"></i></button>
        </x-events.delete-form>
    @endcan
</li>
