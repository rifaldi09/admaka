<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;
    protected $table = 'prodi';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'nama'
    ];

    // relasi prodi ke user
    public function mahasiswa()
    {
        return $this->hasMany(User::class);
    }
}