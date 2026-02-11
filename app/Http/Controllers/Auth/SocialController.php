<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        // Cek config sudah ada (agar tidak error bila Socialite blm dikonfig)
        $clientIdKey = strtoupper($provider) . '_CLIENT_ID';
        if (empty(config("services.{$provider}.client_id")) && empty(env($clientIdKey))) {
            // config belum lengkap — beri pesan user-friendly
            return redirect()->route('login')->withErrors(['social' => 'Integrasi ' . ucfirst($provider) . ' belum dikonfigurasi.']);
        }

        // Jika Socialite sudah terpasang nanti, kita akan redirect ke provider:
        // return Socialite::driver($provider)->redirect();
        // Untuk sekarang (stub), kembalikan redirect ke login dengan pesan
        return redirect()->route('login')->with('status', 'Redirect ke ' . ucfirst($provider) . ' (stub). Saat ini integrasi belum aktif di server.');
    }

    public function callback(Request $request, $provider)
    {
        $provider = strtolower($provider);

        if (! in_array($provider, $this->allowedProviders)) {
            return redirect()->route('login')->withErrors(['social' => 'Provider tidak didukung.']);
        }

        // Jika Socialite terpasang, kita akan memproses callback di sini:
        // try {
        //     $socialUser = Socialite::driver($provider)->stateless()->user();
        //     // logic: cari user by provider_id / email, buat jika perlu, login, redirect
        // } catch (\Exception $e) {
        //     Log::error('Social callback error: ' . $e->getMessage());
        //     return redirect()->route('login')->withErrors(['social' => 'Terjadi kesalahan saat autentikasi sosial.']);
        // }

        // Stub response untuk saat ini
        return redirect()->route('login')->with('status', ucfirst($provider) . ' callback diterima (stub). Integrasi belum aktif.');
    }
}