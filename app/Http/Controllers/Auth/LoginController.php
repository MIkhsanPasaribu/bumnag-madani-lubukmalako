<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Controller untuk autentikasi admin
 */
class LoginController extends Controller
{
    /**
     * Menampilkan form login
     */
    public function showLoginForm(): View|RedirectResponse
    {
        // Redirect ke dashboard sesuai role jika sudah login
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();
            return redirect()->route($user->getDashboardRoute());
        }
        
        return view('auth.login');
    }
    
    /**
     * Proses login
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);
        
        $remember = $request->boolean('remember');
        
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            /** @var User $user */
            $user = Auth::user();
            $dashboardRoute = $user->getDashboardRoute();
            
            return redirect()->intended(route($dashboardRoute))
                ->with('success', 'Selamat datang, ' . $user->name . '!');
        }
        
        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Email atau password salah.',
            ]);
    }
    
    /**
     * Proses logout
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('beranda')
            ->with('success', 'Anda telah berhasil logout.');
    }
}
