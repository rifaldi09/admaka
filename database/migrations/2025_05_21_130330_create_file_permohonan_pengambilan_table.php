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
        Schema::create('file_permohonan_pengambilan', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_permohonan'); // foreign key ke tabel pengajuan permohonan_pengambilan
            $table->string('path');
            $table->timestamps();

            $table->foreign('id_permohonan')->references('id_permohonan')->on('permohonan_pengambilan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_permohonan_pengambilan');
    }
};
