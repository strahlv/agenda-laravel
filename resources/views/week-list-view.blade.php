<div class="event-list-container">
    <x-events.list :date="$date" :events="$events->filter(
        fn($event) => $event->start_date->startOfWeek(Carbon::SUNDAY) == $date->startOfWeek(Carbon::SUNDAY) &&
            $event->start_date->endOfWeek(Carbon::SATURDAY) == $date->endOfWeek(Carbon::SATURDAY),
    )" />
</div>
