<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_rekomendasi', function (Blueprint $table) {
            $table->uuid('id_rekomendasi')->primary();
            $table->foreignIdFor(User::class)->constrained();
            $table->string('nomor_surat')->nullable();
            $table->text('perihal');
            $table->text('tempat_perihal')->nullable();
            $table->string('konversi_sks')->nullable();
            $table->enum('status', ['Belum Diterima', 'Diterima', 'Ditolak', 'Penerbitan'])->default('Belum Diterima');
            $table->string('alasan_ditolak')->nullable()->default('');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_rekomendasi');
    }
};
