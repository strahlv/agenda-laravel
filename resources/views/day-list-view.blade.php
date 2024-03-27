<div class="event-list-container">
    <x-events.hour-list :date="$date" :events="$events->filter(
        fn($event) => $date->isSameDay($event->start_date) || $date->between($event->start_date, $event->end_date),
    )" />
</div>
