<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Appointment;
use App\Models\Doctor;
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

        /**
         * Share the role-scoped "today's appointment count" with every view.
         * → Doctor : only THEIR appointments today
         * → Admin  : ALL appointments today
         * → Others : 0
         */
        View::composer('*', function ($view) {
            try {
                if (!Auth::check() || !Schema::hasTable('appointments')) {
                    $view->with('todayAppointmentsCount', 0);
                    return;
                }

                $user  = Auth::user();
                $query = Appointment::query();

                if ($user->role === 'doctor') {
                    // Resolve the Doctor record linked to this user
                    $doctorId = Doctor::where('user_id', $user->id)->value('id');

                    if ($doctorId) {
                        $query->where('doctor_id', $doctorId);
                    } else {
                        // No linked doctor profile → show 0
                        $view->with('todayAppointmentsCount', 0);
                        return;
                    }
                } elseif ($user->role === 'patient') {
                    // Resolve the Patient record linked to this user
                    $patientId = \App\Models\Patient::where('user_id', $user->id)->value('id');

                    if ($patientId) {
                        $query->where('patient_id', $patientId);
                    } else {
                        $view->with('todayAppointmentsCount', 0);
                        return;
                    }
                } elseif ($user->role !== 'admin') {
                    // Any other role (secretary, nurse…) gets 0
                    $view->with('todayAppointmentsCount', 0);
                    return;
                }

                $view->with('todayAppointmentsCount', $query->count());

            } catch (\Exception $e) {
                // DB not ready yet (migrations, tests, etc.)
                $view->with('todayAppointmentsCount', 0);
            }
        });
    }
}
