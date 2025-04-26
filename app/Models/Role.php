<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey = 'id_role';
    protected $fillable = [
        'role',
    ];

    // relasi ke tabel mahasiswa
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'id_role');
    }

    // relasi ke tabel role_akses
    public function roleAkses()
    {
        return $this->hasMany(RoleAkses::class, 'id_role');
    }
}
