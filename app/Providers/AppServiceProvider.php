<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Appointment;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::useBootstrapFive();
        
        // Share today's appointment count with all views
        View::composer('*', function ($view) {
            $todayAppointmentsCount = Appointment::whereDate('date', Carbon::today())->count();
            View::share('todayAppointmentsCount', $todayAppointmentsCount);
        });
    }
}
