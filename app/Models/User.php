<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// ubah model default users menjadi mahasiswa
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_user',
        'password',
        'id_role',
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected $casts = [
        'password' => 'hashed',
    ];

    // mengambil 1 data mahasiswa
    public function dataMahasiswa() {
        return $this->hasOne(Mahasiswa::class, 'nim', 'id_user');
    }

    // mengambil 1 data dosen
    public function dataDosen() {
        return $this->hasOne(Dosen::class, 'nidn', 'id_user');
    }

    // function yang ini gunanya biar $user->data itu bisa dinamis sesuai data yang lagi login sekarang
    public function getDataAttribute()
    {
        return $this->dataMahasiswa()->first() ?? $this->dataDosen()->first();
    }

    // relasi ke tabel role_akses
    public function roleAkses()
    {
        return $this->hasMany(RoleAkses::class, 'id_role');
    }

    // relasi ke tabel pengajuan-kp
    public function pengajuanKp()
    {
        return $this->hasMany(PengajuanKP::class, 'user_id');
    }

    // relasi ke tabel permohonan-pengambilan
    public function permohonanPengambilan()
    {
        return $this->hasMany(PPDP::class, 'user_id');
    }

    // relasi ke transkrip
    public function transkrip()
    {
        return $this->hasMany(Transkrip::class, 'user_id');
    }
}