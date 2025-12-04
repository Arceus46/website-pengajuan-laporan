<?php

namespace App\Http\Controllers;

use App\Models\Keluhan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

class kontrolkeluhan extends Controller
{
    public function index(Request $request) 
    {
        // 1. Inisialisasi query Eloquent untuk model Keluhan
            $query = Keluhan::query();

            // 2. Filter berdasarkan NIK user yang sedang login (Hanya menampilkan keluhan milik user itu sendiri)
            if (auth()->check()) {
                $nik = auth()->user()->nik;
                $query->where('nik', $nik);
            }

            // 3. Logika Pencarian (Jika ada input 'cari' dari form)
            if ($request->filled('cari')) {
                $cari = $request->cari;
                
                // Terapkan kondisi WHERE untuk pencarian di beberapa kolom
                $query->where(function ($q) use ($cari) {
                    $q->where('id_keluhan', 'like', "%{$cari}%")
                    ->orWhere('judul_keluhan', 'like', "%{$cari}%")
                    ->orWhere('isi_keluhan', 'like', "%{$cari}%")
                    ->orWhere('tanggal_keluhan', 'like', "%{$cari}%");
                });
            }
            
            // 4. Eksekusi query dan simpan hasilnya
            $shkeluhan = $query->get();
            
            // 5. Kirim data yang sudah difilter/dicari ke view
            return view('keluhan', compact('shkeluhan'));
        } //Show Keluhan + Search

    public function create()
    {
        return view('ikel');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_keluhan' => 'required|string|max:255',
            'isi_keluhan' => 'required|string',
        ]);

        // Generate unique ID
        $id_keluhan = 'K001';
        $counter = 1;
        while (Keluhan::where('id_keluhan', $id_keluhan)->exists()) {
            $counter++;
            $id_keluhan = 'K00' . $counter;
        }
        
        Keluhan::create([
            'id_keluhan' => $id_keluhan,
            'nik' => auth()->user()->nik,
            'judul_keluhan' => $request->judul_keluhan,
            'isi_keluhan' => $request->isi_keluhan,
            'tanggal_keluhan' => now(),
        ]);

        return redirect()->route('keluhan.index')->with('success', 'Keluhan submitted successfully.');
    }

    public function edit($id_keluhan)
    {
        $keluhan = Keluhan::where('id_keluhan', $id_keluhan)->firstOrFail();
        return view('ukel', compact('keluhan'));
    }

    public function update(Request $request, $id_keluhan)
    {
        $request->validate([
            'judul_keluhan' => 'required|string|max:255',
            'isi_keluhan' => 'required|string',
        ]);

        $keluhan = Keluhan::where('id_keluhan', $id_keluhan)->firstOrFail();
        $keluhan->update([
            'judul_keluhan' => $request->judul_keluhan,
            'isi_keluhan' => $request->isi_keluhan,
        ]);

        return redirect()->route('keluhan.index')->with('success', 'Keluhan updated successfully.');
    }

    public function delete($id_keluhan)
    {
        $delkeluhan = Keluhan::where('id_keluhan', $id_keluhan)->firstOrFail();
        return view('hkel', compact('delkeluhan'));
    }

    public function destroy($id_keluhan)
    {
        $keluhan = Keluhan::where('id_keluhan', $id_keluhan)->firstOrFail();
        $keluhan->delete();

        return redirect('/Keluhan')->with('success', 'Keluhan deleted successfully.');
    }

    public function cetak()
    {
        $cekel = Keluhan::all();
        $pdf = Pdf::loadview('ckel', compact('cekel'));
        return $pdf->download('laporan-Keluhan.pdf');
    }

}
