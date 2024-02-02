@php
    function getMonthEvents(array $events, int $year, int $month)
    {
        $monthEvents = [];
        foreach ($events as $event) {
            if (date('m-Y', $event['date']) == $month . '-' . $year) {
                $monthEvents[] = $event;
            }
        }
        return $monthEvents;
    }
@endphp

<div class="event-list">
    @for ($i = 1; $i < 13; $i++)
        @include('components.events.event_list', ['events' => getMonthEvents($events, $date->year, $i)])
    @endfor
</div>
