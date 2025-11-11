<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Tampilkan halaman login kasir
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login kasir
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        // Login pakai guard kasir
        if (Auth::guard('kasir')->attempt($credentials, $request->filled('remember'))) {
            // Regenerate session untuk keamanan
            $request->session()->regenerate();

            // Redirect ke dashboard
            return redirect()->intended('/dashboard');
        }

        // Jika gagal login
        return back()->withErrors([
            'username' => 'Username atau password salah!',
        ])->withInput();
    }

    /**
     * Logout kasir
     */
    public function logout(Request $request)
    {
        Auth::guard('kasir')->logout();

        // Invalidasi session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
