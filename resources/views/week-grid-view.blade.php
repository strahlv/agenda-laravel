<div class="calendar-grid">
    @php
        $period = CarbonPeriod::create($date->startOfWeek(Carbon::SUNDAY), $date->endOfWeek(Carbon::SATURDAY));
        $periodDates = $period->toArray();

        $events = $events->filter(fn($event) => $event->period->overlaps($period));
        $allDayEventsCount = $events->filter(fn($event) => $event->is_all_day)->count();
        $allDayEventsCellHeight = max(74, $allDayEventsCount * 24 + 2);
    @endphp

    <header class="calendar-row calendar-row-header" style="padding-left: 40px">
        @for ($i = 0; $i < count($periodDates); $i++)
            <h2 class="calendar-row-weekday">
                <div class="calendar-row-weekday-name">
                    {{ Str::of($periodDates[$i]->getTranslatedDayName())->limit(3, '.')->ucfirst() }}
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
                    <span id="{{ $i }}"
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
                    @php
                        $endDates = [];
                    @endphp

                    <div class="week-row">
                        @for ($j = 0; $j < 7; $j++)
                            @php
                                $dt = $periodDates[$j];
                                $dt->hour = max($i, 0);

                                $yHour = 0;

                                $storeRoute = route('users.events.store', ['user' => auth()->user()->id ?? -1]) . "#$i";
                            @endphp
                            <div class="week-cell"
                                onclick="showCreateForm('{{ $dt->format('Y-m-d') }}', '{{ $dt->format('H:i') }}', {{ $i == -1 ? 'true' : 'false' }}, '{{ $storeRoute }}')"
                                @if ($i == -1) style={{ $allDayEventsCount ? 'height:' . $allDayEventsCellHeight . 'px;' : null }} @endif>
                                {{-- TODO: extrair componente --}}
                                <ul class="calendar-event-list" {{-- x-data="items = {{ $events }}" --}}>
                                    @foreach ($events as $event)
                                        @php
                                            $startOfWeek = $periodDates[0];
                                            $startsBeforeThisWeek = $j == 0 && $event->startsBefore($startOfWeek);
                                            $endsAfterThisWeek = $event->endsAfter($period->getEndDate());

                                            $isAllDayEvent = $event->is_all_day;
                                            $canPlaceAllDay = $i == -1 && ($event->startsAt($dt) || $startsBeforeThisWeek) && $isAllDayEvent;
                                            $canPlaceAtHour = $event->startsAt($dt) && !$isAllDayEvent && $event->startsAtHour($i);

                                            $eventWidth = min($startsBeforeThisWeek ? $startOfWeek->diffInDays($event->end_date) + 1 : $event->durationInDays + 1, 7 - $j);
                                            $updateRoute = route('events.update', ['event' => $event->id ?? -1]) . "#$event->id";

                                            // Posiciona os eventos no grid
                                            $y = 0;

                                            foreach ($endDates as $end) {
                                                if ($event->start_date->isAfter($end)) {
                                                    break;
                                                }

                                                $y++;
                                            }

                                            if ($canPlaceAllDay) {
                                                $endDates[$y] = $event->end_date;
                                            }
                                        @endphp

                                        @if ($canPlaceAllDay)
                                            <x-events.grid-list-item :event="$event" :starts-before="$startsBeforeThisWeek"
                                                :ends-after="$endsAfterThisWeek" :update-route="$updateRoute" :y-offset="$y * 24" :width="'calc(100% *' .
                                                    $eventWidth .
                                                    ' + 2px * ' .
                                                    ($eventWidth - 1) .
                                                    ')'">
                                                {{ $event->title }}
                                            </x-events.grid-list-item>
                                        @elseif ($canPlaceAtHour)
                                            <x-events.grid-list-item :event="$event" :update-route="$updateRoute"
                                                :y-offset="$yHour * 24">
                                                {{ $event->title }} ({{ $event->formatted_start_time }} às
                                                {{ $event->formatted_end_time }})
                                            </x-events.grid-list-item>

                                            @php
                                                $yHour++;
                                            @endphp
                                        @endif
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
