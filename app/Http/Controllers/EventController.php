<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(int $userId)
    {
        return User::find($userId)->events;
    }

    public function store(int $userId, Request $request)
    {
        $inputs = $request->validate([
            'title' => 'required|max:255',
            'date' => 'required'
        ]);

        Event::create([
            'title' => $inputs['title'],
            'date' => $inputs['date'],
            'user_id' => $userId
        ]);

        return back();
    }

    public function update(int $id, Request $request)
    {
        $inputs = $request->validate([
            'title' => 'required|max:255',
            'date' => 'required'
        ]);

        Event::findOrFail($id)->update([
            'title' => $inputs['title'],
            'date' => $inputs['date']
        ]);

        return back();
    }

    public function destroy(int $id)
    {
        Event::destroy($id);
        return back();
    }
}
