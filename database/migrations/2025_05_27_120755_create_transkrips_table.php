<?php

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
        Schema::create('transkrip_nilai', function (Blueprint $table) {
            $table->uuid('id_transkrip');
            $table->foreignIdFor(User::class)->constrained(); // foreign key ke users.id
            $table->string('keperluan');
            $table->enum('status', ['Belum Diterima', 'Diterima', 'Ditolak' , 'Penerbitan'])->default('Belum Diterima');
            $table->string('alasan_ditolak')->nullable()->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transkrip_nilai');
    }
};
