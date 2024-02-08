<div class="event-list">
    <x-events.list :date="$date" :events="$events->filter(fn($event) => $event->date->month == $date->month && $event->date->year == $date->year)" />
</div>
