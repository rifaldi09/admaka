<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleAkses extends Model
{
    use HasFactory;
    protected $table = 'role_akses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_role',
        'id_akses',
    ];
    // relasi ke tabel role
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
    // relasi ke tabel hak_akses
    public function hakAkses()
    {
        return $this->belongsTo(HakAkses::class, 'id_akses','id_akses');
    }
}
