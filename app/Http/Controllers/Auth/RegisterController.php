<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth/register');
    }

    public function store(Request $request)
    {
        $userAttributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                Password::min(6)
                    ->letters()    // at least one letter
                    ->numbers()    // at least one number
                    ->symbols()    // at least one symbol
            ],
        ]);

        $userAttributes['password'] = Hash::make($userAttributes['password']);

        $user = User::create($userAttributes);

        Auth::login($user);
        $user->sendEmailVerificationNotification();

        return redirect()->route('verification.notice');
    }
}