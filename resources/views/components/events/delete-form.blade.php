@props(['eventId'])

<form action="{{ route('events.destroy', ['event' => $eventId]) }}" method="POST">
    @csrf
    @method('DELETE')
    {{ $slot }}
</form>
