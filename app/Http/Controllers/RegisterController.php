<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function create()
    {
        return view('users.register');
    }

    public function store(Request $request)
    {
        $inputs = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:8|max:255',
        ]);

        $user = User::create($inputs);

        auth()->login($user);

        // session()->flash('success', 'Usuário cadastrado com sucesso.');

        return redirect('/month/' . Carbon::today()->format('Y/n/j'))->with('success', 'Usuário cadastrado com sucesso.');
    }
}
