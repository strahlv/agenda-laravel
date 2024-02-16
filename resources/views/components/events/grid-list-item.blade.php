@props(['event', 'startsBefore', 'endsAfter', 'yOffset', 'width' => '100%', 'updateRoute'])

<li {{ $attributes->class(['calendar-event', 'starts-before' => $startsBefore, 'ends-after' => $endsAfter]) }}
    style="top: {{ $yOffset }}px; width: {{ $width }}"
    @@click='showEditForm(event, @json($event), "{{ $updateRoute }}")'>
    {{ $slot }}
    @if ($event->id)
        <x-events.delete-form :eventId="$event->id">
            <button type="submit" class="btn btn-icon-sm"
                @@click="(event) => event.stopPropagation()"><i class="fa-solid fa-xmark"></i></button>
        </x-events.delete-form>
    @endif
</li>
