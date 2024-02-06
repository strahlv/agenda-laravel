<x-events.create-form form-action="/" />

<div class="calendar-grid">
    <div class="calendar-row">
        <h2 class="calendar-weekday">Dom.</h2>
        <h2 class="calendar-weekday">Seg.</h2>
        <h2 class="calendar-weekday">Ter.</h2>
        <h2 class="calendar-weekday">Qua.</h2>
        <h2 class="calendar-weekday">Qui.</h2>
        <h2 class="calendar-weekday">Sex.</h2>
        <h2 class="calendar-weekday">Sáb.</h2>
    </div>

    @php
        $period = CarbonPeriod::create($date->startOfMonth()->previous(Carbon::SUNDAY), $date->endOfMonth()->next(Carbon::SATURDAY));
        $periodDates = $period->toArray();
        $today = CarbonImmutable::today();
    @endphp

    @for ($i = 0; $i < count($periodDates) / 7; $i++)
        <div class="calendar-row">
            @for ($j = 0; $j < 7; $j++)
                @php
                    $dt = $periodDates[$j + $i * 7];
                    $isOtherMonth = !$dt->isSameMonth($date);
                @endphp

                <div @class(['calendar-day', 'other-month' => $isOtherMonth]) onclick="focusForm('{{ $dt->format('Y-m-d') }}')">
                    <div @class([
                        'calendar-day-number',
                        'other-month' => $isOtherMonth,
                        'today' => $dt->timestamp == $today->timestamp,
                        'holiday' => $dt->dayOfWeek == 0,
                    ])>
                        {{ $dt->day }}
                    </div>
                    <ul class="calendar-event-list">
                        @foreach ($events as $event)
                            @if ($event->date->timestamp == $dt->timestamp)
                                <li class="calendar-event">{{ $event->title }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endfor
        </div>
    @endfor
</div>
