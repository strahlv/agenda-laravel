@props(['date', 'events'])

@php
    $lastDay = 0;
@endphp

@if ($events->count())
    <ul class="event-list">
        @foreach ($events as $event)
            <li class="event-list-item opaque-on-hover-trigger" id="{{ $event->id }}" x-data>
                <span class="event-day">{{ $lastDay != $event->start_date->day ? $event->start_date->day : '' }}</span>

                @php
                    $isParticipant = $event->creator?->id != auth()->user()?->id;
                    $clickAction = $isParticipant ? 'show-event' : 'edit-event';
                    $updateRoute = route('events.update', ['event' => $event->id ?? -1]) . "#$event->id";
                @endphp

                <h2 class="event-item-title"
                    @@click.stop="$dispatch('{{ $clickAction }}', { data: {{ $event->toJson() }}, url: '{{ $updateRoute }}' })">
                    {{ $event->title }} <span class="label">({{ $event->fancy_time }})</span>
                </h2>

                @if ($event->id)
                    <x-events.delete-form :eventId="$event->id">
                        <button type="submit" class="btn btn-icon btn-danger opaque-on-hover"><i
                                class="fa-solid fa-trash-can"></i></button>
                    </x-events.delete-form>
                @endif
            </li>

            @php
                $lastDay = $event->start_date->day;
            @endphp
        @endforeach
    </ul>
@else
    <x-events.none :date="$date" />
@endif
