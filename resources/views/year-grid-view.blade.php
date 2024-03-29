<div class="year-grid">
    @for ($m = 1; $m < 13; $m++)
        @php
            $monthDate = CarbonImmutable::create($date->year, $m);
            $startOfMonth = auth()->user()->settings->year_starts_day_one
                ? $monthDate->startOfMonth()
                : $monthDate->startOfMonth()->previous(Carbon::SUNDAY);
            $period = CarbonPeriod::create($startOfMonth, $monthDate->addWeeks(6));
            $periodDates = $period->toArray();
        @endphp

        <div class="year-grid-cell">
            <a href="{{ Helpers::formatToCalendarUrl('month', $monthDate) }}"
                class="month-name">{{ ucfirst($monthDate->translatedFormat('F')) }}</a>
            <div class="calendar-row-sm weekday-sm">
                <div class="calendar-week-sm holiday">D</div>
                <div class="calendar-week-sm">S</div>
                <div class="calendar-week-sm">T</div>
                <div class="calendar-week-sm">Q</div>
                <div class="calendar-week-sm">Q</div>
                <div class="calendar-week-sm">S</div>
                <div class="calendar-week-sm">S</div>
            </div>
            {{-- 6 semanas --}}
            @for ($i = 0; $i < 6; $i++)
                <div class="calendar-row-sm">
                    {{-- 7 dias --}}
                    @for ($j = 0; $j < 7; $j++)
                        @php
                            $dt = $periodDates[$j + $i * 7];
                            $isOtherMonth = !$dt->isSameMonth($monthDate);
                            $hasEvent = false;

                            foreach ($events as $event) {
                                if (
                                    (!$isOtherMonth && $event->start_date->isSameDay($dt)) ||
                                    $dt->between($event->start_date, $event->end_date)
                                ) {
                                    $hasEvent = true;
                                    break;
                                }
                            }

                            $storeRoute = route('users.events.store', ['user' => auth()->user()->id ?? -1]);
                        @endphp

                        <div @class([
                            'calendar-day-sm',
                            'other-month' => $isOtherMonth,
                            'has-event' => $hasEvent,
                        ])>
                            <div @class([
                                'calendar-day-number',
                                'other-month' => $isOtherMonth,
                                'holiday' => $dt->dayOfWeek == 0,
                                'today' => $dt->isSameDay(today()) && !$isOtherMonth,
                            ]) x-data
                                @@click="$dispatch('create-event', { data: { date: '{{ $dt->format('Y-m-d') }}', time: '{{ $dt->format('H:i') }}', isAllDay: true }, url: '{{ $storeRoute }}' })">
                                {{ $dt->day }}
                            </div>
                        </div>
                    @endfor
                </div>
            @endfor
        </div>
    @endfor
</div>
