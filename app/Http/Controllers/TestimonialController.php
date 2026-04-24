<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:10|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $user = Auth::user();
        
        // Determine role based on user record or patient link
        $role = 'Patient';
        if ($user->role === 'doctor') $role = 'Médecin';
        if ($user->role === 'admin') $role = 'Administrateur';

        // Use user's profile photo if available
        $imagePath = null;
        if ($user->profile_photo) {
            $imagePath = 'profiles/' . $user->profile_photo;
        }

        Testimonial::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'role' => $role,
            'content' => $request->content,
            'rating' => $request->rating,
            'image' => $imagePath,
            'is_active' => false, // Always false by default for moderation
        ]);

        return back()->with('testimonial_success', 'Merci ! Votre avis a été envoyé et est en attente de modération par l\'administrateur.');
    }
}
