<div class="calendar-grid">
    @php
        $period = CarbonPeriod::create($date->startOfWeek(Carbon::SUNDAY), $date->endOfWeek(Carbon::SATURDAY));
        $periodDates = $period->toArray();
        $today = CarbonImmutable::today();
        $events = $events->filter(fn($event) => CarbonPeriod::create($event->start_date, $event->end_date)->overlaps($period));
        $allDayEventsCount = $events->filter(fn($event) => $event->end_date->greaterThanOrEqualTo($event->start_date->endOfDay()))->count();
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
                    'today' => $periodDates[$i]->timestamp == $today->timestamp,
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
                    <span
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
                        @for ($j = 0; $j < 7; $j++)
                            @php
                                $dt = $periodDates[$j];
                                $yOffset = 0;
                                $yOffsetHour = 0;
                            @endphp
                            <div class="week-cell" onclick="showCreateForm('{{ $dt->format('Y-m-d') }}')"
                                @if ($i == -1) style={{ $allDayEventsCount ? 'height:' . $allDayEventsCellHeight . 'px;' : null }} @endif>
                                <ul class="calendar-event-list" {{-- x-data="items = {{ $events }}" --}}>
                                    @foreach ($events as $event)
                                        @php
                                            $startsBeforeThisWeek = $j == 0 && $event->start_date->lessThan($periodDates[0]);
                                            $endsAfterThisWeek = $event->end_date->greaterThan($period->getEndDate());

                                            $isSameDay = $event->start_date->isSameDay($dt);
                                            $isAllDayEvent = $event->end_date->greaterThanOrEqualTo($event->start_date->endOfDay());
                                            $isSameStartHour = $event->start_date->hour == $i;

                                            $eventWidth = min($startsBeforeThisWeek ? $periodDates[0]->diffInDays($event->end_date) + 1 : $event->start_date->diffInDays($event->end_date) + 1, 7 - $j);

                                            $updateRoute = route('events.update', ['event' => $event->id ?? -1]);
                                        @endphp

                                        @if ($i == -1 && ($isSameDay || $startsBeforeThisWeek) && $isAllDayEvent)
                                            <x-events.grid-list-item :event="$event" :starts-before="$startsBeforeThisWeek"
                                                :ends-after="$endsAfterThisWeek" :update-route="$updateRoute" :y-offset="$yOffset * 24" :width="'calc(100% *' .
                                                    $eventWidth .
                                                    ' + 2px * ' .
                                                    ($eventWidth - 1) .
                                                    ')'">
                                                {{ $event->title }}
                                            </x-events.grid-list-item>
                                        @elseif ($isSameDay && !$isAllDayEvent && $isSameStartHour)
                                            <x-events.grid-list-item :event="$event" :starts-before="$startsBeforeThisWeek"
                                                :ends-after="$endsAfterThisWeek" :update-route="$updateRoute" :y-offset="$yOffsetHour * 24">
                                                {{ $event->title }} ({{ $event->start_date->format('G:i') }} às
                                                {{ $event->end_date->format('G:i') }})
                                            </x-events.grid-list-item>

                                            @php
                                                $yOffsetHour++;
                                            @endphp
                                        @endif

                                        @php
                                            if ($isAllDayEvent) {
                                                $yOffset++;
                                            }
                                        @endphp
                                    @endforeach
                                </ul>
                            </div>
                        @endfor
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>
