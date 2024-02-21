@props(['date', 'events'])

<ul>
    @php
        $lastHour = 0;
    @endphp

    @if ($events->count())
        @foreach ($events as $event)
            <li class="event-list-item">
                <span
                    class="event-day">{{ $lastHour != $event->start_date->hour ? $event->start_date->hour . 'h' : null }}</span>
                @if (!$event['isHoliday'])
                    @php
                        $route = route('events.update', ['event' => $event->id ?? -1]);
                    @endphp

                    <span class="event-item-title"
                        @@click='showEditForm(event, @json($event), "{{ $route }}")'>{{ $event->title }}
                        <span
                            class="event-item-time">({{ $event->is_all_day ? 'o dia todo' : $event->start_date->format('G:i') . ' - ' . $event->end_date->format('G:i') }})</span>
                    </span>

                    <div>
                        @if ($event->id)
                            <x-events.delete-form :eventId="$event->id">
                                <button type="submit" class="btn btn-icon btn-danger"><i
                                        class="fa-solid fa-trash-can"></i></button>
                            </x-events.delete-form>
                        @endif
                    </div>
                @else
                    <span class="event-item-title">{{ $event->title }}</span>
                @endif
            </li>

            @php
                $lastHour = $event->start_date->hour;
            @endphp
        @endforeach
    @else
        <p>Nenhum evento encontrado.</p>
        {{-- TODO: extrair componente --}}
        @php
            $createRoute = route('users.events.store', ['user' => auth()->user()->id ?? -1]);
        @endphp
        <button type="button" class="btn btn-primary"
            @@click="showCreateForm('{{ $date->format('Y-m-d') }}','{{ $date->format('H:i') }}', true, '{{ $createRoute }}')">Criar
            evento</button>
    @endif
</ul>
