@props(['notification'])

<li @class(['notification-message', 'unread' => !$notification->read_at])>
    <span class="text-sm self-start">{{ $notification->created_at->diffForHumans() }}</span>

    @if ($notification->type === 'App\Notifications\EventParticipantInvited')
        @include('components.notification.messages.event-invited')
    @elseif ($notification->type === 'App\Notifications\EventParticipantInvitationAccepted')
        @include('components.notification.messages.event-invite-accepted')
    @else
        <span>Messagem não implementada para notificação de tipo <strong>{{ $notification->type }}</strong></span>
    @endif
</li>
