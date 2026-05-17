<?php

namespace App\Providers;

use App\Models\Calendar;
use App\Policies\CalendarPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::policy(Calendar::class, CalendarPolicy::class);

        // Custom HRM Gates
        Gate::define('manage-leaves', function ($user) {
            return in_array($user->role, ['Admin', 'HR']);
        });
    }
}
