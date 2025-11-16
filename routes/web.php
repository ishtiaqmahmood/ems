<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\Attendance\AttendanceController;
use App\Http\Controllers\Salary\SalaryController;
use App\Http\Controllers\Vacation\VacationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\admin\profile\AdminProfileController;
use App\Http\Controllers\admin\User\UserRoleController;
use App\Http\Controllers\admin\Organization\OrganizationController;
use App\Http\Controllers\admin\Department\DepartmentController;
use App\Http\Controllers\admin\Employer\EmployerController;

Route::middleware(['auth', 'verified', 'role:Viewer'])->group(function () {
    // Protected routes go here
    Route::get('/', function () {
        return view('index');
    })->name('home');

    // user profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Documents routes
    Route::resource('documents', \App\Http\Controllers\DocumentController::class);

    // Photo routes
    Route::get('/photos', [PhotoController::class, 'index'])->name('photos.index');
    Route::get('/photos/create', [PhotoController::class, 'create'])->name('photos.create');
    Route::post('/photos', [PhotoController::class, 'store'])->name('photos.store');
    Route::get('/photos/{photo}', [PhotoController::class, 'show'])->name('photos.show');
    Route::delete('/photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');

    // Calendar routes
    Route::get('calendar/{year?}/{month?}', [CalendarController::class, 'index'])->name('calendar.index');
    Route::post('calendar/events', [CalendarController::class, 'store'])->name('calendar.events.store');
    Route::patch('calendar/events/{event}', [CalendarController::class, 'update'])->name('calendar.events.update');
    Route::delete('calendar/events/{event}', [CalendarController::class, 'destroy'])->name('calendar.events.destroy');

    // Attendance routes
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/{attendance}', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::get('/attendance/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
    Route::put('/attendance/{attendance}', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::patch('/attendance/{attendance}', [AttendanceController::class, 'update']);
    Route::delete('/attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');
    Route::get('/attendance/export/pdf', [AttendanceController::class, 'exportPdf'])->name('attendance.export.pdf');


    // Salary routes
    Route::resource('salaries', SalaryController::class)->except(['show']);

    // Vacation routes
    Route::get('/vacations', [VacationController::class, 'index'])->name('vacations.index');
    Route::get('/vacations/create', [VacationController::class, 'create'])->name('vacations.create');
    Route::post('/vacations', [VacationController::class, 'store'])->name('vacations.store');

    // HR/Admin approval routes

    Route::patch('/vacations/{vacation}/status', [VacationController::class, 'updateStatus'])->name('vacations.updateStatus');

    Route::get('/vacations/summary', [VacationController::class, 'summary'])->name('vacations.summary');
    Route::get('/vacations/summary/admin', [VacationController::class, 'adminSummary'])->name('vacations.adminSummary');
});

Route::middleware(['auth', 'verified', 'role:Admin'])->group(function () {
    // Protected routes go here
    Route::get('/admin', function () {
        return view('adminindex');
    })->name('adminhome');

    // admin profile routes
    Route::get('admin/profile', [AdminProfileController::class, 'show'])->name('admin.profile.show');
    Route::get('admin/profile/edit', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::post('admin/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('admin/profile/change-password', [AdminProfileController::class, 'changePassword'])->name('admin.profile.change_password');
    Route::post('admin/profile/change-password', [AdminProfileController::class, 'updatePassword'])->name('admin.profile.update_password');

    // User role management routes
    Route::get('admin/users', [UserRoleController::class, 'index'])->name('admin.users.index');
    Route::get('admin/users/{id}/edit', [UserRoleController::class, 'edit'])->name('admin.users.edit');
    Route::put('admin/users/{id}', [UserRoleController::class, 'update'])->name('admin.users.update');
    Route::delete('admin/users/{user}', [UserRoleController::class, 'destroy'])->name('admin.users.destroy');

    // User list
    Route::get('admin/users/list', [UserRoleController::class, 'list'])->name('admin.users.list');

    // Organization management routes
    Route::prefix('admin')->name('admin.')->group(function () {
        // Resource routes for organizations
        Route::resource('organizations', OrganizationController::class);

        // Remove a specific image
        Route::delete('organizations/{organization}/remove-image/{index}', [OrganizationController::class, 'removeImage'])
            ->name('organizations.removeImage');
    });

    // Department management routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('departments', DepartmentController::class);
    });
    Route::post('admin/departments/sort', [DepartmentController::class, 'sort'])->name('admin.departments.sort');

    // section management routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('sections', App\Http\Controllers\Admin\Section\SectionController::class);
        Route::get('departments/by-organization/{id}', function ($id) {
            return \App\Models\Department::where('organization_id', $id)->get();
        });
    });
    Route::get('/admin/sections/{section}', [App\Http\Controllers\Admin\Section\SectionController::class, 'show'])
        ->name('admin.sections.show');

    // employee management routes

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('employers', EmployerController::class);
    });
});

// Logout route
Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');

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
