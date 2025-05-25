<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PPDP extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = "permohonan_pengambilan";
    protected $primaryKey = "id_permohonan";
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        "user_id",
        "id_prodi",
        "nidn",
        "no_surat",
        "tujuan_surat",
        "alamat_surat",
        "keperluan",
        "judul_skripsi",
        "tanggal_mulai",
        "tanggal_selesai",
        "status",
        "alasan_ditolak"
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_permohonan)) {
                $model->id_permohonan = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'nidn', 'nidn');
    }

    public function filePermohonan()
    {
        return $this->hasMany(FilePermohonan::class, 'id_permohonan', 'id_permohonan');
    }
}
