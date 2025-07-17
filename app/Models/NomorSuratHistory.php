<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NomorSuratHistory  extends Model
{
    use HasFactory;
    protected $table = 'nomor_surat_history';
    protected $primaryKey = 'id';

    protected $fillable = [
        'no_surat',
        'tahun',
        'nama_surat',
        'id_surat',
    ];
    
    public $timestamps = true;
 
}