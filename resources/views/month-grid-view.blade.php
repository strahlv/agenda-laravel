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

        $events = $events->filter(fn($event) => CarbonPeriod::create($event->start_date, $event->end_date)->overlaps($period));
    @endphp

    @for ($i = 0; $i < count($periodDates) / 7; $i++)
        @php
            $endDates = [];
        @endphp

        <div class="calendar-row">
            @for ($j = 0; $j < 7; $j++)
                @php
                    $dt = $periodDates[$j + $i * 7];
                    $isOtherMonth = !$dt->isSameMonth($date);
                    $weekPeriod = CarbonPeriod::create($dt->copy()->startOfWeek(Carbon::SUNDAY), $dt->copy()->endOfWeek(Carbon::SATURDAY));
                    $weekEvents = $events->filter(fn($event) => $event->period->overlaps($weekPeriod));

                    $storeRoute = route('users.events.store', ['user' => auth()->user()->id ?? -1]);
                @endphp

                <div @class(['calendar-day', 'other-month' => $isOtherMonth])
                    onclick="showCreateForm('{{ $dt->format('Y-m-d') }}', '{{ $dt->format('H:i') }}', true, '{{ $storeRoute }}')">
                    <div @class([
                        'calendar-day-number',
                        'other-month' => $isOtherMonth,
                        'today' => $dt->isSameDay(today()),
                        'holiday' => $dt->dayOfWeek == 0,
                    ])>
                        {{ $dt->day }}
                    </div>
                    {{-- TODO: extrair componente --}}
                    <ul class="calendar-event-list" {{-- x-data="items = {{ $events }}" --}}>
                        @foreach ($weekEvents as $event)
                            @php
                                $startOfWeek = $weekPeriod->getStartDate();
                                $startsBeforeThisWeek = $event->startsBefore($startOfWeek);
                                $endsAfterThisWeek = $event->endsAfter($weekPeriod->getEndDate());
                                $isInPeriod = $dt->between($event->start_date, $event->end_date);
                                $canPlace = ($j == 0 && $startsBeforeThisWeek && $isInPeriod) || $event->startsAt($dt);

                                $eventWidth = min($startsBeforeThisWeek ? $startOfWeek->diffInDays($event->end_date) + 1 : $event->start_date->diffInDays($event->end_date) + 1, 7 - $j);
                                $updateRoute = route('events.update', ['event' => $event->id ?? -1]) . "#$event->id";

                                // Posiciona os eventos no grid
                                $y = 0;

                                foreach ($endDates as $endDate) {
                                    if ($event->start_date->isAfter($endDate)) {
                                        break;
                                    }

                                    $y++;
                                }

                                if ($canPlace) {
                                    $endDates[$y] = $event->end_date;
                                }
                            @endphp

                            @if ($canPlace)
                                <x-events.grid-list-item :event="$event" :starts-before="$startsBeforeThisWeek" :ends-after="$endsAfterThisWeek"
                                    :update-route="$updateRoute" :y-offset="$y * 24" :width="'calc(100% *' . $eventWidth . ' + 10px * ' . ($eventWidth - 1) . ')'">
                                    {{ $event->title }}
                                </x-events.grid-list-item>
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
