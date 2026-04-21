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
            try {
                if (\Illuminate\Support\Facades\Auth::check() && \Schema::hasTable('appointments')) {
                    $user = \Illuminate\Support\Facades\Auth::user();
                    
                    // Base query: today's appointments that are not completed/cancelled
                    $query = Appointment::whereDate('date', Carbon::today())
                        ->whereIn('status', ['planned', 'in_progress', 'urgent']);

                    // Role-based filtering
                    if ($user->role === 'doctor') {
                        // Filter by doctor_id associated with the user
                        $doctorId = $user->doctor ? $user->doctor->id : \App\Models\Doctor::where('user_id', $user->id)->value('id');
                        if ($doctorId) {
                            $query->where('doctor_id', $doctorId);
                        } else {
                            $query->whereRaw('1 = 0'); // No doctor profile, show 0
                        }
                    } elseif ($user->role === 'admin') {
                        // Admin sees all today's pending/active appointments
                    } else {
                        // Default to 0 for other roles in the sidebar context
                        $query->whereRaw('1 = 0');
                    }

                    $todayAppointmentsCount = $query->count();
                    $view->with('todayAppointmentsCount', $todayAppointmentsCount);
                } else {
                    $view->with('todayAppointmentsCount', 0);
                }
            } catch (\Exception $e) {
                // Ignore errors to allow the app to boot even without DB
                $view->with('todayAppointmentsCount', 0);
            }
        });
    }
}
