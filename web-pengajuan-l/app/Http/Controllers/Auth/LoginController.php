<?php

namespace App\Http\Controllers\Auth; // Perubahan di sini!

use App\Http\Controllers\Controller; // Tetap import base Controller
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Method untuk menampilkan form login (GET /login)
    public function showLoginForm()
    {
        // Mengarahkan ke view 'login.blade.php'
        return view('login');
    }

    // Method untuk memproses data login dari form (POST /login)
    // File: LoginController.php
// File: app/Http/Controllers/Auth/LoginController.php
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        $user = Auth::user();
        
        // Debug sebelum simpan session
        \Log::info('Before session save:', [
            'user_nama' => $user->nama,
            'nik' => $user->nik
        ]);
        
        // Simpan ke session - PAKAI put() atau session()->put()
        session()->put('nik', $user->nik);
        session()->put('nama', $user->nama);
        
        // Atau pakai cara array
        // session([
        //     'nik' => $user->nik,
        //     'nama' => $user->nama
        // ]);
        
        // Debug setelah simpan session
        \Log::info('After session save:', [
            'session_nama' => session('nama'),
            'session_nik' => session('nik')
        ]);
        
        // Simpan juga di Auth session
        $request->session()->put('user_nama', $user->nama);
        $request->session()->put('user_nik', $user->nik);

        return redirect()->intended('/Keluhan')->with('success', 'Selamat datang! Anda berhasil login.');
    }

    return back()->withErrors([
        'email' => 'Email atau password yang Anda masukkan tidak valid.',
    ])->onlyInput('email');
}
    
    // Method untuk Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan kembali ke halaman login setelah logout
        return redirect('/login');
    }
    
}