<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PhoneRegisterController extends Controller
{
    public function sendOtp(Request $request)
    {
        // Basic validation (format sederhana). You can adjust regex as needed.
        $validator = Validator::make($request->all(), [
            'phone_number' => ['required', 'string', 'min:9', 'max:20'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $phone = $request->input('phone_number');

        // Rate limit simple (cache) — dev stub: 5 attempts / 10 minutes
        $key = 'otp_attempts_' . md5($phone);
        $attempts = Cache::get($key, 0);
        if ($attempts >= 5) {
            return response()->json([
                'status' => 'error',
                'message' => 'Batas percobaan OTP tercapai. Coba lagi nanti.'
            ], 429);
        }
        Cache::put($key, $attempts + 1, now()->addMinutes(10));

        // Untuk stub: generate kode OTP dan simpan di cache (hashed in real impl)
        $otp = rand(100000, 999999);
        $otpKey = 'otp_code_' . md5($phone);
        Cache::put($otpKey, $otp, now()->addMinutes(5));

        // Di implementasi final: kirim OTP via Firebase (frontend) atau provider SMS
        // Saat ini log OTP ke storage/logs laravel.log untuk testing lokal (HATI-HATI: remove in prod)
        Log::info("Stub OTP for {$phone}: {$otp}");

        return response()->json(['status' => 'ok', 'message' => 'Kode OTP dikirim.']);
    }

    public function showVerifyForm(Request $request)
    {
        $phone = $request->query('phone');
        if (! $phone) {
            return redirect()->route('login')->withErrors(['phone' => 'Nomor telepon tidak ditemukan.']);
        }

        return view('auth.phone_verify', [
            'phone' => $phone,
        ]);
    }

    public function verifyAndRegister(Request $request)
    {
        $request->validate([
            'phone_number' => ['required', 'string', 'min:9', 'max:20'],
            'otp' => ['required', 'digits:6'],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        $phone = $request->input('phone_number');
        $otpKey = 'otp_code_' . md5($phone);
        $cached = Cache::get($otpKey);

        if (! $cached || (string) $cached !== (string) $request->input('otp')) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kedaluwarsa.'])->withInput();
        }

        // Hapus OTP dari cache
        Cache::forget($otpKey);

        // Cari user berdasarkan nomor telepon
        $user = User::where('phone_number', $phone)->first();

        if (! $user) {
            $name = $request->input('name') ?: 'Pelanggan ' . substr(preg_replace('/\D+/', '', $phone), -4);

            // Buat email dummy berbasis nomor telepon agar unik
            $normalizedPhone = preg_replace('/\D+/', '', $phone) ?: Str::random(8);
            $email = 'phone_' . $normalizedPhone . '@sumatra-phone.local';

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make(Str::random(32)),
                'phone_number' => $phone,
                'phone_verified_at' => now(),
                'role' => 'customer',
            ]);
        } else {
            if (! $user->phone_verified_at) {
                $user->phone_verified_at = now();
                $user->save();
            }
        }

        Auth::login($user, true);

        return redirect()->intended('/my-dashboard');
    }
}