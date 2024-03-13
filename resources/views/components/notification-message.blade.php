@props(['notification'])

<li @class(['notification-message', 'unread' => !$notification->read_at])>
    @if ($notification->type === 'App\Notifications\EventParticipantInvited')
        <span><strong>{{ $notification->data['inviter_name'] }}</strong>
            {{ $notification->data['message'] }}</span>
        <form method="POST" action="/events/{{ $notification->data['event_id'] }}/participate">
            @csrf
            @method('PATCH')
            <input type="hidden" name="participant_id" value="{{ $notification->notifiable_id }}">

            <button type="submit" class="btn">Confirmar
                presença</button>
        </form>
    @elseif ($notification->type === 'App\Notifications\EventParticipantInvitationAccepted')
        <span><strong>{{ $notification->data['participant_name'] }}</strong> {{ $notification->data['message'] }}</span>
    @else
        <span>Messagem não implementada para notificação de tipo <strong>{{ $notification->type }}</strong></span>
    @endif
</li>
