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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('id_user'); // sebelumnya username di ganti dengan id_user yang merujuk ke nim/nidn
            $table->string('password');
            $table->unsignedBigInteger('id_role');
            $table->rememberToken();
            $table->timestamps();

            // Penghubungan ke tabel role
            $table->foreign('id_role')->references('id')->on('role')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};