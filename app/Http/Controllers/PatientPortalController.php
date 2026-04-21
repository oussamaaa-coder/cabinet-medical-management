<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PatientPortalController extends Controller
{
    /**
     * Retrieve the authenticated user's linked patient record.
     */
    private function getPatient(): ?Patient
    {
        $patient = Patient::where('user_id', Auth::id())->first();

        // Auto-heal: If user has 'patient' role but no Patient record, create one.
        if (!$patient && Auth::check() && Auth::user()->role === 'patient') {
            $nameParts = explode(' ', Auth::user()->name, 2);
            $patient = Patient::create([
                'user_id'    => Auth::id(),
                'first_name' => $nameParts[0],
                'last_name'  => $nameParts[1] ?? '',
                'email'      => Auth::user()->email,
                'phone'      => Auth::user()->phone,
            ]);
        }

        return $patient;
    }

    // ── Dashboard ──────────────────────────────────────────────
    public function dashboard()
    {
        $patient = $this->getPatient();

        if (!$patient) {
            return view('patient.dashboard', [
                'patient'         => null,
                'nextAppointment' => null,
                'upcomingCount'   => 0,
                'prescriptions'   => collect(),
                'appointments'    => collect(),
            ]);
        }

        $now             = Carbon::now();
        $nextAppointment = Appointment::with('doctor')
            ->where('patient_id', $patient->id)
            ->where('date', '>=', $now->toDateString())
            ->whereIn('status', ['planned', 'urgent'])
            ->orderBy('date')
            ->orderBy('start_time')
            ->first();

        $upcomingCount = Appointment::where('patient_id', $patient->id)
            ->where('date', '>=', $now->toDateString())
            ->whereIn('status', ['planned', 'urgent'])
            ->count();

        $prescriptions = Prescription::with(['doctor', 'items'])
            ->where('patient_id', $patient->id)
            ->orderByDesc('prescription_date')
            ->take(3)
            ->get();

        return view('patient.dashboard', compact(
            'patient',
            'nextAppointment',
            'upcomingCount',
            'prescriptions'
        ));
    }

    // ── Mes Rendez-vous ────────────────────────────────────────
    public function appointments()
    {
        $patient = $this->getPatient();

        if (!$patient) {
            return view('patient.appointments', ['appointments' => collect(), 'patient' => null]);
        }

        $appointments = Appointment::with('doctor')
            ->where('patient_id', $patient->id)
            ->orderByDesc('date')
            ->orderByDesc('start_time')
            ->paginate(10);

        return view('patient.appointments', compact('appointments', 'patient'));
    }

    // ── Prise de Rendez-vous ───────────────────────────────────
    public function createAppointment()
    {
        $doctors = Doctor::all();
        $patient = $this->getPatient();

        return view('patient.book_appointment', compact('doctors', 'patient'));
    }

    public function storeAppointment(Request $request)
    {
        $patient = $this->getPatient();

        if (!$patient) {
            return redirect()->route('patient.dashboard')
                ->with('error', 'Aucun dossier patient associé à votre compte.');
        }

        $validated = $request->validate([
            'doctor_id'  => 'required|exists:doctors,id',
            'date'       => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time'   => 'required|after:start_time',
            'type'       => 'required|string',
            'notes'      => 'nullable|string|max:500',
        ]);

        // Check for doctor conflict
        $conflict = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('date', $validated['date'])
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) use ($validated) {
                $q->where('start_time', '<', $validated['end_time'])
                  ->where('end_time', '>', $validated['start_time']);
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors([
                'start_time' => 'Ce médecin est déjà occupé sur ce créneau horaire.'
            ])->withInput();
        }

        // Check for patient conflict
        $patientConflict = Appointment::where('patient_id', $patient->id)
            ->where('date', $validated['date'])
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) use ($validated) {
                $q->where('start_time', '<', $validated['end_time'])
                  ->where('end_time', '>', $validated['start_time']);
            })
            ->exists();

        if ($patientConflict) {
            return back()->withErrors([
                'start_time' => 'Vous avez déjà un rendez-vous prévu sur ce créneau horaire.'
            ])->withInput();
        }

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id'  => $validated['doctor_id'],
            'date'       => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time'   => $validated['end_time'],
            'type'       => $validated['type'],
            'status'     => 'planned',
            'notes'      => $validated['notes'] ?? null,
        ]);

        return redirect()->route('patient.appointments')
            ->with('success', 'Votre rendez-vous a été pris avec succès !');
    }

    public function cancelAppointment(Appointment $appointment)
    {
        $patient = $this->getPatient();

        // Ensure the appointment belongs to this patient
        if (!$patient || $appointment->patient_id !== $patient->id) {
            abort(403);
        }

        $appointment->update(['status' => 'cancelled']);

        return redirect()->route('patient.appointments')
            ->with('success', 'Rendez-vous annulé.');
    }

    // ── Mes Ordonnances ────────────────────────────────────────
    public function prescriptions()
    {
        $patient = $this->getPatient();

        if (!$patient) {
            return view('patient.prescriptions', ['prescriptions' => collect(), 'patient' => null]);
        }

        $prescriptions = Prescription::with(['doctor', 'items'])
            ->where('patient_id', $patient->id)
            ->orderByDesc('prescription_date')
            ->paginate(10);

        return view('patient.prescriptions', compact('prescriptions', 'patient'));
    }

    public function showPrescription(Prescription $prescription)
    {
        $patient = $this->getPatient();

        if (!$patient || $prescription->patient_id !== $patient->id) {
            abort(403);
        }

        $prescription->load(['doctor', 'items', 'patient']);

        return view('patient.prescription_detail', compact('prescription', 'patient'));
    }

    // ── Mon Dossier ────────────────────────────────────────────
    public function dossier()
    {
        $patient = $this->getPatient();

        return view('patient.dossier', compact('patient'));
    }
}
