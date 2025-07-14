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
        // hapus view jika sudah ada karna migration tidak menghapus view
        DB::statement('DROP VIEW IF EXISTS view_role_user_detail');

        DB::statement("
            CREATE VIEW view_role_user_detail AS
            SELECT 
                ru.id AS role_user_id,
                u.id AS user_id,
                u.id_user AS id_user,
                r.id AS role_id,
                r.name_role AS name_role,
                COALESCE(m.nama, d.nama) AS nama_user
            FROM 
                role_user ru
            JOIN 
                users u ON ru.user_id = u.id
            JOIN 
                role r ON ru.role_id = r.id
            LEFT JOIN 
                mahasiswa m ON m.nim = u.id_user
            LEFT JOIN 
                dosen d ON d.nidn = u.id_user;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        
    }
};