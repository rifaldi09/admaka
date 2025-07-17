<?php

use App\Models\NomorSuratCounter;
use App\Models\NomorSuratHistory;


if (!function_exists('generateNomorSurat')) {
    function generateNomorSurat($namaSurat, $idSurat)
    {
        $tahunSekarang = date('Y');

        $counter = NomorSuratCounter::where('tahun', $tahunSekarang)->first();
        if (!$counter) {
            // Ambil nomor terakhir dari database, kalau ada
            $lastCounter = NomorSuratCounter::where('tahun', $tahunSekarang)
                ->orderByDesc('counter')
                ->value('counter') ?? 0;

            $nextCounter = $lastCounter + 1;

            $counter = NomorSuratCounter::create([
                'tahun' => $tahunSekarang,
                'id_surat' => $idSurat,
                'nama_surat' => $namaSurat,
                'no_surat' => str_pad($nextCounter, 4, '0', STR_PAD_LEFT),
                'counter' => $nextCounter,
            ]);

        } else {
            // Increment counter
            $counter->counter += 1;
            // Format no_surat jadi string 4 digit dengan leading zero
            $counter->no_surat = str_pad($counter->counter, 4, '0', STR_PAD_LEFT);
            $counter->save();
        }
        
        // Simpan ke tabel histori
        NomorSuratHistory::create([
            'no_surat' => $counter->no_surat,
            'id_surat' => $idSurat,
            'nama_surat' => $namaSurat,
            'tahun' => $tahunSekarang,
        ]);

        return $counter->no_surat; // contoh: "0001", "0002", dst
    }
}