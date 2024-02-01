@include('layout.header')

<form action="" class="form-create-event hidden">
    <div class="form-header">
        <h1>Criar evento </h1>
        <button type="button" class="btn btn-icon" onclick="hideForm()"><i class="fa-solid fa-x"></i></button>
    </div>
    <div class="form-control">
        <label for="title">Título</label>
        <input type="text" name="title" id="title">
    </div>
    <div class="form-control">
        <label for="title">Data</label>
        <input type="date" name="date" id="date">
    </div>
    <button type="submit" class="btn btn-save">Salvar</button>
</form>
<div class="year-grid">
    @for ($m = 1; $m < 13; $m++)
        @php
            $monthDate = \Carbon\CarbonImmutable::create($date->year, $m);
            $period = \Carbon\CarbonPeriod::create($monthDate->startOfMonth()->previous(\Carbon\Carbon::SUNDAY), $monthDate->addWeeks(6));
            $periodDates = $period->toArray();
        @endphp
        <div class="year-grid-cell">
            <a href="/month/{{ $monthDate->format('Y/n/j') }}"
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
                        @endphp
                        <div class="calendar-day-sm {{ $isOtherMonth }}">
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

@include('layout.footer')
