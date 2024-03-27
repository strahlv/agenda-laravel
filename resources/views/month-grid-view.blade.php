<div class="calendar-grid">
    @php
        $firstWeekDay = auth()->user()->first_week_day ?? Carbon::SUNDAY;
        $lastWeekDay = auth()->user()->last_week_day ?? Carbon::SATURDAY;

        $period = CarbonPeriod::create(
            $date->startOfMonth()->previous($firstWeekDay),
            $date->endOfMonth()->next($lastWeekDay),
        );
        $periodDates = $period->toArray();

        $events = $events->filter(
            fn($event) => CarbonPeriod::create($event->start_date, $event->end_date)->overlaps($period),
        );
    @endphp

    <header class="calendar-row calendar-row-header">
        @for ($i = 0; $i < 7; $i++)
            <h2 class="calendar-weekday">
                {{ Str::of($periodDates[$i]->getTranslatedDayName())->limit(3, '.')->ucfirst() }}</h2>
        @endfor
    </header>

    @for ($i = 0; $i < count($periodDates) / 7; $i++)
        @php
            $endDates = [];
        @endphp

        <div class="calendar-row">
            @for ($j = 0; $j < 7; $j++)
                @php
                    $dt = $periodDates[$j + $i * 7];
                    $isOtherMonth = !$dt->isSameMonth($date);
                    $weekPeriod = CarbonPeriod::create(
                        $dt->copy()->startOfWeek($firstWeekDay),
                        $dt->copy()->endOfWeek($lastWeekDay),
                    );
                    $weekEvents = $events->filter(fn($event) => $event->period->overlaps($weekPeriod));

                    $storeRoute = route('users.events.store', ['user' => auth()->user()->id ?? -1]);
                @endphp

                <div @class(['calendar-day', 'other-month' => $isOtherMonth]) x-data
                    @@click="$dispatch('create-event', { data: { date: '{{ $dt->format('Y-m-d') }}', time: '{{ $dt->format('H:i') }}', isAllDay: true }, url: '{{ $storeRoute }}' })">
                    <div @class([
                        'calendar-day-number',
                        'other-month' => $isOtherMonth,
                        'today' => $dt->isSameDay(today()),
                        'holiday' => $dt->dayOfWeek == 0,
                    ])>
                        {{ $dt->day }}
                    </div>
                    {{-- TODO: extrair componente --}}
                    <ul class="calendar-event-list">
                        @foreach ($weekEvents as $event)
                            @php
                                $startOfWeek = $weekPeriod->getStartDate();
                                $startsBeforeThisWeek = $event->startsBefore($startOfWeek);
                                $endsAfterThisWeek = $event->endsAfter($weekPeriod->getEndDate());
                                $isInPeriod = $dt->between($event->start_date, $event->end_date);
                                $canPlace = ($j == 0 && $startsBeforeThisWeek && $isInPeriod) || $event->startsAt($dt);

                                $eventWidth = min(
                                    $startsBeforeThisWeek
                                        ? $startOfWeek->diffInDays($event->end_date) + 1
                                        : $event->start_date->diffInDays($event->end_date) + 1,
                                    7 - $j,
                                );

                                // Posiciona os eventos no grid
                                $y = 0;

                                foreach ($endDates as $endDate) {
                                    if (
                                        $event->start_date->isAfter($endDate) &&
                                        !$event->start_date->isSameDay($endDate)
                                    ) {
                                        break;
                                    }

                                    $y++;
                                }

                                if ($canPlace) {
                                    $endDates[$y] = $event->end_date;
                                }

                                $updateRoute = route('events.update', ['event' => $event->id ?? -1]);
                            @endphp

                            @if ($canPlace)
                                <x-events.grid-list-item :event="$event" :starts-before="$startsBeforeThisWeek" :ends-after="$endsAfterThisWeek"
                                    :y-offset="$y * 24" :width="'calc(100% * ' . $eventWidth . ' + 3px * ' . $eventWidth - 1 . ' - 2px)'" :update-route="$updateRoute">
                                    {{ $event->title }}
                                </x-events.grid-list-item>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endfor
        </div>
    @endfor
</div>
