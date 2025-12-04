<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\kontrolkeluhan;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});
// di web.php
Route::get('/debug-user', function() {
    if (auth()->check()) {
        $user = auth()->user();
        return [
            'user_object' => $user,
            'nik' => $user->nik,
            'nama' => $user->nama, // <- Harusnya ini ada nilainya
            'email' => $user->email,
            'session_nama' => session('nama')
        ];
    }
    return 'Not logged in';
});
Route::get('/Keluhan', [kontrolkeluhan::class, 'index']);
Route::get('/Keluhan/Add', [kontrolkeluhan::class, 'create']);
Route::post('/Keluhan/store', [kontrolkeluhan::class, 'store']);
Route::get('/Keluhan/edit/{id}', [kontrolkeluhan::class, 'edit']);
Route::put('/Keluhan/update/{id}', [kontrolkeluhan::class, 'update']);
Route::delete('/Keluhan/destroy/{id}', [kontrolkeluhan::class, 'destroy'])->name('keluhan.destroy');
//FLOW LOGIN LOGOUT
// 1. Tampilkan form login (GET)
// Dipanggil oleh route('login')
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// 2. Proses submit form login (POST) -> INI YANG PALING PENTING!
// Dipanggil oleh route('login.post') dari form di login.blade.php
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// 3. Proses logout (POST)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// =========================================================================
// RUTE KELUHAN (Dilindungi oleh Middleware 'auth')
// =========================================================================
// Semua rute di dalam grup ini hanya bisa diakses setelah login berhasil.
Route::middleware(['auth'])->group(function () {
    
    // Keluhan Index (Home setelah login)
    Route::get('/Keluhan', [kontrolkeluhan::class, 'index'])->name('keluhan.index');
    
    // Tambah Keluhan
    Route::get('/Keluhan/Add', [kontrolkeluhan::class, 'create'])->name('keluhan.create');
    Route::post('/Keluhan/store', [kontrolkeluhan::class, 'store'])->name('keluhan.store');
    
    // Edit/Update Keluhan
    Route::get('/Keluhan/edit/{id}', [kontrolkeluhan::class, 'edit'])->name('keluhan.edit');
    Route::put('/Keluhan/update/{id}', [kontrolkeluhan::class, 'update'])->name('keluhan.update');
    
    // Hapus Keluhan (Menggunakan metode DELETE yang benar)
    // Rute GET /hapus/{id} yang lama dihapus, ganti dengan DELETE /destroy/{id}
    Route::delete('/Keluhan/destroy/{id}', [kontrolkeluhan::class, 'destroy'])->name('keluhan.destroy');

    Route::get('/Keluhan/cetak', [kontrolkeluhan::class, 'cetak']);
    
});