<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HakAkses extends Model
{
    use HasFactory;
    protected $table = 'hak_akses';
    protected $primaryKey = 'id_akses';
    protected $fillable = [
        'header',
        'menu',
        'url',
        'icon',
    ];

    // relasi ke tabel role_akses
    public function roleAkses()
    {
        return $this->hasMany(RoleAkses::class, 'id_akses');
    }
}
