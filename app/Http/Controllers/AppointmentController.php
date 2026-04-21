<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role === 'doctor') {
            $doctors = \App\Models\Doctor::where('user_id', \Illuminate\Support\Facades\Auth::id())->get();
            $doctorIds = $doctors->pluck('id')->toArray();
            $nurses = \App\Models\User::where('role', 'nurse')
                ->where(function($q) use ($doctorIds) {
                    $q->whereIn('doctor_id', $doctorIds)
                      ->orWhereNull('doctor_id');
                })->get();
        } else {
            $doctors = \App\Models\Doctor::all();
            $nurses = \App\Models\User::where('role', 'nurse')->get();
        }
        return view('agenda.index', compact('patients', 'doctors', 'nurses'));
    }

    public function getAppointments(Request $request)
    {
        $date = $request->query('date', Carbon::today()->toDateString());

        $query = Appointment::with(['patient', 'doctor'])
            ->whereDate('date', $date)
            ->orderBy('start_time');

        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role === 'doctor') {
            $doctor = \App\Models\Doctor::where('user_id', \Illuminate\Support\Facades\Auth::id())->first();
            if ($doctor) {
                $query->where('doctor_id', $doctor->id);
            }
        }

        $appointments = $query->get();

        return response()->json($appointments);
    }

    public function getMonthlyStatus(Request $request)
    {
        $month = $request->query('month', Carbon::now()->month);
        $year = $request->query('year', Carbon::now()->year);

        $query = Appointment::select('date')
            ->whereMonth('date', $month)
            ->whereYear('date', $year);

        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role === 'doctor') {
            $doctor = \App\Models\Doctor::where('user_id', \Illuminate\Support\Facades\Auth::id())->first();
            if ($doctor) {
                $query->where('doctor_id', $doctor->id);
            }
        }

        $appointments = $query->get()->groupBy('date');

        $status = $appointments->map(function ($dayAppointments) {
            return true; // Simple indicator for now
        });

        return response()->json($status);
    }

    public function store(Request $request)
    {
        $rules = [
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'nullable', // Will be calculated if null
            'type' => 'nullable|string',
            'status' => 'nullable|in:planned,urgent',
            'notes' => 'nullable|string',
            'sms_reminder' => 'boolean',
            'email_reminder' => 'boolean',
        ];

        $messages = [
            'date.after_or_equal' => 'Impossible de prendre un rendez-vous pour une date passée.',
        ];

        if ($request->wantsJson()) {
            $validated = $request->validate($rules, $messages);
        } else {
            $validated = $request->validate($rules, $messages);
        }

        // Defaults
        if (empty($validated['end_time'])) {
            $validated['end_time'] = Carbon::parse($validated['start_time'])->addMinutes(30)->format('H:i');
        }
        $validated['type'] = $validated['type'] ?? 'Consultation';
        $validated['status'] = $validated['status'] ?? 'planned';

        // Check for doctor conflict
        $doctorConflict = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('date', $validated['date'])
            ->where(function ($query) use ($validated) {
                $query->where(function ($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                        ->where('end_time', '>', $validated['start_time']);
                });
            })
            ->exists();

        if ($doctorConflict) {
            $msg = 'Le médecin a déjà un rendez-vous sur ce créneau horaire.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->withInput()->with('error', $msg);
        }

        // Check for patient conflict
        $patientConflict = Appointment::where('patient_id', $validated['patient_id'])
            ->where('date', $validated['date'])
            ->where(function ($query) use ($validated) {
                $query->where(function ($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                        ->where('end_time', '>', $validated['start_time']);
                });
            })
            ->exists();

        if ($patientConflict) {
            $msg = 'Le patient a déjà un rendez-vous sur ce créneau horaire.';
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => $msg], 422);
            }
            return back()->withInput()->with('error', $msg);
        }

        $appointment = Appointment::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Rendez-vous créé avec succès.',
                'appointment' => $appointment->load('patient')
            ]);
        }

        return redirect()->route('agenda.index')->with('success', 'Rendez-vous créé avec succès.');
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => 'required|in:planned,completed,cancelled,urgent',
            'notes' => 'nullable|string',
            'nurse_id' => 'nullable|exists:users,id',
        ]);

        if ($validated['status'] !== 'completed') {
            $validated['nurse_id'] = null;
        }

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
        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role === 'doctor') {
            $doctors = \App\Models\Doctor::where('user_id', \Illuminate\Support\Facades\Auth::id())->get();
        } else {
            $doctors = \App\Models\Doctor::all();
        }
        return view('appointments.create', compact('patients', 'doctors'));
    }
}
