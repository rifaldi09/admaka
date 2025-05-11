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
        // database mahasiswa (field sementara)
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id('nim');
            $table->string('nama');
            $table->string('email');
            $table->unsignedBigInteger('id_prodi');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('no_hp');
            $table->timestamps();
            $table->softDeletes(); 

             // Penghubungan ke tabel prodi
             $table->foreign('id_prodi')->references('id')->on('prodi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};