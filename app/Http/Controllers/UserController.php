<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function edit()
    {
        return view('users.edit');
    }

    public function update(Request $request)
    {
        $inputs = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $inputs = array_filter($inputs, function ($input) {
            return $input != null;
        });

        $user = User::find(auth()->id());
        $user->update($inputs);

        return back()->with('success', 'Dados alterados com sucesso.');
    }
}
