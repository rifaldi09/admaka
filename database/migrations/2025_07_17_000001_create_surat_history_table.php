<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // database user untuk login (field sementara)
        //! catatan: untuk id pada table users itu masih membingungkan, karna di table role_akses terdapat id_user
        //! jadi id pada table users hanya sementara, jika bisa silahkan diubah namanya
        Schema::create('nomor_surat_history', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat'); // hanya angka
            $table->year('tahun');
            $table->string('id_surat'); // contoh: 'SK', 'UND', dst
            $table->string('nama_surat'); // optional, untuk nama jenis surat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomor_surat_history');
    }
};