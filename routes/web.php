<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

Route::middleware(['auth', 'verified'])->group(function () {
    // Protected routes go here
    Route::get('/', function () {
        return view('index');
    })->name('home');
    // user profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Logout route
    Route::delete('/logout', [SessionController::class, 'destroy']);
});


Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);




// Show the request form
Route::get('/forgot-password', [PasswordResetController::class, 'request'])->name('password.request');

// Handle sending reset link
Route::post('/forgot-password', [PasswordResetController::class, 'email'])->name('password.email');

// Show the reset password form
Route::get('/reset-password/{token}', [PasswordResetController::class, 'reset'])->name('password.reset');

// Handle resetting password
Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');

// Email verification notice
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Email verification link
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/')->with('success', 'Email verified successfully!');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Resend verification email
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
