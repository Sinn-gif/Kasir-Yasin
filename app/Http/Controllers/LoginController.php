<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
 
    public function showLoginForm()
    {
        return view('auth.login');
    }

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
            $request->session()->regenerate();

            // Redirect ke dashboard
            return redirect()->intended('/dashboard');
        }

        // Jika gagal login
        return back()->withErrors([
            'username' => 'Username atau password salah!',
        ])->withInput();
    }


    public function logout(Request $request)
    {
        Auth::guard('kasir')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
