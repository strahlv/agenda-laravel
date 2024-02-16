<div class="event-list">
    <x-events.list :date="$date" :events="$events->filter(
        fn($event) => $event->start_date->month == $date->month && $event->start_date->year == $date->year,
    )" />
</div>
