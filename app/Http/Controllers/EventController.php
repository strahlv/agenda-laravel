<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(int $userId)
    {
        return User::find($userId)->events;
    }

    public function store(int $userId, EventRequest $request)
    {
        $inputs = $request->validated();

        if (array_key_exists('is_all_day', $inputs)) {
            $inputs['start_time'] = '00:00:00';
            $inputs['end_time'] = '23:59:59';
        } else {
            $inputs['end_date'] = $inputs['start_date'];
        }

        Event::create([
            'title' => $inputs['title'],
            'start_date' => $inputs['start_date'] . " " . $inputs['start_time'],
            'end_date' => $inputs['end_date'] . " " . $inputs['end_time'],
            'user_id' => $userId
        ]);

        return back();
    }

    public function update(int $id, EventRequest $request)
    {
        $inputs = $request->validated();

        if (array_key_exists('is_all_day', $inputs)) {
            $inputs['start_time'] = '00:00:00';
            $inputs['end_time'] = '23:59:59';
        } else {
            $inputs['end_date'] = $inputs['start_date'];
        }

        Event::findOrFail($id)->update([
            'title' => $inputs['title'],
            'start_date' => $inputs['start_date'] . " " . $inputs['start_time'],
            'end_date' => $inputs['end_date'] . " " . $inputs['end_time'],
        ]);

        return back();
    }

    public function destroy(int $id)
    {
        Event::destroy($id);
        return back();
    }
}
