<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RekamMedis;


class RekamMedisController extends Controller
{
    public function index()
    {
        // Menampilkan semua rekam medis
        $rekamMedis = \App\Models\RekamMedis::all();

        return view('rekam-medis.index', ['rekamMedis' => $rekamMedis]);
    }

    public function riwayatPasien($id)
    {
        // Menampilkan riwayat rekam medis per pasien
        $pasien = \App\Models\Pasien::find($id);
        $riwayatRekamMedis = $pasien->rekamMedis;

        return view('rekam-medis.riwayat-pasien', ['pasien' => $pasien, 'riwayatRekamMedis' => $riwayatRekamMedis]);
    }

    public function rekamMedisDokter($id)
    {
        // Menampilkan rekam medis per dokter
        $dokter = \App\Models\Dokter::find($id);
        $rekamMedisDokter = $dokter->rekamMedis;

        return view('rekam-medis.rekam-medis-dokter', ['dokter' => $dokter, 'rekamMedisDokter' => $rekamMedisDokter]);
    }

    public function create()
    {
        // Menampilkan formulir rekam medis
        $pasienList = \App\Models\Pasien::all();
        $dokterList = \App\Models\Dokter::all();

        return view('rekam-medis.create', ['pasienList' => $pasienList, 'dokterList' => $dokterList]);
    }

    public function store(Request $request)
    {
        // Validasi data dari formulir
        $request->validate([
            'pasien_id' => 'required',
            'dokter_id' => 'required',
            'kondisi_kesehatan' => 'required|string',
            'suhu_tubuh' => 'required|numeric|min:35|max:45.5',
            'resep' => 'required|file|mimes:pdf,png,jpg,jpeg',
        ]);

        // Simpan data rekam medis ke database (opsional)
        $rekamMedis = new \App\Models\RekamMedis;
        $rekamMedis->pasien_id = $request->pasien_id;
        $rekamMedis->dokter_id = $request->dokter_id;
        $rekamMedis->kondisi_kesehatan = $request->kondisi_kesehatan;
        $rekamMedis->suhu_tubuh = $request->suhu_tubuh;
        $rekamMedis->resep = $request->file('resep')->store('resep');

        $rekamMedis->save();

        // Pesan flash berhasil
        session()->flash('success', 'Data rekam medis berhasil disimpan.');

        return redirect('/rekam-medis');
    }
}
