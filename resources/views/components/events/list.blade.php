@props(['date', 'events'])

@php
    $lastDay = 0;
@endphp

@if ($events->count())
    <ul class="event-list">
        @foreach ($events as $event)
            <li class="event-list-item" id="{{ $event->id }}">
                <span class="event-day">{{ $lastDay != $event->start_date->day ? $event->start_date->day : '' }}</span>
                @if (!$event['isHoliday'])
                    @php
                        $updateRoute = route('events.update', ['event' => $event->id ?? -1]) . "#$event->id";
                        $eventTime = $event->is_all_day ? 'o dia todo' : ($event->start_time == $event->end_time ? $event->start_date->format('G:i') : $event->start_date->format('G:i') . ' - ' . $event->end_date->format('G:i'));
                    @endphp

                    <span class="event-item-title"
                        onclick='showEditForm(event, @json($event), "{{ $updateRoute }}")'>{{ $event->title }}
                        <span class="event-item-time">({{ $eventTime }})</span></span>

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
                $lastDay = $event->start_date->day;
            @endphp
        @endforeach
    </ul>
@else
    <x-events.none :date="$date" />
@endif
