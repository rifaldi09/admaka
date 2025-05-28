<?php

use App\Models\User;
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
        Schema::create('permohonan_pengambilan', function (Blueprint $table) {
            $table->uuid('id_permohonan')->primary();
            $table->foreignIdFor(User::class)->constrained(); // foreign key ke users.id
            $table->unsignedBigInteger('id_prodi');
            $table->unsignedBigInteger('nidn')->nullable();
            $table->string('no_surat')->nullable()->default('');
            $table->string('tujuan_surat');
            $table->text('alamat_surat');
            $table->enum('keperluan', ['skripsi', 'mata_kuliah']);
            $table->text('judul_skripsi')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['Belum Diterima', 'Diterima', 'Ditolak' , 'Penerbitan'])->default('Belum Diterima');
            $table->string('alasan_ditolak')->nullable()->default('');
            $table->timestamps();

            $table->foreign('id_prodi')->references('id')->on('prodi')->onDelete('cascade');
            $table->foreign('nidn')->references('nidn')->on('dosen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_pengambilan');
    }
};
