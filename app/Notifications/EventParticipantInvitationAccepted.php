<?php

namespace App\Notifications;

use App\Models\Event;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventParticipantInvitationAccepted extends Notification
{
    use Queueable;

    private User $participant;
    private Event $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($participant, $event)
    {
        $this->participant = $participant;
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
        // return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(
                $this->participant->name
                    . ' aceitou seu convite para o evento "'
                    . $this->event->title
                    . '"'
            )
            ->view(
                'emails.event-invitation-accepted',
                [
                    'event' => $this->event,
                    'participant' =>  $this->participant
                ]
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'participant_name' => $this->participant->name,
            'message' => 'aceitou seu convite para o evento "' . $this->event->title . '"',
        ];
    }
}
