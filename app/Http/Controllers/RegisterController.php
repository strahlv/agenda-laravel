<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function create()
    {
        return view('users.register');
    }

    public function store(Request $request)
    {
        $inputs = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create($inputs);
        $user->settings()->create();

        auth()->login($user);

        // session()->flash('success', 'Usuário cadastrado com sucesso.');

        // Mail::to($user)->send(new WelcomeMail($user));

        return redirect('/')->with('success', 'Usuário cadastrado com sucesso.');
    }
}
