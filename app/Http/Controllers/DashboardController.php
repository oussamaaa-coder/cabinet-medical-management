<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user     = Auth::user();
        $isDoctor = $user && $user->role === 'doctor';
        $doctorId = null;

        // Resolve the linked Doctor record for this user
        if ($isDoctor) {
            $doctorId = Doctor::where('user_id', $user->id)->value('id');
        }

        /**
         * Helper: returns a fresh Appointment query scoped to the current role.
         *  - Admin  → all appointments
         *  - Doctor → only their appointments (or impossible query if no Doctor record)
         */
        $getApptQuery = function () use ($isDoctor, $doctorId) {
            $q = Appointment::query();
            if ($isDoctor) {
                // SECURITY: if role=doctor but no Doctor record, show nothing
                $doctorId
                    ? $q->where('doctor_id', $doctorId)
                    : $q->whereRaw('0 = 1');
            }
            return $q;
        };

        /**
         * Helper: returns a fresh Patient query scoped to the current role.
         *  - Admin  → all patients
         *  - Doctor → only patients who have at least one appointment with this doctor
         */
        $getPatientQuery = function () use ($isDoctor, $doctorId) {
            $q = Patient::query();
            if ($isDoctor) {
                $doctorId
                    ? $q->whereHas('appointments', fn($sub) => $sub->where('doctor_id', $doctorId))
                    : $q->whereRaw('0 = 1');
            }
            return $q;
        };

        // ── Stats ──────────────────────────────────────────────────────────
        $totalPatients     = $getPatientQuery()->count();
        $totalDoctors      = $isDoctor ? 1 : Doctor::count();
        $totalAppointments = $getApptQuery()->count();

        $todayAppointments = $getApptQuery()
            ->whereDate('date', Carbon::today())
            ->count();

        $weekAppointments = $getApptQuery()
            ->whereBetween('date', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek(),
            ])->count();

        $monthAppointments = $getApptQuery()
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date',  Carbon::now()->year)
            ->count();

        // ── Recent & upcoming ──────────────────────────────────────────────
        $recentAppointments = $getApptQuery()
            ->with(['patient', 'doctor'])
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->limit(5)
            ->get();

        $upcomingToday = $getApptQuery()
            ->with(['patient', 'doctor'])
            ->whereDate('date', Carbon::today())
            ->orderBy('start_time')
            ->limit(10)
            ->get();

        // ── Status distribution ────────────────────────────────────────────
        $appointmentsByStatus = $getApptQuery()
            ->select('status')
            ->get()
            ->groupBy('status')
            ->map(fn($items) => $items->count());

        // ── Last 7 days chart data ─────────────────────────────────────────
        $last7DaysAppointments = [];
        for ($i = 6; $i >= 0; $i--) {
            $date                    = Carbon::today()->subDays($i);
            $last7DaysAppointments[] = [
                'date'  => $date->format('d/m'),
                'count' => $getApptQuery()->whereDate('date', $date)->count(),
            ];
        }

        // User role distribution — always global (admin overview chart only)
        $usersByRole = User::select('role')
            ->get()
            ->groupBy('role')
            ->map(fn($items) => $items->count());

        // ── Completion rate ────────────────────────────────────────────────
        $completedThisMonth = $getApptQuery()
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date',  Carbon::now()->year)
            ->where('status', 'completed')
            ->count();

        $completionRate = $monthAppointments > 0
            ? round(($completedThisMonth / $monthAppointments) * 100, 1)
            : 0;

        return view('dashboard', compact(
            'totalPatients',
            'totalDoctors',
            'totalAppointments',
            'todayAppointments',
            'weekAppointments',
            'monthAppointments',
            'recentAppointments',
            'upcomingToday',
            'appointmentsByStatus',
            'last7DaysAppointments',
            'usersByRole',
            'completionRate',
            'completedThisMonth'
        ));
    }
}
