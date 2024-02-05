<div class="event-list">
    @for ($i = 1; $i < 13; $i++)
        @php
            $monthEvents = collect($events)->filter(fn($event) => $event->date->month == $i && $event->date->year == $date->year);
        @endphp
        @if (count($monthEvents) > 0)
            <a href="/month/{{ $date->year }}/{{ $i }}/{{ $date->day }}?display=list"
                class="event-list-month-title">
                {{ ucfirst(Carbon::createFromDate(1, $i)->translatedFormat('F')) }}</a>
            @include('components.events.event_list', ['events' => $monthEvents])
        @endif
    @endfor
</div>
