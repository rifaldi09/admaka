<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NomorSuratCounter  extends Model
{
    use HasFactory;
    protected $table = 'nomor_surat_counters';
    protected $primaryKey = 'id';

    protected $fillable = [
        'no_surat',
        'tahun',
        'nama_surat',
        'id_surat',
        'counter',
    ];
    
    public $timestamps = true;
 
}