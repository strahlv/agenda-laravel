<div class="calendar-grid">
    @php
        $period = CarbonPeriod::create($date, $date->endOfDay());
        $periodDates = $period->toArray();

        $events = $events->filter(
            fn($event) => CarbonPeriod::create($event->start_date, $event->end_date)->overlaps($period),
        );
        $allDayEventsCount = $events->filter(fn($event) => $event->is_all_day)->count();
        $allDayEventsCellHeight = max(74, $allDayEventsCount * 24 + 2);
    @endphp

    <header class="calendar-row calendar-row-header" style="padding-left: 40px">
        @for ($i = 0; $i < count($periodDates); $i++)
            <h2 class="calendar-row-weekday">
                <div class="calendar-row-weekday-name">
                    {{ Str::ucfirst(Str::limit($periodDates[$i]->getTranslatedDayName(), 3, '.')) }}
                </div>
                <div @class([
                    'calendar-row-weekday-number',
                    'today' => $periodDates[$i]->isSameDay(today()),
                ])>
                    {{ $periodDates[$i]->day }}
                </div>
            </h2>
        @endfor
        <div class="scroll-width"></div>
    </header>

    <div class="week-grid-container">
        <div class="week-grid">
            <div class="hour-col">
                @for ($i = -1; $i < 24; $i++)
                    <span id="h{{ $i }}"
                        @if ($i == -1) style="{{ $allDayEventsCount ? 'flex: 0 0 auto; height: ' . $allDayEventsCellHeight . 'px;' : null }}" @endif>
                        {{ $i >= 0 ? $i . 'h' : 'O dia todo' }}</span>
                @endfor
            </div>

            <div class="line-col">
                @for ($i = -1; $i < 24; $i++)
                    <div
                        @if ($i == -1) style="{{ $allDayEventsCount ? 'flex: 0 0 auto; height: ' . $allDayEventsCellHeight . 'px;' : null }}" @endif>
                    </div>
                @endfor
            </div>

            <div class="week-events-grid-container">
                @for ($i = -1; $i < 24; $i++)
                    <div class="week-row">
                        @php
                            $dt = $periodDates[0];
                            $dt->hour = max($i, 0);

                            $yOffset = 0;
                            $yOffsetHour = 0;

                            $storeRoute = route('users.events.store', ['user' => auth()->user()->id ?? -1]) . "#h$i";
                        @endphp
                        <div class="week-cell" x-data
                            @@click="$dispatch('create-event', { data: { date: '{{ $dt->format('Y-m-d') }}', time: '{{ $dt->format('H:i') }}', isAllDay: {{ $i == -1 ? 'true' : 'false' }} }, url: '{{ $storeRoute }}' })"
                            @if ($i == -1) style={{ $allDayEventsCount ? 'height:' . $allDayEventsCellHeight . 'px;' : null }} @endif>
                            <ul class="calendar-event-list" {{-- x-data="items = {{ $events }}" --}}>
                                @foreach ($events as $event)
                                    @php
                                        $startDate = $event->start_date;
                                        $endDate = $event->end_date;

                                        $isInPeriod = $dt->between($startDate, $endDate);

                                        $startsBeforeThisWeek = $startDate->lessThan($periodDates[0]);
                                        $endsAfterThisWeek = $endDate->greaterThan($period->getEndDate());

                                        $isSameDay = $startDate->isSameDay($dt);

                                        $isAllDayEvent = $event->is_all_day;
                                        $isSameStartHour = $startDate->hour == $i;

                                        $eventWidth = 1;

                                        $updateRoute =
                                            route('events.update', ['event' => $event->id ?? -1]) . "#$event->id";
                                    @endphp

                                    @if ($i == -1 && ($isSameDay || $startsBeforeThisWeek) && $isAllDayEvent)
                                        <x-events.grid-list-item :event="$event" :starts-before="$startsBeforeThisWeek" :ends-after="$endsAfterThisWeek"
                                            :update-route="$updateRoute" :y-offset="$yOffset * 24" :width="'calc((100% + 4px) * ' . $eventWidth . ' - 4px' . ')'">
                                            {{ $event->title }}
                                        </x-events.grid-list-item>
                                    @elseif ($isSameDay && !$isAllDayEvent && $isSameStartHour)
                                        <x-events.grid-list-item :event="$event" :starts-before="$startsBeforeThisWeek" :ends-after="$endsAfterThisWeek"
                                            :update-route="$updateRoute" :y-offset="$yOffsetHour * 24">
                                            {{ $event->title }} ({{ $startDate->format('G:i') }} às
                                            {{ $endDate->format('G:i') }})
                                        </x-events.grid-list-item>

                                        @php
                                            $yOffsetHour++;
                                        @endphp
                                    @endif

                                    @php
                                        // if ($isAllDayEvent && $isInPeriod) {
                                        if ($isAllDayEvent) {
                                            $yOffset++;
                                        }
                                    @endphp
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>
