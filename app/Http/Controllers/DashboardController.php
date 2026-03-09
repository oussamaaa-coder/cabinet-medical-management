<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Models\Prescription;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get counts for stats cards
        $totalPatients = Patient::count();
        $totalDoctors = User::where('role', 'doctor')->count();
        $totalAppointments = Appointment::count();
        
        // Today's appointments
        $todayAppointments = Appointment::whereDate('date', Carbon::today())->count();
        
        // This week's appointments
        $weekAppointments = Appointment::whereBetween('date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        
        // Monthly appointments
        $monthAppointments = Appointment::whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->count();
        
        // Recent appointments (last 5)
        $recentAppointments = Appointment::with('patient')
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->limit(5)
            ->get();
        
        // Upcoming appointments for today
        $upcomingToday = Appointment::with('patient')
            ->whereDate('date', Carbon::today())
            ->where('start_time', '>=', Carbon::now()->format('H:i:s'))
            ->orderBy('start_time')
            ->limit(5)
            ->get();
        
        // Appointments by status
        $appointmentsByStatus = Appointment::select('status')
            ->get()
            ->groupBy('status')
            ->map(function ($items) {
                return $items->count();
            });
        
        // Appointments for the last 7 days
        $last7DaysAppointments = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $count = Appointment::whereDate('date', $date)->count();
            $last7DaysAppointments[] = [
                'date' => $date->format('d/m'),
                'count' => $count
            ];
        }
        
        // User role distribution
        $usersByRole = User::select('role')
            ->get()
            ->groupBy('role')
            ->map(function ($items) {
                return $items->count();
            });
        
        // Completed appointments this month
        $completedThisMonth = Appointment::whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->where('status', 'completed')
            ->count();
            
        // Calculate completion rate
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

