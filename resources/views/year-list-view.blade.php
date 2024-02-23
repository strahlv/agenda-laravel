<div class="event-list-container">
    @php
        $yearHasEvents = false;
    @endphp

    @for ($i = 1; $i < 13; $i++)
        @php
            $monthEvents = collect($events)->filter(fn($event) => $event->start_date->month == $i && $event->start_date->year == $date->year);
        @endphp

        @if (count($monthEvents) > 0)
            <a href="/month/{{ $date->year }}/{{ $i }}/{{ $date->day }}?display=list"
                class="event-list-month-title">{{ ucfirst(Carbon::createFromDate(1, $i)->translatedFormat('F')) }}</a>
            <x-events.list :date="$date" :events="$monthEvents" />

            @php
                $yearHasEvents = true;
            @endphp
        @endif
    @endfor
    @if (!$yearHasEvents)
        <x-events.none :date="$date" />
    @endif
</div>
