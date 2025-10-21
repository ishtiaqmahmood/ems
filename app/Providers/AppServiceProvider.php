<?php

namespace App\Providers;

use App\Models\Calendar;
use App\Policies\CalendarPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;

class AppServiceProvider extends AuthServiceProvider
{
    /**
     * Register any application services.
     */
    protected $policies = [
        Calendar::class => CalendarPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}