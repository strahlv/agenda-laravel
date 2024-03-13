<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\User;
use App\Notifications\EventParticipantInvitationAccepted;
use App\Notifications\EventParticipantInvited;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index(User $user)
    {
        return $user->events;
    }

    public function store(User $user, EventRequest $request)
    {
        $inputs = $request->validated();

        if ($inputs['is_all_day'] == 'true') {
            $inputs['start_time'] = '00:00:00';
            $inputs['end_time'] = '23:59:59';
        } else {
            $inputs['end_date'] = $inputs['start_date'];
        }

        $event = Event::create([
            'title' => $inputs['title'],
            'start_date' => $inputs['start_date'] . " " . $inputs['start_time'],
            'end_date' => $inputs['end_date'] . " " . $inputs['end_time'],
            'user_id' => $user->id
        ]);

        // TODO: Criar relação many-to-many entre tabelas Event e Invitation
        // diferenciar participantes (já participam) de convidados (ainda não participam)
        $participantsStr = $inputs['participants'];

        if ($participantsStr) {
            $participantsEmails = Str::of($participantsStr)
                ->split('/,/')
                ->unique()
                ->filter(fn ($participant) => $participant != $user->email);
            $participants = User::whereIn('email', $participantsEmails)->get();

            foreach ($participants as $participant) {
                $participant->notify(new EventParticipantInvited(auth()->user(), $participant, $event));
            }
        }

        return back();
    }

    public function update(Event $event, EventRequest $request)
    {
        $this->authorize('update', $event);

        $inputs = $request->validated();

        if ($inputs['is_all_day'] == 'true') {
            $inputs['start_time'] = '00:00:00';
            $inputs['end_time'] = '23:59:59';
        } else {
            $inputs['end_date'] = $inputs['start_date'];
        }

        $event->update([
            'title' => $inputs['title'],
            'start_date' => $inputs['start_date'] . " " . $inputs['start_time'],
            'end_date' => $inputs['end_date'] . " " . $inputs['end_time'],
        ]);

        // TODO: Criar relação many-to-many entre tabelas Event e Invitation
        // diferenciar participantes (já participam) de convidados (ainda não participam)
        $invitedStr = $inputs['participants'];

        if ($invitedStr) {
            $invitedEmails = Str::of($invitedStr)
                ->split('/,/')
                ->unique()
                ->filter(
                    fn ($invitedEmail)
                    => $invitedEmail != $event->creator->email
                );

            $invitedParticipants = User::whereIn('email', $invitedEmails)->get();

            // Não enviar notificações para usuários que já participam do evento!
            $participantsToNotify = $invitedParticipants->filter(
                fn ($invitedEmail)
                => !$event->participants->contains(
                    fn ($participant)
                    => $participant->email === $invitedEmail
                )
            );

            foreach ($participantsToNotify as $participant) {
                $participant->notify(new EventParticipantInvited(auth()->user(), $participant, $event));
            }

            $detachIds = $invitedParticipants
                ->filter(
                    fn ($invitedParticipant)
                    => $event->participants->contains(
                        fn ($participant)
                        => $participant === $invitedParticipant
                    )
                )
                ->map(
                    fn ($participant)
                    => $participant->id
                );

            $event->participants()->sync($detachIds);
        } else {
            $event->participants()->detach();
        }

        return back();
    }

    public function participate(Event $event, Request $request)
    {
        $id = $request->input('participant_id');

        if ($id === $event->creator->id) {
            return back();
        }

        $event->participants()->syncWithoutDetaching($id);

        $participant = User::findOrFail($id);
        $event->creator->notify(new EventParticipantInvitationAccepted($participant, $event));

        return back();
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return back();
    }
}
