<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Admin\Photos\ImageController;
use App\Http\Controllers\Attendance\AttendanceController;
use App\Http\Controllers\Salary\SalaryController;
use App\Http\Controllers\Vacation\VacationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Profile\AdminProfileController;
use App\Http\Controllers\Admin\User\UserRoleController;
use App\Http\Controllers\Admin\Organization\OrganizationController;
use App\Http\Controllers\Admin\Department\DepartmentController;
use App\Http\Controllers\Admin\Employer\EmployerController;
use App\Http\Controllers\Admin\Event\EventController;
use App\Http\Controllers\Admin\Admin\AdminController;
use App\Http\Controllers\Admin\Leave\LeaveController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Admin\Leave\LeaveTypeController;
use App\Http\Controllers\Vacation\CasualLeaveFormController;
use App\Http\Controllers\Vacation\DisabilityLeaveFormController;
use App\Http\Controllers\Vacation\EmergencyLeaveFormController;
use App\Http\Controllers\Vacation\LeaveWithoutPayFormController;
use App\Http\Controllers\NotificationController;

Route::middleware(['auth'])->group(function () {
    Route::get('/api/notifications/unread', [NotificationController::class, 'unread']);
    Route::post('/api/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
});

Route::middleware(['auth', 'role:Viewer'])->group(function () {
    // Protected routes go here
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // user profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Documents routes
    // Route::resource('documents', \App\Http\Controllers\DocumentController::class);

    // Photo routes
    // Route::get('/photos', [PhotoController::class, 'index'])->name('photos.index');
    // Route::get('/photos/create', [PhotoController::class, 'create'])->name('photos.create');
    // Route::post('/photos', [PhotoController::class, 'store'])->name('photos.store');
    // Route::get('/photos/{photo}', [PhotoController::class, 'show'])->name('photos.show');
    // Route::delete('/photos/{photo}', [PhotoController::class, 'destroy'])->name('photos.destroy');

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


    // // Salary routes
    // Route::resource('salaries', SalaryController::class)->except(['show']);

    // Vacation routes
    Route::get('/vacations', [VacationController::class, 'index'])->name('vacations.index');
    Route::get('/vacations/create', [VacationController::class, 'create'])->name('vacations.create');
    Route::post('/vacations', [VacationController::class, 'store'])->name('vacations.store');
    Route::get('/vacations/{vacation}', [VacationController::class, 'show'])->name('vacations.show');

    // HR/Admin approval routes
    Route::get('vacations/{vacation}/edit', [VacationController::class, 'edit'])->name('vacations.edit');
    Route::patch('vacations/{vacation}', [VacationController::class, 'update'])->name('vacations.update');
    Route::delete('vacations/{vacation}', [VacationController::class, 'destroy'])->name('vacations.destroy');
    Route::patch('/vacations/{vacation}/status', [VacationController::class, 'updateStatus'])->name('vacations.updateStatus');
    Route::get('/vacations/casual/create', [CasualLeaveFormController::class, 'create'])
        ->name('vacations.casual.create');
    Route::post('/vacations/casual', [CasualLeaveFormController::class, 'store'])
        ->name('vacations.casual.store');
    Route::get('/vacations/emergency/create', [EmergencyLeaveFormController::class, 'create'])
        ->name('vacations.emergency.create');
    Route::post('/vacations/emergency', [EmergencyLeaveFormController::class, 'store'])
        ->name('vacations.emergency.store');
    Route::get('/vacations/leave-without-pay/create', [LeaveWithoutPayFormController::class, 'create'])
        ->name('vacations.leave_without_pay.create');
    Route::post('/vacations/leave-without-pay', [LeaveWithoutPayFormController::class, 'store'])
        ->name('vacations.leave_without_pay.store');
    Route::get('/vacations/disability/create', [DisabilityLeaveFormController::class, 'create'])
        ->name('vacations.disability.create');
    Route::post('/vacations/disability', [DisabilityLeaveFormController::class, 'store'])
        ->name('vacations.disability.store');
});

Route::middleware(['auth', 'role:Admin'])->group(function () {
    // Protected routes go here

    Route::get('/admin', [AdminController::class, 'index'])->name('adminhome');

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

    // documents management routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('documents', App\Http\Controllers\Admin\Documents\DocumentController::class);
    });
    Route::get('admin/documents/{document}', [App\Http\Controllers\Admin\Documents\DocumentController::class, 'show'])
        ->name('admin.documents.show');

    // photos management routes
    Route::prefix('admin/photos')->name('admin.photos.')->group(function () {
        Route::get('/', [ImageController::class, 'index'])->name('index');
        Route::get('/create', [ImageController::class, 'create'])->name('create');
        Route::post('/store', [ImageController::class, 'store'])->name('store');

        Route::get('/{photo}', [ImageController::class, 'show'])->name('show');
        Route::get('/{photo}/edit', [ImageController::class, 'edit'])->name('edit');
        Route::put('/{photo}/update', [ImageController::class, 'update'])->name('update');

        Route::delete('/{photo}/delete', [ImageController::class, 'destroy'])->name('destroy');
    });

    // Calendar management routes
    Route::prefix('admin/calendar')->name('admin.calendar.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\Calendar\CalendarController::class, 'index'])->name('index');
    });

    // Event management routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('events', EventController::class);
    });

    // Salary management routes
    Route::prefix('admin')->name('admin.')->group(function () {

        // Salary Grade CRUD
        Route::resource('salary-grades', \App\Http\Controllers\Admin\Salary\SalaryGradeController::class);

        // Employer Salary CRUD (nested)
        Route::prefix('employers/{employer}')->group(function () {
            Route::get('salaries', [\App\Http\Controllers\Admin\Salary\EmployerSalaryController::class, 'index'])
                ->name('salaries.index');

            Route::get('salaries/create', [\App\Http\Controllers\Admin\Salary\EmployerSalaryController::class, 'create'])
                ->name('salaries.create');

            Route::post('salaries', [\App\Http\Controllers\Admin\Salary\EmployerSalaryController::class, 'store'])
                ->name('salaries.store');

            Route::get('/salaries/{salary}/edit', [\App\Http\Controllers\Admin\Salary\EmployerSalaryController::class, 'edit'])
                ->name('salaries.edit');

            Route::put('/salaries/{salary}', [\App\Http\Controllers\Admin\Salary\EmployerSalaryController::class, 'update'])
                ->name('salaries.update');

            Route::delete('salaries/{salary}', [\App\Http\Controllers\Admin\Salary\EmployerSalaryController::class, 'destroy'])
                ->name('salaries.destroy');
        });

        // Optional: API route to fetch grade JSON
        Route::get('salary/grade/{grade}/json', function ($grade) {
            return \App\Models\SalaryGrade::findOrFail($grade);
        });
    });

    Route::get('admin/salaries', [\App\Http\Controllers\Admin\Salary\EmployerSalaryController::class, 'all'])
        ->name('admin.salaries.all');


    // Admin Leave Management
    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves.index');

        Route::get('/leaves/{id}', [LeaveController::class, 'show'])->name('leaves.show');

        Route::put('/leaves/{id}', [LeaveController::class, 'update'])->name('leaves.update');

        Route::delete('/leaves/{id}', [LeaveController::class, 'destroy'])->name('leaves.destroy');

        Route::resource('leave-types', LeaveTypeController::class);
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
