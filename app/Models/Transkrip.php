<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transkrip extends Model
{
    use HasFactory;

    protected $table = 'transkrip_nilai';
    protected $primaryKey = 'id_transkrip';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'keperluan',
        'status',
        'no_surat',
        'alasan_ditolak'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_transkrip)) {
                $model->id_transkrip = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function filePermohonan()
    {
        return $this->hasMany(FilePengajuan::class, 'id_pengajuan', 'id_transkrip');
    }
}