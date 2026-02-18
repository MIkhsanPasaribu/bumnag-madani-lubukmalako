<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Controller untuk menangani ganti password dan pertanyaan keamanan admin
 */
class PasswordController extends Controller
{
    /**
     * Menampilkan form ganti password
     */
    public function edit()
    {
        return view('admin.password.edit', [
            'user' => Auth::user(),
            'securityQuestions' => User::getSecurityQuestions(),
        ]);
    }

    /**
     * Proses ganti password
     */
    public function update(ChangePasswordRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Logout user untuk keamanan (force re-login dengan password baru)
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Password berhasil diubah. Silakan login dengan password baru Anda.');
    }

    /**
     * Menampilkan form setup pertanyaan keamanan
     */
    public function editSecurity()
    {
        return view('admin.security.edit', [
            'user' => Auth::user(),
            'securityQuestions' => User::getSecurityQuestions(),
        ]);
    }

    /**
     * Proses update pertanyaan keamanan
     */
    public function updateSecurity(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'security_question' => ['required', 'string', 'in:' . implode(',', array_keys(User::getSecurityQuestions()))],
            'security_answer' => ['required', 'string', 'min:2', 'max:200'],
        ], [
            'current_password.required' => 'Password wajib diisi untuk verifikasi.',
            'current_password.current_password' => 'Password tidak sesuai.',
            'security_question.required' => 'Pilih pertanyaan keamanan.',
            'security_question.in' => 'Pertanyaan keamanan tidak valid.',
            'security_answer.required' => 'Jawaban keamanan wajib diisi.',
            'security_answer.min' => 'Jawaban minimal 2 karakter.',
            'security_answer.max' => 'Jawaban maksimal 200 karakter.',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->security_question = $request->security_question;
        $user->security_answer = strtolower(trim($request->security_answer));
        $user->save();

        return redirect()->route('admin.security.edit')
            ->with('success', 'Pertanyaan keamanan berhasil diperbarui.');
    }
}
