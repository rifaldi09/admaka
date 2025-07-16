<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dosen extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'dosen';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'nip',
        'nidn',
        'status_pegawai',
        'nama',
        'email',
        'id_prodi',
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp'
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }

    // relasi ke tabel role akses
    public function roleAkses()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }

    public function ppdp()
    {
        return $this->belongsTo(PPDP::class, 'nip', 'nip');
    }
}
