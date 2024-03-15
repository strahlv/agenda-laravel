<span><strong>{{ $notification->data['inviter_name'] }}</strong>
    {{ $notification->data['message'] }}</span>
<form method="POST" action="/events/{{ $notification->data['event_id'] }}/participate" class="self-center">
    @csrf
    @method('PATCH')
    <input type="hidden" name="participant_id" value="{{ $notification->notifiable_id }}">

    <button type="submit" class="btn">Confirmar
        presença</button>
</form>
