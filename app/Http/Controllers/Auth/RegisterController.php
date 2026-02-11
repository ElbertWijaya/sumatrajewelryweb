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

        // Fire Registered event -> Laravel akan mengirim email verifikasi (jika route & listener terpasang)
        event(new Registered($user));

        // Kirim welcome email (queued). Pastikan queue worker berjalan di environment Anda.
        $user->notify(new WelcomeNotification($user));

        // Login user (tetap harus verifikasi email untuk checkout)
        Auth::login($user);

        return redirect()->route('verification.notice')->with('status', 'registrationsuccess');
    }
}