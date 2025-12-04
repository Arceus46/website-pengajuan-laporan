@extends('layouts.apps')
@section('judul')
Laporan Keluhan Saya
@endsection

@section('content')
<div class="main-content">
    <header>
        <h1>Form Keluhan</h1>
    </header>
    <form method="GET" action="{{ url('/Keluhan') }}">
        <a href="{{ url('/Keluhan/Add') }}"><h3>[+] Tambah Data [+]</h3><br></a>
        <button type="button" class="btn">
                    <a href="/Keluhan/cetak" style="color:white">Cetak Semua Data</a>
                </button><br>
        <input type="text" name="cari" class="wlee" value="{{ request('cari') }}" placeholder="Masukkan kata kunci..." />
        
        <button type="submit" class="btn">Cari</button>
        <button type="button" class="btn">
            <a href="{{ url('/Keluhan') }}" style="color:white">Reset</a>
        </button>
        
        <section class="table-section">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Judul Keluhan</th>
                            <th>Deskripsi</th>
                            <th colspan="2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($shkeluhan as $keluhan)
                            <tr align='center'>
                                <td>{{ $keluhan->id_keluhan }}</td>
                                <td>{{ $keluhan->tanggal_keluhan }}</td>
                                <td>{{ $keluhan->judul_keluhan }}</td>
                                <td>{{ $keluhan->isi_keluhan }}</td>
                                <td><a class="badge warning" href="{{ url('/Keluhan/edit/' . $keluhan->id_keluhan) }}">Update</a></td>
                                <td>
        <form action="{{ route('keluhan.destroy', $keluhan->id_keluhan) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button 
                type="submit" 
                class="badge warning" 
                style="border: none; cursor: pointer;"
                onclick="return confirm('Apakah Anda yakin ingin menghapus keluhan ID: {{ $keluhan->id_keluhan }}?')"
            >
                Hapus
            </button>
        </form>
    </td>
</tr>
                        @empty
                            <tr>
                                <td colspan="6" align="center">Tidak ada data keluhan yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </form>
</div>
@endsection