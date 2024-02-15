<div class="event-list">
    <x-events.list :date="$date" :events="$events->filter(
        fn($event) => $event->date->startOfWeek(Carbon::SUNDAY) == $date->startOfWeek(Carbon::SUNDAY) &&
            $event->date->endOfWeek(Carbon::SATURDAY) == $date->endOfWeek(Carbon::SATURDAY),
    )" />
</div>
