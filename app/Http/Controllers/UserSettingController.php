<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserSettingController extends Controller
{
    public function update(Request $request)
    {
        User::findOrFail(auth()->id())->settings->update($request->except(['_token', '_method']));
        return back();
    }
}
