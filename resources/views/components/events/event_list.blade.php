<ul>
    @php
        $lastDay = 0;
    @endphp
    @foreach ($events as $event)
        @php
            $day = date('d', $event['date']);
        @endphp
        <li class="event-list-item">
            <span class="event-day">{{ $lastDay != $day ? $day : '' }}</span>
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
            $lastDay = $day;
        @endphp
    @endforeach
</ul>
