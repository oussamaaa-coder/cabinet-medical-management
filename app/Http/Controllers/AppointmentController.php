<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        $doctors = \App\Models\Doctor::all();
        return view('agenda.index', compact('patients', 'doctors'));
    }

    public function getAppointments(Request $request)
    {
        $date = $request->query('date', Carbon::today()->toDateString());

        $appointments = Appointment::with(['patient', 'doctor'])
            ->whereDate('date', $date)
            ->orderBy('start_time')
            ->get();

        return response()->json($appointments);
    }

    public function getMonthlyStatus(Request $request)
    {
        $month = $request->query('month', Carbon::now()->month);
        $year = $request->query('year', Carbon::now()->year);

        $appointments = Appointment::select('date')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get()
            ->groupBy('date');

        $status = $appointments->map(function ($dayAppointments) {
            return true; // Simple indicator for now
        });

        return response()->json($status);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'type' => 'required|string',
            'status' => 'required|in:planned,urgent',
            'notes' => 'nullable|string',
            'sms_reminder' => 'boolean',
            'email_reminder' => 'boolean',
        ]);

        $appointment = Appointment::create($validated);


        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous créé avec succès.',
            'appointment' => $appointment->load('patient')
        ]);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:planned,completed,cancelled,urgent',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous mis à jour.',
            'appointment' => $appointment->load('patient')
        ]);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous annulé.'
        ]);
    }

    public function create()
    {
        $patients = Patient::all();
        return view('appointments.create', compact('patients'));
    }
}
