<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SuratRekomendasi extends Model
{
    use HasFactory;
    protected $table = "surat_rekomendasi";
    protected $primaryKey = "id_rekomendasi";
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        "user_id",
        "nomor_surat",
        "perihal",
        "tempat_perihal",
        "konversi_sks",
        "status",
        "alasan_ditolak"
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_rekomendasi)) {
                $model->id_rekomendasi = (string) Str::uuid();
            }
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function filePengajuan()
    {
        return $this->hasMany(FilePengajuan::class, 'id_pengajuan', 'id_rekomendasi');
    }
}
