<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Log the incoming request data
        Log::info('Update profile request received', $request->all());

        // Validate the request data
        $validatedData = $request->validated();
        Log::info('Validated data', $validatedData);

        // Get the current authenticated user
        $user = $request->user();

        // Update user profile
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->nis = $validatedData['nis'] ?? $user->nis;
        $user->kelas = $validatedData['kelas'] ?? $user->kelas;
        $user->kontak = $validatedData['kontak'] ?? $user->kontak;

        // Check if the email has changed, if so, reset email verification
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Save the updated user data to the database
        $user->save();

        // Log the successful update
        Log::info('User profile updated', ['user_id' => $user->id]);

        // Redirect back to the profile edit page with a success message
        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    
    }
    
    

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
