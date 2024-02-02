@php
    $monthEvents = [];
    foreach ($events as $event) {
        if (date('m-Y', $event['date']) == $date->format('m-Y')) {
            $monthEvents[] = $event;
        }
    }
@endphp

<div class="event-list">
    @include('components.events.event_list', ['events' => $monthEvents])
</div>
