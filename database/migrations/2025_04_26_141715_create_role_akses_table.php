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
            $table->id('id_role_akses')->autoIncrement();
            $table->unsignedBigInteger('id_role');
            $table->unsignedBigInteger('id_menu');
            $table->timestamps();

            // Penghubungan ke tabel role
            $table->foreign('id_role')->references('id')->on('role')->onDelete('cascade');
            // Penghubungan ke tabel hak_akses
            $table->foreign('id_menu')->references('id_menu')->on('menu')->onDelete('cascade');
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