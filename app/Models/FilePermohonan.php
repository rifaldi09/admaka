<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilePermohonan extends Model
{
    use HasFactory;
    
    protected $table = "file_permohonan_pengambilan";

    protected $fillable = [
        "path",
        "id_permohonan"
    ];

    // mengambil data permohonan
    public function dataPermohonan()
    {
        return $this->hasOne(PPDP::class, 'id_permohonan', 'id_permohonan');
    }
}
