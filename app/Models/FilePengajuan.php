<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilePengajuan extends Model
{
    use HasFactory;
    
    protected $table = "file_pengajuan";

    protected $fillable = [
        "path",
        "id_pengajuan"
    ];

    // mengambil 1 data pengajuan KP
    public function dataPengajuanKP()
    {
        return $this->hasOne(PengajuanKP::class, 'id_pengajuan', 'id_pengajuan');
    }

    // mengambil 1 data Transkrip
    public function dataTranskrip()
    {
        return $this->hasOne(Transkrip::class, 'id_transkrip', 'id_pengajuan');
    }

    // mengambil 1 data permohonan
    public function dataPermohonan()
    {
        return $this->hasOne(Transkrip::class, 'id_permohonan', 'id_pengajuan');
    }

    // mengambil 1 data Aktif Kuliah
    public function dataAktifKuliah()
    {
        return $this->hasOne(AktifKuliah::class, 'id_aktif_kuliah', 'id_pengajuan');
    }
}
