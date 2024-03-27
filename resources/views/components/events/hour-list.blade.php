@props(['date', 'events'])

<ul class="event-list">
    @php
        $lastHour = 0;
    @endphp

    @if ($events->count())
        @foreach ($events as $event)
            <li class="event-list-item" x-data>
                <span
                    class="event-day">{{ $lastHour != $event->start_date->hour ? $event->start_date->hour . 'h' : null }}</span>
                @if (!$event->is_holiday)
                    @php
                        $isParticipant = $event->creator?->id != auth()->user()?->id;
                        $clickAction = $isParticipant ? 'show-event' : 'edit-event';
                        $updateRoute = route('events.update', ['event' => $event->id ?? -1]) . "#$event->id";
                    @endphp

                    <h2 class="event-item-title"
                        @@click.stop="$dispatch('{{ $clickAction }}', { data: {{ $event->toJson() }}, url: '{{ $updateRoute }}' })">
                        {{ $event->title }} <span class="label">({{ $event->fancy_time }})</span>
                    </h2>

                    <div>
                        @if ($event->id)
                            <x-events.delete-form :eventId="$event->id">
                                <button type="submit" class="btn btn-icon btn-danger"><i
                                        class="fa-solid fa-trash-can"></i></button>
                            </x-events.delete-form>
                        @endif
                    </div>
                @else
                    <span class="event-item-title">{{ $event->title }}</span>
                @endif
            </li>

            @php
                $lastHour = $event->start_date->hour;
            @endphp
        @endforeach
    @else
        <x-events.none :date="$date" />
    @endif
</ul>
