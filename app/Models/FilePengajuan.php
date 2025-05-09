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

    public function pengajuanKp()
    {
        return $this->belongsTo(PengajuanKP::class);
    }
}
