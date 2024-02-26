<div class="event-list-container">
    <x-events.list :date="$date" :events="$events->filter(fn($event) => $event->period->overlaps($date->startOfMonth(), $date->endOfMonth()))" />
</div>
