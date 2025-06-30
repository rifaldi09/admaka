<?php

namespace App\Http\Controllers;

use App\Models\AktifKuliah;
use App\Models\PengajuanKP;
use App\Models\PermohonanMagang;
use App\Models\PPDP;
use App\Models\SuratRekomendasi;
use App\Models\Transkrip;

class HomepageController extends Controller
{
    public function index()
    {
        // Get all data surat
        $models = [AktifKuliah::class, PengajuanKP::class, PPDP::class, PermohonanMagang::class, SuratRekomendasi::class, Transkrip::class];

        // Count data surat
        $belumDiterima = collect($models)->sum(fn($models) => $models::where('status', 'Belum Diterima')->count());
        $dataDiterima = collect($models)->sum(fn($models) => $models::where('status', 'Diterima')->count());
        $dataPenerbitan = collect($models)->sum(fn($models) => $models::where('status', 'Penerbitan')->count());

        return view('homepage.index', compact('belumDiterima', 'dataDiterima', 'dataPenerbitan'), ['title' => 'ADMAKA - FTTK UMRAH']);
    }
}
