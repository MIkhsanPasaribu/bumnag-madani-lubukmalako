<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;

/**
 * Controller untuk menangani lupa password dengan pertanyaan keamanan
 */
class ForgotPasswordController extends Controller
{
    /**
     * Tampilkan form input email
     */
    public function showEmailForm()
    {
        // Redirect ke dashboard jika sudah login
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.forgot-password');
    }

    /**
     * Verifikasi email dan tampilkan pertanyaan keamanan
     */
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        // Rate limiting: maksimal 5 percobaan per menit
        $key = 'forgot-password:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()
                ->withInput()
                ->withErrors(['email' => "Terlalu banyak percobaan. Silakan coba lagi dalam {$seconds} detik."]);
        }
        RateLimiter::hit($key, 60);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Email tidak ditemukan dalam sistem.']);
        }

        if (!$user->hasSecurityQuestion()) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Akun ini belum memiliki pertanyaan keamanan. Hubungi administrator.']);
        }

        // Simpan email di session untuk step berikutnya
        session(['reset_email' => $user->email]);

        return view('auth.security-question', [
            'question' => User::getSecurityQuestions()[$user->security_question] ?? $user->security_question,
            'email' => $user->email,
        ]);
    }

    /**
     * Verifikasi jawaban keamanan
     */
    public function verifyAnswer(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'security_answer' => ['required', 'string'],
        ], [
            'security_answer.required' => 'Jawaban keamanan wajib diisi.',
        ]);

        // Rate limiting
        $key = 'security-answer:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()
                ->withInput()
                ->withErrors(['security_answer' => "Terlalu banyak percobaan salah. Coba lagi dalam {$seconds} detik."]);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !$user->verifySecurityAnswer($request->security_answer)) {
            RateLimiter::hit($key, 300); // Block 5 menit jika salah
            return back()
                ->withInput()
                ->withErrors(['security_answer' => 'Jawaban keamanan tidak sesuai.']);
        }

        // Reset rate limiter jika berhasil
        RateLimiter::clear($key);

        // Generate token untuk reset password
        $token = bin2hex(random_bytes(32));
        session([
            'reset_token' => $token,
            'reset_email' => $user->email,
            'reset_expires' => now()->addMinutes(10),
        ]);

        return redirect()->route('password.reset.form', ['token' => $token]);
    }

    /**
     * Tampilkan form reset password
     */
    public function showResetForm(Request $request, string $token)
    {
        // Validasi token dari session
        if (
            !session('reset_token') ||
            session('reset_token') !== $token ||
            now()->isAfter(session('reset_expires'))
        ) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Link reset password tidak valid atau sudah kadaluarsa.']);
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => session('reset_email'),
        ]);
    }

    /**
     * Proses reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        // Validasi token
        if (
            !session('reset_token') ||
            session('reset_token') !== $request->token ||
            session('reset_email') !== $request->email ||
            now()->isAfter(session('reset_expires'))
        ) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Sesi reset password tidak valid atau sudah kadaluarsa.']);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'User tidak ditemukan.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Clear session
        session()->forget(['reset_token', 'reset_email', 'reset_expires']);

        return redirect()->route('login')
            ->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }
}
