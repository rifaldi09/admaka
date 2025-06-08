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
            $table->rememberToken();
            $table->timestamps();
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