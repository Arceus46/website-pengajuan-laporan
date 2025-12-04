@extends('layouts.apps')
@section('judul')
Input Laporan Keluhan
@endsection
@section('content')

<div class="main-content">
    <header>
        <h1>Form Keluhan Baru</h1>
    </header>

    <!-- Tampilkan pesan sukses atau error (dari Controller) -->
    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert error">
            Mohon periksa kembali input Anda:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="card form-card">
        <h3 class="form-title">Input Keluhan</h3>

        <!-- 
        1. Action: Mengarah ke route store (POST /Keluhan/store)
        2. @csrf: Wajib untuk keamanan form Laravel
        -->
        <form method="POST" action="{{ url('/Keluhan/store') }}" class="input-form">
            @csrf

            <!-- NIK dan Tanggal tidak perlu dikirim melalui form karena sudah diisi di Controller -->
            
            <label class="form-label" for="judul_keluhan">Judul Keluhan</label>
            <input 
                type="text" 
                name="judul_keluhan"
                id="judul_keluhan"
                class="form-input"
                placeholder="Masukkan judul keluhan"
                value="{{ old('judul_keluhan') }}"
            >

            <label class="form-label" for="isi_keluhan">Deskripsi Keluhan</label>
            <textarea 
                name="isi_keluhan"
                id="isi_keluhan"
                class="form-textarea"
                placeholder="Tuliskan keluhan Anda...">{{ old('isi_keluhan') }}</textarea>

            <div class="form-btn-group">
                <!-- Tombol Submit (sesuai action form) -->
                <button type="submit" class="btn">Submit</button>
                
                <button type="reset" class="btn">Reset</button>
                
                <!-- Link kembali ke halaman index keluhan -->
                <a href="{{ url('/Keluhan') }}" class="btn">Back</a>
            </div>

        </form>
    </div>

</div>

@endsection