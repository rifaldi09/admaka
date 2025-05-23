<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permohonan_magang', function (Blueprint $table) {
            $table->uuid('id_permohonan_magang')->primary();
            $table->foreignIdFor(User::class)->constrained(); // foreign key ke users.id
            $table->unsignedBigInteger('id_prodi');
            $table->string('no_surat')->nullable()->default('');
            $table->string('tujuan_surat');
            $table->text('alamat_surat');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['Belum Diterima', 'Diterima', 'Ditolak', 'Penerbitan'])->default('Belum Diterima');
            $table->string('alasan_ditolak')->nullable()->default('');
            $table->timestamps();

            $table->foreign('id_prodi')->references('id')->on('prodi')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan_magang');
    }
};
