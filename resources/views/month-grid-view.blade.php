<div class="calendar-grid">
    <div class="calendar-row calendar-row-header">
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
        $events = $events->filter(fn($event) => CarbonPeriod::create($event->start_date, $event->end_date)->overlaps($period));
    @endphp

    @for ($i = 0; $i < count($periodDates) / 7; $i++)
        @php
            $yOffset = 0;
        @endphp
        <div class="calendar-row">
            @for ($j = 0; $j < 7; $j++)
                @php
                    $dt = $periodDates[$j + $i * 7];
                    $isOtherMonth = !$dt->isSameMonth($date);
                    $weekPeriod = CarbonPeriod::create($dt->copy()->startOfWeek(Carbon::SUNDAY), $dt->copy()->endOfWeek(Carbon::SATURDAY));
                @endphp

                <div @class(['calendar-day', 'other-month' => $isOtherMonth]) onclick="showCreateForm('{{ $dt->format('Y-m-d') }}')">
                    <div @class([
                        'calendar-day-number',
                        'other-month' => $isOtherMonth,
                        'today' => $dt->timestamp == $today->timestamp,
                        'holiday' => $dt->dayOfWeek == 0,
                    ])>
                        {{ $dt->day }}
                    </div>
                    <ul class="calendar-event-list" {{-- x-data="items = {{ $events }}" --}}>
                        @foreach ($events as $event)
                            @php
                                $startsBeforeThisWeek = $j == 0 && $event->start_date->lessThan($weekPeriod->getStartDate());
                                $endsAfterThisWeek = $event->end_date->greaterThan($weekPeriod->getEndDate());

                                $isSameDay = $event->start_date->isSameDay($dt);

                                $eventWidth = min($startsBeforeThisWeek ? $weekPeriod->getStartDate()->diffInDays($event->end_date) + 1 : $event->start_date->diffInDays($event->end_date) + 1, 7 - $j);

                                $updateRoute = route('events.update', ['event' => $event->id ?? -1]);
                            @endphp

                            @if ($isSameDay)
                                <x-events.grid-list-item :event="$event" :starts-before="$startsBeforeThisWeek" :ends-after="$endsAfterThisWeek"
                                    :update-route="$updateRoute" :y-offset="$yOffset * 24" :width="'calc(100% *' . $eventWidth . ' + 10px * ' . ($eventWidth - 1) . ')'">
                                    {{ $event->title }}
                                </x-events.grid-list-item>
                                @php
                                    $yOffset++;
                                @endphp
                            @endif
                        @endforeach
                        {{-- CSS BUG!!! --}}
                        {{-- <template x-for="item in filteredItems">
                            <li x-text="item.title" class="calendar-event"></li>
                        </template> --}}
                    </ul>
                </div>
            @endfor
        </div>
    @endfor
</div>
