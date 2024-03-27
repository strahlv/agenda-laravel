<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('users.login');
    }

    public function store(Request $request)
    {
        $inputs = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (!auth()->attempt($inputs)) {
            throw ValidationException::withMessages([
                'password' => 'As credenciais que você inseriu estão incorretas.'
            ]);

            // return back()
            //     ->withInput()
            //     ->withErrors(['password' => 'As credenciais que você inseriu estão incorretas.']);
        }

        // session fixation
        // session()->invalidate();
        session()->regenerate();

        return redirect('/')->with('success', 'Usuário logado com sucesso.');
    }

    public function destroy()
    {
        auth()->logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect('/login')->with('success', 'Usuário deslogado com sucesso.');
    }
}
