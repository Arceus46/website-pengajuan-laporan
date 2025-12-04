@extends('layouts.apps')
@section('judul')
Update Laporan Keluhan
@endsection
@section('content')

<div class="main-content">
    <header>
        <h1>Edit Keluhan</h1>
    </header>

    <!-- Proses Update dalam View -->
    @php
        // Cek apakah form disubmit
        if(request()->isMethod('post') && request()->has('update_keluhan')) {
            
            // Validasi
            $validator = Validator::make(request()->all(), [
                'judul_keluhan' => 'required|max:255',
                'isi_keluhan' => 'required',
            ]);
            
            if($validator->fails()) {
                $errors = $validator->errors();
            } else {
                // Update data
                try {
                    $keluhan->update([
                        'judul_keluhan' => request('judul_keluhan'),
                        'isi_keluhan' => request('isi_keluhan'),
                    ]);
                    
                    session()->flash('success', 'Keluhan berhasil diperbarui!');
                    echo "<script>window.location.href = '" . route('keluhan.index') . "';</script>";
                    exit;
                } catch(\Exception $e) {
                    $error_message = "Gagal update: " . $e->getMessage();
                }
            }
        }
    @endphp

    <!-- Tampilkan Pesan -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(isset($error_message))
        <div class="alert alert-error">
            {{ $error_message }}
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Edit -->
<div class="card form-card">
    <h3 class="form-title">Edit Keluhan</h3>

    <form method="POST" action="{{ url('Keluhan/update/' . $keluhan->id_keluhan) }}" class="input-form">
        @csrf
        @method('PUT')

        <label class="form-label" for="judul_keluhan">Judul Keluhan</label>
        <input 
            type="text" 
            name="judul_keluhan"
            id="judul_keluhan"
            class="form-input"
            placeholder="Masukkan judul keluhan"
            value="{{ old('judul_keluhan', $keluhan->judul_keluhan) }}"
            required
        >

        <label class="form-label" for="isi_keluhan">Deskripsi Keluhan</label>
        <textarea 
            name="isi_keluhan"
            id="isi_keluhan"
            class="form-textarea"
            placeholder="Tuliskan keluhan Anda..."
            rows="5"
            required
        >{{ old('isi_keluhan', $keluhan->isi_keluhan) }}</textarea>

        <div class="form-btn-group">
            <button type="submit" name="update_keluhan" class="btn">
                Simpan Perubahan
            </button>

            <a href="{{ route('keluhan.index') }}" class="btn">
                Batal
            </a>
        </div>

    </form>
</div>

@endsection