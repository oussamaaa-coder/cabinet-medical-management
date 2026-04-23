<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    /**
     * Resolve the doctor_id to filter by for the authenticated user.
     * Returns the doctor record if the user is a doctor, or null for admin.
     */
    private function getAuthDoctor(): ?Doctor
    {
        $user = Auth::user();
        if ($user && $user->role === 'doctor') {
            return Doctor::where('user_id', $user->id)->first();
        }
        return null;
    }

    public function index()
    {
        $patients = Patient::all();
        $authDoctor = $this->getAuthDoctor();

        if ($authDoctor) {
            // Doctor: only show their own profile in the dropdown
            $doctors = Doctor::where('id', $authDoctor->id)->get();
            $nurses  = \App\Models\User::where('role', 'nurse')
                ->where(function ($q) use ($authDoctor) {
                    $q->where('doctor_id', $authDoctor->id)
                      ->orWhereNull('doctor_id');
                })->get();
        } else {
            $doctors = Doctor::all();
            $nurses  = \App\Models\User::where('role', 'nurse')->get();
        }

        return view('agenda.index', compact('patients', 'doctors', 'nurses'));
    }

    public function getAppointments(Request $request)
    {
        $date  = $request->query('date', Carbon::today()->toDateString());
        $query = Appointment::with(['patient', 'doctor'])
            ->whereDate('date', $date)
            ->orderBy('start_time');

        $authDoctor = $this->getAuthDoctor();
        if ($authDoctor) {
            $query->where('doctor_id', $authDoctor->id);
        } elseif (Auth::user()->role === 'doctor') {
            // SECURITY: Doctor role but NO linked Doctor record → show nothing
            $query->whereRaw('0 = 1');
        }

        return response()->json($query->get());
    }

    public function getMonthlyStatus(Request $request)
    {
        $month = $request->query('month', Carbon::now()->month);
        $year  = $request->query('year',  Carbon::now()->year);

        $query = Appointment::select('date')
            ->whereMonth('date', $month)
            ->whereYear('date',  $year);

        $authDoctor = $this->getAuthDoctor();
        if ($authDoctor) {
            $query->where('doctor_id', $authDoctor->id);
        } elseif (Auth::check() && Auth::user()->role === 'doctor') {
            // SECURITY: Doctor role but NO linked Doctor record → show nothing
            $query->whereRaw('0 = 1');
        }

        $status = $query->get()->groupBy('date')->map(fn() => true);

        return response()->json($status);
    }

    public function store(Request $request)
    {
        $user       = Auth::user();
        $isDoctor   = $user && $user->role === 'doctor';
        $authDoctor = $isDoctor ? $this->getAuthDoctor() : null;

        // If the authenticated user is a doctor but has no linked Doctor record, reject early
        if ($isDoctor && !$authDoctor) {
            $msg = 'Aucun profil médecin trouvé pour votre compte.';
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => $msg], 422)
                : back()->withInput()->with('error', $msg);
        }

        // Build validation rules — admin must supply doctor_id, doctor gets it auto-assigned
        $rules = [
            'patient_id'     => 'required|exists:patients,id',
            'date'           => 'required|date|after_or_equal:today',
            'start_time'     => 'required',
            'end_time'       => 'nullable',
            'type'           => 'nullable|string',
            'status'         => 'nullable|in:planned,urgent',
            'notes'          => 'nullable|string',
            'sms_reminder'   => 'boolean',
            'email_reminder' => 'boolean',
        ];

        if (!$isDoctor) {
            $rules['doctor_id'] = 'required|exists:doctors,id';
        }

        $messages = [
            'date.after_or_equal' => 'Impossible de prendre un rendez-vous pour une date passée.',
        ];

        $validated = $request->validate($rules, $messages);

        // Override doctor_id for doctor users
        if ($isDoctor) {
            $validated['doctor_id'] = $authDoctor->id;
        }

        // Defaults
        if (empty($validated['end_time'])) {
            $validated['end_time'] = Carbon::parse($validated['start_time'])->addMinutes(30)->format('H:i');
        }
        $validated['type']   = $validated['type']   ?? 'Consultation';
        $validated['status'] = $validated['status'] ?? 'planned';

        // Conflict check: doctor
        $doctorConflict = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('date', $validated['date'])
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) use ($validated) {
                $q->where('start_time', '<', $validated['end_time'])
                  ->where('end_time',   '>', $validated['start_time']);
            })->exists();

        if ($doctorConflict) {
            $msg = 'Le médecin a déjà un rendez-vous sur ce créneau horaire.';
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => $msg], 422)
                : back()->withInput()->with('error', $msg);
        }

        // Conflict check: patient
        $patientConflict = Appointment::where('patient_id', $validated['patient_id'])
            ->where('date', $validated['date'])
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) use ($validated) {
                $q->where('start_time', '<', $validated['end_time'])
                  ->where('end_time',   '>', $validated['start_time']);
            })->exists();

        if ($patientConflict) {
            $msg = 'Le patient a déjà un rendez-vous sur ce créneau horaire.';
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => $msg], 422)
                : back()->withInput()->with('error', $msg);
        }

        $appointment = Appointment::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success'     => true,
                'message'     => 'Rendez-vous créé avec succès.',
                'appointment' => $appointment->load('patient'),
            ]);
        }

        return redirect()->route('agenda.index')->with('success', 'Rendez-vous créé avec succès.');
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status'   => 'required|in:planned,completed,cancelled,urgent',
            'notes'    => 'nullable|string',
            'nurse_id' => 'nullable|exists:users,id',
        ]);

        if ($validated['status'] !== 'completed') {
            $validated['nurse_id'] = null;
        }

        $appointment->update($validated);

        return response()->json([
            'success'     => true,
            'message'     => 'Rendez-vous mis à jour.',
            'appointment' => $appointment->load('patient'),
        ]);
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rendez-vous annulé.',
        ]);
    }

    public function create()
    {
        $patients    = Patient::all();
        $authDoctor  = $this->getAuthDoctor();
        $doctors     = $authDoctor
            ? Doctor::where('id', $authDoctor->id)->get()
            : Doctor::all();

        return view('appointments.create', compact('patients', 'doctors'));
    }
}
