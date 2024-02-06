@props(['date', 'events'])

<ul>
    @php
        $lastDay = 0;
    @endphp

    @if ($events->count())
        @foreach ($events as $event)
            <li class="event-list-item">
                <span class="event-day">{{ $lastDay != $event->date->day ? $event->date->day : '' }}</span>
                @if (!$event['isHoliday'])
                    <form action="" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="text" name="title" id="title" class="event-item-input-text"
                            value="{{ $event['title'] }}">
                    </form>
                    <div>
                        <a href="/$redirectTo?display=list&delete=$evento->id" class="btn btn-danger"><i
                                class="fa-solid fa-trash-can"></i></a>
                    </div>
                @else
                    <span class="event-item-input-text">{{ $event['title'] }}</span>
                @endif
            </li>

            @php
                $lastDay = $event->date->day;
            @endphp
        @endforeach
    @else
        <p>Nenhum evento encontrado.</p>
        <button type="button" class="btn btn-primary" onclick="focusForm('{{ $date->format('Y-m-d') }}')">Criar
            evento</button>
    @endif
</ul>
