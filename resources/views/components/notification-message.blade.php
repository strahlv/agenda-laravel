@props(['notification'])

@if ($notification->type === 'App\Notifications\EventParticipantInvited')
    <form method="POST" action="/events/{{ $notification->data['event_id'] }}/participate">
        @csrf
        @method('PATCH')
        <input type="hidden" name="participant_id" value="{{ $notification->notifiable_id }}">

        <li @class(['notification-message', 'unread' => !$notification->read_at])>
            <span><strong>{{ $notification->data['inviter_name'] }}</strong>
                {{ $notification->data['message'] }}</span><button type="submit" class="btn">Confirmar
                presença</button>
        </li>
    </form>
@else
    <li>Messagem não implementada para notificação de tipo <strong>{{ $notification->type }}</strong></li>
@endif
