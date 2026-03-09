<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user()->refresh();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => ['nullable', 'string', 'regex:/^(05|06|07)\d{8}$/'],
            'address' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'address']);

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && File::exists(public_path('profiles/' . $user->profile_photo))) {
                File::delete(public_path('profiles/' . $user->profile_photo));
            }

            $image = $request->file('profile_photo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profiles'), $imageName);
            $data['profile_photo'] = $imageName;
        }

        $user->update($data);

        // Refresh the authenticated user in session
        auth()->login($user->fresh());

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function destroyPhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo) {
            $photoPath = public_path('profiles/' . $user->profile_photo);
            if (File::exists($photoPath)) {
                File::delete($photoPath);
            }

            $user->update(['profile_photo' => null]);
            return redirect()->back()->with('success', 'Photo de profil supprimée avec succès.');
        }

        return redirect()->back()->with('error', 'Aucune photo de profil à supprimer.');
    }
}
