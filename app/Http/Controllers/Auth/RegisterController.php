<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\WelcomeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255','unique:users,email'],
            'password' => ['required','string','min:8','confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'customer',
        ]);

        // Fire Registered event (Laravel verifies email using this)
        event(new Registered($user));

        // Kirim welcome notification (queued)
        $user->notify(new WelcomeNotification($user));

        // Login the user (optional). We'll keep them logged in but require email verification for checkout.
        Auth::login($user);

        // Redirect to verification notice page
        return redirect()->route('verification.notice')->with('status', 'registrationsuccess');
    }
}