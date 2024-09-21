<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Eskul;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    public function create(): Response
    {
        $eskuls = Eskul::all();  
        return Inertia::render('Auth/Register', [
            'eskuls' => $eskuls, 
        ]);
    }
    
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'eskul_id' => 'required|array',
            'eskul_id.*' => 'exists:eskuls,id',
            'nis' => 'required|unique:users,nis',
            'kelas' => 'required|string|max:255',
        ]);

        // Membuat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nis' => $request->nis,
            'kelas' => $request->kelas,
        ]);

        // Menambahkan relasi many-to-many antara user dan eskul
        $user->eskuls()->attach($request->eskul_id);

        // Login pengguna
        Auth::login($user);

        // Redirect ke dashboard
        return redirect(route('dashboard', absolute: false));
    }    
}
