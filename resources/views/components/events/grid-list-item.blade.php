@props([
    'event',
    'startsBefore' => false,
    'endsAfter' => false,
    'isHoliday' => false,
    'yOffset' => 0,
    'width' => '100%',
    'updateRoute',
])

@php
    $isParticipant = $event->creator?->id != auth()->user()?->id;
@endphp

<li {{ $attributes->class([
    'calendar-event',
    'opaque-on-hover-trigger',
    'participant' => $isParticipant,
    'holiday' => $event->is_holiday,
    'starts-before' => $startsBefore,
    'ends-after' => $endsAfter,
]) }}
    id="{{ $event->id }}" style="top: {{ $yOffset }}px; width: {{ $width }}" x-data
    @@click='showEditForm(event, @json($event), "{{ $updateRoute }}"); $dispatch("edit_event", {{ $event->participants }})'>
    {{ $slot }}

    @can('delete', $event)
        <x-events.delete-form :eventId="$event->id">
            <button type="submit" class="btn btn-icon-sm opaque-on-hover" onclick="stopPropagation(event)"><i
                    class="fa-solid fa-xmark"></i></button>
        </x-events.delete-form>
    @endcan
</li>
