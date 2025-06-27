<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nim',
        'nama',
        'email',
        'id_prodi',
        'tempat_lahir',
        'tanggal_lahir',
        'no_hp',
        'jenjang',
        'semester',
        'tahun_akademik',
        'ipk',
        'sks'
    ];

    // relasi ke tabel prodi (1 mahasiswa punya 1 prodi)
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'id_prodi');
    }
}
