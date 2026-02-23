<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    // Daftar provider yang akan kita dukung
    protected $allowedProviders = ['google', 'facebook'];

    public function redirect(Request $request, $provider)
    {
        $provider = strtolower($provider);

        // Cek provider valid
        if (! in_array($provider, $this->allowedProviders)) {
            return redirect()->route('login')->withErrors(['social' => 'Provider tidak didukung.']);
        }

        // Cek config sudah ada (agar tidak error bila credential belum diset)
        $clientIdKey = strtoupper($provider) . '_CLIENT_ID';
        if (empty(config("services.{$provider}.client_id")) && empty(env($clientIdKey))) {
            return redirect()->route('login')
                ->withErrors(['social' => 'Integrasi ' . ucfirst($provider) . ' belum dikonfigurasi di server.']);
        }

        // Redirect ke provider menggunakan Socialite
        return Socialite::driver($provider)->redirect();
    }

    public function callback(Request $request, $provider)
    {
        $provider = strtolower($provider);

        if (! in_array($provider, $this->allowedProviders)) {
            return redirect()->route('login')->withErrors(['social' => 'Provider tidak didukung.']);
        }

        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            Log::error('Social callback error: ' . $e->getMessage());
            return redirect()->route('login')->withErrors([
                'social' => 'Terjadi kesalahan saat autentikasi dengan ' . ucfirst($provider) . '. Coba lagi.',
            ]);
        }

        // Cari user berdasarkan provider_id terlebih dahulu
        $user = User::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        $email = $socialUser->getEmail();

        // Jika belum ada, coba cocokan berdasarkan email (user pernah daftar manual)
        if (! $user && $email) {
            $user = User::where('email', $email)->first();
        }

        // Jika tetap belum ada, buat user baru
        if (! $user) {
            // Pastikan ada email unik; jika provider tidak memberikan email,
            // buat email dummy yang tetap unik agar tidak melanggar constraint.
            if (! $email) {
                $email = $provider . '_' . $socialUser->getId() . '@example-social.local';
            }

            $user = User::create([
                'name'     => $socialUser->getName() ?: ($socialUser->getNickname() ?: ucfirst($provider) . ' User'),
                'email'    => $email,
                'password' => Hash::make(Str::random(40)),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'role' => 'customer',
            ]);
        } else {
            // Pastikan data provider terisi untuk user lama
            if (! $user->provider || ! $user->provider_id) {
                $user->provider = $provider;
                $user->provider_id = $socialUser->getId();
                $user->save();
            }
        }

        Auth::login($user, true);

        // Redirect sesuai role (reuse logika login biasa)
        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        }

        return redirect()->intended('/my-dashboard');
    }
}