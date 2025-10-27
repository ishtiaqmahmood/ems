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
            'password' => ['required'],
        ]);

        $remember = $request->filled('remember');

        if (!Auth::attempt($attributes, $remember)) {
            throw ValidationException::withMessages([
                'email' => "Sorry, those credentials do not match."
            ]);
        }

        // Regenerate session after login
        $request->session()->regenerate();

        // Get the authenticated user
        $user = Auth::user();

        // Redirect based on role
        if ($user->role === 'Admin') {
            return redirect('/admin')->with('success', 'Welcome back, Admin!');
        }

        // Default for Viewer
        return redirect('/')->with('success', 'Welcome back!');
    }

    public function destroy()
    {
        Auth::logout();
        return redirect('/login');
    }
}
