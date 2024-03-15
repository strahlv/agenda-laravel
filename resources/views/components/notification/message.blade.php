@props(['notification'])

<li @class(['notification-message', 'unread' => !$notification->read_at])>
    <span class="text-sm self-end">{{ $notification->created_at->diffForHumans() }}</span>

    @if ($notification->type === 'App\Notifications\EventParticipantInvited')
        @include('components.notification.messages.event-invited')
    @elseif ($notification->type === 'App\Notifications\EventParticipantInvitationAccepted')
        @include('components.notification.messages.event-invite-accepted')
    @elseif ($notification->type === 'App\Notifications\EventStartingSoon')
        @include('components.notification.messages.event-starting-soon')
    @else
        <span>Messagem não implementada para notificação de tipo <strong>{{ $notification->type }}</strong></span>
    @endif
</li>
