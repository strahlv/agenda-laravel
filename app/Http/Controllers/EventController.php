<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\User;
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

        $participantsStr = $inputs['participants'];

        if ($participantsStr) {
            $participants = Str::of($participantsStr)
                ->split('/,/')
                ->unique()
                ->filter(fn ($participant) => $participant != $user->email);
            $ids = User::select('id')->whereIn('email', $participants)->get();
            $event->participants()->attach($ids);
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

        $participantsStr = $inputs['participants'];

        if ($participantsStr) {
            $participants = Str::of($participantsStr)
                ->split('/,/')
                ->unique()
                ->filter(fn ($participant) => $participant != auth()->user()->email);
            $ids = User::select('id')->whereIn('email', $participants)->get();
            $event->participants()->sync($ids);
        }

        return back();
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return back();
    }
}
