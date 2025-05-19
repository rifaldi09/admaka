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
        Schema::create('file_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->uuid('id_pengajuan'); // foreign key ke tabel pengajuan kp
            $table->string('path');
            $table->timestamps();

            // $table->foreign('id_pengajuan')->references('id_pengajuan')->on('pengajuan_kp')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_pengajuan');
    }
};
