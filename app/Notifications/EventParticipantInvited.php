<?php

namespace App\Notifications;

use App\Models\Event;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventParticipantInvited extends Notification
{
    use Queueable;

    private User $inviter;
    private User $participant;
    private Event $event;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($inviter, $participant, $event)
    {
        $this->inviter = $inviter;
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
        // return ['mail', 'database'];
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // TODO: notificar por email
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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
            'inviter_name' => $this->inviter->name,
            'event_id' => $this->event->id,
            'message' => 'te convidou para o evento "' . $this->event->title . '"',
        ];
    }
}
