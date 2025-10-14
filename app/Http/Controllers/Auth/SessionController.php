<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth/login');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $remember = $request->filled('remember');

        if (! Auth::attempt($attributes, $remember)) {
            throw ValidationException::withMessages([
                'email' => "Sorry, those credentials do not match."
            ]);
        }

        $request->session()->regenerate();
        return redirect('/')->with('success', 'Welcome back!');;
    }

    public function destroy()
    {
        Auth::logout();
        return redirect('/');
    }
}