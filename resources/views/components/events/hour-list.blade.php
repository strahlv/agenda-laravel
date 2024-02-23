@props(['date', 'events'])

<ul class="event-list">
    @php
        $lastHour = 0;
    @endphp

    @if ($events->count())
        @foreach ($events as $event)
            <li class="event-list-item">
                <span
                    class="event-day">{{ $lastHour != $event->start_date->hour ? $event->start_date->hour . 'h' : null }}</span>
                @if (!$event['isHoliday'])
                    @php
                        $updateRoute = route('events.update', ['event' => $event->id ?? -1]) . "#$event->id";
                    @endphp

                    <span class="event-item-title"
                        @@click='showEditForm(event, @json($event), "{{ $updateRoute }}")'>{{ $event->title }}
                        <span
                            class="event-item-time">({{ $event->is_all_day ? 'o dia todo' : $event->start_date->format('G:i') . ' - ' . $event->end_date->format('G:i') }})</span>
                    </span>

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
