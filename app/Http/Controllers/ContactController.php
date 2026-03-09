<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     */
    public function showForm()
    {
        return view('auth.contact');
    }

    /**
     * Handle the contact form submission.
     */
    public function send(Request $request)
    {
        $request->validate([
            'prenom'     => ['required', 'string', 'max:100'],
            'nom'        => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email'],
            'specialite' => ['required', 'string'],
            'message'    => ['required', 'string', 'min:20'],
        ], [
            'prenom.required'     => 'Le prénom est obligatoire.',
            'nom.required'        => 'Le nom est obligatoire.',
            'email.required'      => 'L\'adresse e-mail est obligatoire.',
            'email.email'         => 'Veuillez saisir une adresse e-mail valide.',
            'specialite.required' => 'Veuillez sélectionner une spécialité.',
            'message.required'    => 'Le message est obligatoire.',
            'message.min'         => 'Le message doit contenir au moins 20 caractères.',
        ]);

        // TODO: Send notification email to admin
        // Mail::to(config('mail.admin_address', 'admin@cabinetmedical.fr'))
        //     ->send(new ContactRequest($request->all()));

        return back()->with('success', true);
    }
}
