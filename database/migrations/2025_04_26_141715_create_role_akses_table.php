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
        Schema::create('role_akses', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->unsignedBigInteger('id_role');
            $table->unsignedBigInteger('id_akses');
            $table->timestamps();

            // Penghubungan ke tabel roles
            $table->foreign('id_role')->references('id_role')->on('roles')->onDelete('cascade');
            // Penghubungan ke tabel hak_akses
            $table->foreign('id_akses')->references('id_akses')->on('hak_akses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_akses');
    }
};
