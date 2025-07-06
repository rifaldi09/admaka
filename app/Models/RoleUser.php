<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;
    // Nama tabel (jika tidak standar plural, misal 'role_users')
    protected $table = 'role_user';

    // Primary key jika tidak 'id', tapi di sini pakai 'id'
    protected $primaryKey = 'id';

    // Jika primary key auto increment dan integer
    public $incrementing = true;
    protected $keyType = 'int';

    // Jika pakai timestamps (created_at dan updated_at)
    public $timestamps = true;

    // Field yang bisa diisi mass assignment
    protected $fillable = [
        'user_id',
        'role_id',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}