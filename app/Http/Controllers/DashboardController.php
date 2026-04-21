<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Prescription;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $appointmentBaseQuery = Appointment::query();
        $patientBaseQuery = Patient::query();
        $doctorBaseQuery = Doctor::query();

        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role === 'doctor') {
            $doctorId = \App\Models\Doctor::where('user_id', \Illuminate\Support\Facades\Auth::id())->value('id');
            if ($doctorId) {
                $appointmentBaseQuery->where('doctor_id', $doctorId);
                $patientBaseQuery->whereHas('appointments', function($q) use ($doctorId) {
                    $q->where('doctor_id', $doctorId);
                });
                $doctorBaseQuery->where('id', $doctorId);
            }
        }

        // Get counts for stats cards
        $totalPatients = (clone $patientBaseQuery)->count();
        $totalDoctors = (clone $doctorBaseQuery)->count();
        $totalAppointments = (clone $appointmentBaseQuery)->count();
        
        // Today's appointments
        $todayAppointments = (clone $appointmentBaseQuery)->whereDate('date', Carbon::today())->count();
        
        // This week's appointments
        $weekAppointments = (clone $appointmentBaseQuery)->whereBetween('date', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ])->count();
        
        // Monthly appointments
        $monthAppointments = (clone $appointmentBaseQuery)->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->count();
        
        // Recent appointments (last 5)
        $recentAppointments = (clone $appointmentBaseQuery)->with(['patient', 'doctor'])
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->limit(5)
            ->get();
        
        // Upcoming appointments for today (Show all today)
        $upcomingToday = (clone $appointmentBaseQuery)->with(['patient', 'doctor'])
            ->whereDate('date', Carbon::today())
            ->orderBy('start_time')
            ->limit(10)
            ->get();
        
        // Appointments by status
        $appointmentsByStatus = (clone $appointmentBaseQuery)->select('status')
            ->get()
            ->groupBy('status')
            ->map(function ($items) {
                return $items->count();
            });
        
        // Appointments for the last 7 days
        $last7DaysAppointments = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $count = (clone $appointmentBaseQuery)->whereDate('date', $date)->count();
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
        $completedThisMonth = (clone $appointmentBaseQuery)->whereMonth('date', Carbon::now()->month)
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

