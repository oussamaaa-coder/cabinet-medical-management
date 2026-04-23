<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        // ── Role-based scoping ──────────────────────────────────────────
        $doctorId = null;
        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role === 'doctor') {
            $doctorId = \App\Models\Doctor::where('user_id', \Illuminate\Support\Facades\Auth::id())->value('id');
            if ($doctorId) {
                // Doctor with a valid profile: show only their patients
                $query->whereHas('appointments', function($q) use ($doctorId) {
                    $q->where('doctor_id', $doctorId);
                });
            } else {
                // Doctor role but NO linked Doctor record → show nothing (security)
                $query->whereRaw('0 = 1');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('last_name', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('cin', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Tous les patients (paginés)
        $patients = $query->latest()->paginate(5);

        // Total patients
        $totalPatients = $query->count();

        // Rendez-vous planifiés aujourd'hui
        $appointmentsPlannedQuery = \App\Models\Appointment::with(['patient', 'doctor'])
            ->whereDate('date', today()->toDateString())
            ->where('status', 'planned')
            ->orderBy('start_time');

        // Rendez-vous consultés aujourd'hui
        $appointmentsConsultedQuery = \App\Models\Appointment::with(['patient', 'doctor'])
            ->whereDate('date', today()->toDateString())
            ->where('status', 'completed')
            ->orderBy('start_time');

        if ($doctorId) {
            $appointmentsPlannedQuery->where('doctor_id', $doctorId);
            $appointmentsConsultedQuery->where('doctor_id', $doctorId);
        }

        $appointmentsPlanned = $appointmentsPlannedQuery->get();
        $appointmentsConsulted = $appointmentsConsultedQuery->get();

        $patientsPlannedToday = $appointmentsPlanned->count();
        $patientsConsultedToday = $appointmentsConsulted->count();

        return view('patients.index', compact(
            'patients',
            'totalPatients',
            'patientsPlannedToday',
            'patientsConsultedToday',
            'appointmentsPlanned',
            'appointmentsConsulted'
        ));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $is_majeur = $request->has('is_majeur');

        if ($is_majeur) {

            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => ['required', 'regex:/^(0[67]\d{8}|212[67]\d{8})$/'],
                'email' => 'nullable|email|max:255|unique:patients,email',
                'birth_date' => 'required|date',
                'gender' => 'required|in:male,female',
                'address' => 'nullable|string'
            ]);

        }
        else {

            $request->validate([
                'first_name_mineur' => 'required|string|max:255',
                'last_name_mineur' => 'required|string|max:255',
                'phone_responsable' => ['required', 'regex:/^(0[67]\d{8}|212[67]\d{8})$/'],
                'email_responsable' => 'nullable|email|max:255',
                'birth_date_mineur' => 'required|date',
                'gender_mineur' => 'required|in:Masculin,Féminin',
                'type_responsable' => 'required',
                'cin_responsable' => 'required',
                'nom_responsable' => 'required',
                'prenom_responsable' => 'required',
            ]);
        }

        $data = $request->all();

        // Upload photo
        if ($request->hasFile('photo')) {

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/patients'), $filename);

            $data['photo'] = 'uploads/patients/' . $filename;
        }

        if ($is_majeur) {

            $data['is_majeur'] = 1;

        }
        else {

            $data['is_majeur'] = 0;
            $data['first_name'] = $request->first_name_mineur;
            $data['last_name'] = $request->last_name_mineur;
            $data['birth_date'] = $request->birth_date_mineur;
            $data['groupe_sanguin'] = $request->groupe_sanguin_mineur;

            if ($request->gender_mineur == 'Masculin') {
                $data['gender'] = 'male';
            }
            elseif ($request->gender_mineur == 'Féminin') {
                $data['gender'] = 'female';
            }
        }

        Patient::create($data);

        return redirect()->route('patients.index')
            ->with('success', 'Patient ajouté avec succès.');
    }

    private function checkAccess($id)
    {
        if (auth()->user()->role === 'doctor') {
            $doctorId = \App\Models\Doctor::where('user_id', auth()->id())->value('id');
            if (!$doctorId) return false;

            // Check if patient exists and has at least one appointment with this doctor
            return Patient::where('id', $id)
                ->whereHas('appointments', function($q) use ($doctorId) {
                    $q->where('doctor_id', $doctorId);
                })->exists();
        }
        return true; // Admin has access
    }

    public function edit($id)
    {
        if (!$this->checkAccess($id)) {
            return redirect()->route('patients.index')->with('error', 'Accès non autorisé à ce patient.');
        }

        $patient = Patient::findOrFail($id);
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        if (!$this->checkAccess($id)) {
            return redirect()->route('patients.index')->with('error', 'Accès non autorisé à ce patient.');
        }

        $patient = Patient::findOrFail($id);

        $is_majeur = $request->has('is_majeur');

        if ($is_majeur) {

            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => ['required', 'regex:/^(0[67]\d{8}|212[67]\d{8})$/'],
                'email' => 'nullable|email|max:255|unique:patients,email,' . $id,
                'birth_date' => 'required|date',
                'gender' => 'required|in:male,female',
            ]);

        }
        else {

            $request->validate([
                'first_name_mineur' => 'required|string|max:255',
                'last_name_mineur' => 'required|string|max:255',
                'phone_responsable' => ['required', 'regex:/^(0[67]\d{8}|212[67]\d{8})$/'],
                'birth_date_mineur' => 'required|date',
                'gender_mineur' => 'required|in:Masculin,Féminin',
                'type_responsable' => 'required',
                'cin_responsable' => 'required',
                'nom_responsable' => 'required',
                'prenom_responsable' => 'required',
            ]);
        }

        $data = $request->all();

        if ($request->hasFile('photo')) {

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/patients'), $filename);

            $data['photo'] = 'uploads/patients/' . $filename;
        }

        if ($is_majeur) {
            $data['is_majeur'] = 1;
            $data['groupe_sanguin'] = $request->groupe_sanguin;
        }
        else {

            $data['is_majeur'] = 0;

            $data['first_name'] = $request->first_name_mineur;
            $data['last_name'] = $request->last_name_mineur;
            $data['birth_date'] = $request->birth_date_mineur;
            $data['groupe_sanguin'] = $request->groupe_sanguin_mineur;

            if ($request->gender_mineur == 'Masculin') {
                $data['gender'] = 'male';
            }
            elseif ($request->gender_mineur == 'Féminin') {
                $data['gender'] = 'female';
            }

            $data['type_responsable'] = $request->type_responsable;
            $data['cin_responsable'] = $request->cin_responsable;
            $data['nom_responsable'] = $request->nom_responsable;
            $data['prenom_responsable'] = $request->prenom_responsable;
            $data['phone_responsable'] = $request->phone_responsable;
            $data['email_responsable'] = $request->email_responsable;
            $data['profession_responsable'] = $request->profession_responsable;
        }

        $patient->update($data);

        return redirect()->route('patients.index')
            ->with('success', 'Patient modifié avec succès.');
    }

    public function listAll(Request $request)
    {
        $query = Patient::query();

        $doctorId = null;
        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->role === 'doctor') {
            $doctorId = \App\Models\Doctor::where('user_id', \Illuminate\Support\Facades\Auth::id())->value('id');
            if ($doctorId) {
                $query->whereHas('appointments', function($q) use ($doctorId) {
                    $q->where('doctor_id', $doctorId);
                });
            } else {
                // Doctor role but NO linked Doctor record → show nothing
                $query->whereRaw('0 = 1');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('last_name', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('cin', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $patients = $query->latest()->paginate(5);

        return view('patients.dashboardPatient.listAll', compact('patients'));
    }

    public function show($id)
    {
        if (!$this->checkAccess($id)) {
            return redirect()->route('patients.index')->with('error', 'Accès non autorisé à ce patient.');
        }

        $patient = Patient::with([
            'appointments' => function($q) {
                $q->with('doctor')->latest('date');
            },
            'prescriptions' => function($q) {
                $q->with(['doctor', 'items'])->latest('prescription_date');
            }
        ])->findOrFail($id);

        return view('patients.show', compact('patient'));
    }

    public function destroy($id)
    {
        if (!$this->checkAccess($id)) {
            return redirect()->route('patients.index')->with('error', 'Accès non autorisé à ce patient.');
        }

        $patient = Patient::findOrFail($id);

        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Patient supprimé.');
    }
}
