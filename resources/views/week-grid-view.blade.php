<div class="calendar-grid">
    @php
        $period = CarbonPeriod::create($date->previous(Carbon::SUNDAY), $date->next(Carbon::SATURDAY));
        $periodDates = $period->toArray();
        $today = CarbonImmutable::today();
    @endphp

    <div class="calendar-row calendar-row-header" style="padding-left: 40px">
        @for ($i = 0; $i < count($periodDates); $i++)
            <h2 class="calendar-row-weekday">
                <div class="calendar-row-weekday-name">
                    {{ Str::ucfirst(Str::limit($periodDates[$i]->getTranslatedDayName(), 3, '.')) }}
                </div>
                <div class="calendar-row-weekday-number">
                    {{ $periodDates[$i]->day }}
                </div>
            </h2>
        @endfor
    </div>

    <div class="week-grid-container">
        <div class="week-grid">
            <div class="hour-col">
                @for ($i = 0; $i < 24; $i++)
                    <span>{{ $i != 0 ? $i . 'h' : null }}</span>
                @endfor
            </div>
            <div class="line-col">
                @for ($i = 0; $i < 24; $i++)
                    <div></div>
                @endfor
            </div>
            <div class="week-events-container">
                @for ($i = 0; $i < 24; $i++)
                    <div class="week-row">
                        @for ($j = 0; $j < 7; $j++)
                            @php
                                $dt = $periodDates[$j];
                            @endphp
                            <div class="week-cell" onclick="showCreateForm('{{ $dt->format('Y-m-d') }}')">
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
                                </ul>
                            </div>
                        @endfor
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>
