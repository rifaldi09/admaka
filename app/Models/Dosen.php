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
    protected $primaryKey = 'nidn';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'nidn',
        'nip',
        'nama',
        'email',
        'id_prodi',
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp'
    ];
    // relasi ke tabel prodi (1 mahasiswa punya 1 prodi)
    public function roleAkses()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }
}