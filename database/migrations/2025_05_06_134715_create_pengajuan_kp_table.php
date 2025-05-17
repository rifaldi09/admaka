<?php

use App\Models\Prodi;
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
        Schema::create('pengajuan_kp', function (Blueprint $table) {
            $table->uuid('id_pengajuan')->primary();
            $table->foreignIdFor(User::class)->constrained(); // foreign key ke users.id
            $table->unsignedBigInteger('id_prodi');
            $table->string('no_surat')->nullable()->default('');
            $table->string('tujuan_surat');
            $table->text('alamat_surat');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['Belum Diterima', 'Diterima', 'Ditolak' , 'Penerbitan'])->default('Belum Diterima');
            $table->string('alasan_ditolak')->nullable()->default('');
            $table->timestamps();

            $table->foreign('id_prodi')->references('id')->on('prodi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_kp');
    }
};
