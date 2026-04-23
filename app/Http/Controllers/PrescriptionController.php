<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    public function index()
    {
        $query = Prescription::with('patient', 'doctor')->orderBy('id', 'desc');
        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role === 'doctor') {
            $query->where('doctor_id', \Illuminate\Support\Facades\Auth::id());
        }
        $prescriptions = $query->get();
        return view('prescriptions.index', compact('prescriptions'));
    }

    public function create(Request $request)
    {
        $patients = Patient::all();
        $selectedPatientId = $request->patient_id;
        
        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role === 'admin') {
            $doctors = \App\Models\User::where('role', 'doctor')->get();
        } else {
            $doctors = [\Illuminate\Support\Facades\Auth::user()];
        }
        
        return view('prescriptions.create', compact('patients', 'selectedPatientId', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:users,id',
            'diagnosis' => 'nullable|string',
            'notes' => 'nullable|string',
            'prescription_date' => 'required|date',
            'medicines' => 'required|array|min:1',
            'medicines.*.name' => 'required|string',
            'medicines.*.dosage' => 'required|string',
            'medicines.*.duration' => 'nullable|string',
        ]);

        $doctorId = \Illuminate\Support\Facades\Auth::id();
        if (\Illuminate\Support\Facades\Auth::user()->role === 'admin' && $request->filled('doctor_id')) {
            $doctorId = $request->doctor_id;
        }

        $prescription = Prescription::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $doctorId,
            'diagnosis' => $request->diagnosis,
            'notes' => $request->notes,
            'prescription_date' => $request->prescription_date,
        ]);

        foreach ($request->medicines as $item) {
            $prescription->items()->create([
                'medicine_name' => $item['name'],
                'dosage' => $item['dosage'],
                'duration' => $item['duration'],
            ]);
        }

        return redirect()->route('prescriptions.show', $prescription->id)
            ->with('success', 'Ordonnance générée avec succès.');
    }

    public function show($id)
    {
        $prescription = Prescription::with('patient', 'doctor', 'items')->findOrFail($id);

        if (Auth::user()->role === 'doctor' && $prescription->doctor_id !== Auth::id()) {
            return redirect()->route('prescriptions.index')->with('error', 'Accès non autorisé.');
        }

        return view('prescriptions.show', compact('prescription'));
    }

    public function print($id)
    {
        $prescription = Prescription::with('patient', 'doctor', 'items')->findOrFail($id);

        if (Auth::user()->role === 'doctor' && $prescription->doctor_id !== Auth::id()) {
            return redirect()->route('prescriptions.index')->with('error', 'Accès non autorisé.');
        }

        return view('prescriptions.print', compact('prescription'));
    }
}
