<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(Request $request)
    {
        $body = $request->all();

        $notifications = User::findOrFail(auth()->id())
            ->unreadNotifications
            ->whereIn('id', $body['ids']);

        $notifications->markAsRead();

        return response()->json($body);
    }
}
