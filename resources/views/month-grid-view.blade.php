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

                <div @class(['calendar-day', 'other-month' => $isOtherMonth]) onclick="showCreateForm('{{ $dt->format('Y-m-d') }}')">
                    <div @class([
                        'calendar-day-number',
                        'other-month' => $isOtherMonth,
                        'today' => $dt->timestamp == $today->timestamp,
                        'holiday' => $dt->dayOfWeek == 0,
                    ])>
                        {{ $dt->day }}
                    </div>
                    <ul class="calendar-event-list" x-data="items = {{ $events }}">
                        @foreach ($events as $event)
                            @if ($event->date->timestamp == $dt->timestamp)
                                @php
                                    $updateRoute = route('events.update', ['event' => $event->id ?? -1]);
                                @endphp

                                <li class="calendar-event"
                                    onclick='showEditForm(event, @json($event), "{{ $updateRoute }}")'>
                                    {{ $event->title }}
                                    @if ($event->id)
                                        <x-events.delete-form :eventId="$event->id">
                                            <button type="submit" class="btn btn-icon-sm"
                                                @click="(event) => event.stopPropagation()"><i
                                                    class="fa-solid fa-xmark"></i></button>
                                        </x-events.delete-form>
                                    @endif
                                </li>
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
