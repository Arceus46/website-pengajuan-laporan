@extends('layouts.log')

@section('judul', 'Login - Sistem Laporan Keluhan')

{{-- Menyembunyikan sidebar di halaman login (jika layout mendukung) --}}
@section('sidebar_hidden', true) 

@section('content')
<div class="main-content center-content">
    
    <div class="card login-card">
        <h2 class="text-center">Login Warga</h2>

        {{-- Menampilkan pesan Error atau Sukses --}}
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        {{-- Menampilkan error validasi input --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        {{-- FORM LOGIN --}}
        {{-- Pastikan route 'login.post' sudah ada di web.php --}}
        <form method="POST" action="{{ route('login.post') }}">
            @csrf 

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input @error('email') is-invalid @enderror" 
                    required 
                    autocomplete="email" 
                    autofocus
                    value="{{ old('email') }}"
                >
                @error('email')
                    <span class="text-danger error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-input @error('password') is-invalid @enderror" 
                    required 
                    autocomplete="current-password"
                >
                @error('password')
                    <span class="text-danger error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <button type="submit" class="btn primary-btn w-full">
                Login
            </button>
        </form>
    </div>

</div>

{{-- Style Tambahan untuk Halaman Login --}}
<style>
    .center-content {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
    }
    .login-card {
        width: 100%;
        max-width: 400px;
        padding: 30px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .text-center { text-align: center; margin-bottom: 20px; }
    .form-group { margin-bottom: 15px; }
    .form-label { display: block; margin-bottom: 5px; font-weight: bold; }
    .form-input { 
        width: 100%; 
        padding: 10px; 
        border: 1px solid #ccc; 
        border-radius: 4px; 
    }
    .primary-btn {
        background-color: #007bff;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 4px;
        width: 100%;
        cursor: pointer;
        font-size: 16px;
    }
    .primary-btn:hover { background-color: #0056b3; }
    .alert { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
    .alert-danger { background-color: #f8d7da; color: #721c24; }
    .alert-success { background-color: #d4edda; color: #155724; }
    .text-danger { color: red; font-size: 0.85em; }
</style>
@endsection