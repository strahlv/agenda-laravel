<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SessionController extends Controller
{
    public function create()
    {
        return view('users.login');
    }

    public function store(Request $request)
    {
        $inputs = $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $inputs['email'])->first();

        if (Hash::check($inputs['password'], $user->password)) {
            auth()->login($user);
            return redirect('/month/' . Carbon::today()->format('Y/n/j'))->with('success', 'Usuário logado com sucesso.');
        }

        return redirect('/login');
    }

    public function destroy()
    {
        auth()->logout();
        return redirect('/month/' . Carbon::today()->format('Y/n/j'))->with('success', 'Usuário deslogado com sucesso.');
    }
}
