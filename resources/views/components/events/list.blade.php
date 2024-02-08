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
                    @php
                        $route = route('events.update', ['event' => $event->id ?? -1]);
                    @endphp

                    <span class="event-item-input-text"
                        @click='showEditForm(event, @json($event), "{{ $route }}")'>{{ $event->title }}</span>

                    <div>
                        @if ($event->id)
                            <x-events.delete-form :eventId="$event->id">
                                <button type="submit" class="btn btn-icon btn-danger"><i
                                        class="fa-solid fa-trash-can"></i></button>
                            </x-events.delete-form>
                        @endif
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
        <button type="button" class="btn btn-primary" @click="showCreateForm('{{ $date->format('Y-m-d') }}')">Criar
            evento</button>
    @endif
</ul>
