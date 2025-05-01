<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menu';
    protected $primaryKey = 'id_menu';
    protected $fillable = [
        'header',
        'menu',
        'url',
        'icon',
    ];

    // relasi ke tabel role_akses
    public function roleAkses()
    {
        return $this->hasMany(RoleAkses::class, 'id_menu');
    }
}