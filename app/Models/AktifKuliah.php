<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AktifKuliah extends Model
{
    use HasFactory;
    protected $table = "aktif_kuliah";
    protected $primaryKey = "id_aktif_kuliah";
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        "user_id",
        "keperluan",
        "status",
        "alasan"
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_aktif_kuliah)) {
                $model->id_aktif_kuliah = (string) Str::uuid();
            }
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function filePengajuan()
    {
        return $this->hasMany(FilePengajuan::class, 'id_pengajuan', 'id_aktif_kuliah');
    }
}
