<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

/**
 * Controller untuk menangani reset password
 */
class ResetPasswordController extends Controller
{
    /**
     * Menampilkan form reset password
     */
    public function showForm(Request $request, string $token)
    {
        // Redirect ke dashboard jika sudah login
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    /**
     * Proses reset password
     */
    public function reset(Request $request)
    {
        // Validasi input
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'token.required' => 'Token tidak valid.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Cek token di database
        $tokenRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$tokenRecord) {
            return back()
                ->withInput()
                ->withErrors([
                    'email' => 'Email tidak ditemukan atau link sudah kadaluarsa.',
                ]);
        }

        // Verifikasi token
        if (!Hash::check($request->token, $tokenRecord->token)) {
            return back()
                ->withInput()
                ->withErrors([
                    'email' => 'Token tidak valid.',
                ]);
        }

        // Cek apakah token sudah expired (60 menit)
        $createdAt = \Carbon\Carbon::parse($tokenRecord->created_at);
        if ($createdAt->addMinutes(60)->isPast()) {
            // Hapus token expired
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            
            return back()
                ->withInput()
                ->withErrors([
                    'email' => 'Link reset password sudah kadaluarsa. Silakan minta link baru.',
                ]);
        }

        // Cari user
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withInput()
                ->withErrors([
                    'email' => 'Email tidak terdaftar.',
                ]);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        // Hapus token setelah digunakan
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')
            ->with('success', 'Password berhasil direset. Silakan login dengan password baru Anda.');
    }
}
