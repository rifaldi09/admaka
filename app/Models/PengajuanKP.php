<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PengajuanKP extends Model
{
    use HasFactory;

    protected $table = "pengajuan_kp";
    protected $primaryKey = "id_pengajuan";
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        "user_id",
        "id_prodi",
        "no_surat",
        "tujuan_surat",
        "alamat_surat",
        "tanggal_mulai",
        "tanggal_selesai",
        "status",
        "alasan_ditolak"
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_pengajuan)) {
                $model->id_pengajuan = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function filePengajuan()
    {
        return $this->hasMany(FilePengajuan::class, 'id_pengajuan', 'id_pengajuan');
    }
}
