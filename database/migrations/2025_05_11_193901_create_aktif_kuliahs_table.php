<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aktif_kuliah', function (Blueprint $table) {
            $table->uuid('id_aktif_kuliah')->primary();
            $table->foreignIdFor(User::class)->constrained();
            $table->text('keperluan');
            $table->text('nomor_surat')->nullable();
            $table->integer('semester_awal');
            $table->integer('semester_akhir');
            $table->enum('status_kuliah',['Aktif','Tidak Aktif'])->nullable();
            $table->enum('status',['Belum Diterima', 'Diterima', 'Ditolak','Penerbitan'])->default('Belum Diterima');
            $table->string('alasan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktif_kuliah');
    }
};
