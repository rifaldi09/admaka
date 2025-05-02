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
        DB::statement('DROP VIEW IF EXISTS view_menus_by_role');

        DB::statement("
            CREATE VIEW view_menus_by_role AS
            SELECT 
                m.id_menu,
                m.header,
                m.menu,
                m.url,
                m.icon,
                ra.id_role
            FROM 
                menu m
            JOIN 
                role_akses ra ON m.id_menu = ra.id_menu;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        
    }
};