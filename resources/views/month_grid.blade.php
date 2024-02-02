@include('components.events.create_event_form', ['formAction' => '/'])

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
        $period = \Carbon\CarbonPeriod::create($date->startOfMonth()->previous(\Carbon\Carbon::SUNDAY), $date->endOfMonth()->next(\Carbon\Carbon::SATURDAY));
        $periodDates = $period->toArray();
    @endphp
    @for ($i = 0; $i < count($periodDates) / 7; $i++)
        <div class="calendar-row">
            @for ($j = 0; $j < 7; $j++)
                @php
                    $dt = $periodDates[$j + $i * 7];
                    $isOtherMonth = !$dt->isSameMonth($date) ? ' other-month' : null;
                @endphp
                <div class="calendar-day {{ $isOtherMonth }}" onclick="focusForm('{{ $dt->format('Y-m-d') }}')">
                    <div
                        class="calendar-day-number {{ $isOtherMonth }} {{ $dt->timestamp == $today->timestamp ? ' today' : null }} {{ $dt->dayOfWeek == 0 ? ' holiday' : null }}">
                        {{ $dt->day }}
                    </div>
                    <ul class="calendar-event-list">
                        @foreach ($events as $event)
                            @if (date('d-m-Y', $event['date']) == $dt->format('d-m-Y'))
                                <li class="calendar-event">{{ $event['title'] }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endfor
        </div>
    @endfor
</div>
