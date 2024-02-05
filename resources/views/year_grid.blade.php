@include('components.events.create_event_form', ['formAction' => '/'])

<div class="year-grid">
    @for ($m = 1; $m < 13; $m++)
        @php
            $monthDate = CarbonImmutable::create($date->year, $m);
            $period = CarbonPeriod::create($monthDate->startOfMonth()->previous(Carbon::SUNDAY), $monthDate->addWeeks(6));
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
                            $isOtherMonth = !$dt->isSameMonth($monthDate) ? ' other-month' : null;
                            $hasEvent = null;
                            foreach ($events as $event) {
                                if (!$isOtherMonth && $event->date->timestamp == $dt->timestamp) {
                                    // if (date('d-m-Y', $event['date']) == $dt->format('d-m-Y')) {
                                    $hasEvent = ' has-event';
                                    break;
                                }
                            }
                        @endphp
                        <div class="calendar-day-sm {{ $isOtherMonth }} {{ $hasEvent }}">
                            <div class="calendar-day-number {{ $isOtherMonth }} {{ $dt->timestamp == $today->timestamp && !$isOtherMonth ? ' today' : null }} {{ $dt->dayOfWeek == 0 ? ' holiday' : null }}"
                                onclick="focusForm('{{ $dt->format('Y-m-d') }}')">
                                {{ $dt->day }}
                            </div>
                        </div>
                    @endfor
                </div>
            @endfor
        </div>
    @endfor
</div>
