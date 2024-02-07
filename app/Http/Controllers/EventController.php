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
        // return Event::where('user_id', $userId)->get();
    }

    public function store(int $userId, Request $request)
    {
        // ddd($request);
        // ddd($request->all());
        // ddd($request->input('title'));
        // ddd($request->input());
        $inputs = $request->input();

        Event::create([
            'title' => $inputs['title'],
            'date' => $inputs['date'],
            'user_id' => $userId
        ]);

        return redirect('/');
    }
}
