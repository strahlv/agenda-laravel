<div class="event-list">
    @include('components.events.event_list', [
        'events' => $events->filter(
            fn($event) => $event->date->month == $date->month && $event->date->year == $date->year),
    ])
</div>
