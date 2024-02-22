@props(['event', 'startsBefore', 'endsAfter', 'yOffset', 'width' => '100%', 'isHoliday' => false, 'updateRoute'])

<li {{ $attributes->class(['calendar-event', 'holiday' => $event->is_holiday, 'starts-before' => $startsBefore, 'ends-after' => $endsAfter]) }}
    style="top: {{ $yOffset }}px; width: {{ $width }}"
    @@click='showEditForm(event, @json($event), "{{ $updateRoute }}")'>
    {{ $slot }}
    {{-- Checar autoria --}}
    @if ($event->can_update_or_destroy)
        <x-events.delete-form :eventId="$event->id">
            <button type="submit" class="btn btn-icon-sm"
                @@click="(event) => event.stopPropagation()"><i class="fa-solid fa-xmark"></i></button>
        </x-events.delete-form>
    @endif
</li>
