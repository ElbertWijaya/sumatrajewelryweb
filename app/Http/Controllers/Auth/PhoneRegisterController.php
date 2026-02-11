<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
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

        return response()->json(['status' => 'ok', 'message' => 'Kode OTP dikirim (stub).']);
    }

    // Optional: endpoint untuk verifikasi OTP (stub)
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone_number' => ['required'],
            'otp' => ['required'],
        ]);

        $phone = $request->phone_number;
        $otpKey = 'otp_code_' . md5($phone);
        $cached = \Cache::get($otpKey);

        if (! $cached || $cached != $request->otp) {
            return response()->json(['status' => 'error', 'message' => 'OTP tidak valid.'], 422);
        }

        // OTP valid -> hapus cache & kembalikan sukses
        \Cache::forget($otpKey);
        return response()->json(['status' => 'ok', 'message' => 'OTP terverifikasi (stub).']);
    }
}