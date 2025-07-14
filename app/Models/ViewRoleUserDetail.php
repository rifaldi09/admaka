<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewRoleUserDetail extends Model
{
    protected $table = 'view_role_user_detail';

    // Karena ini view tidak ada timestamp (created_at, updated_at)
    public $timestamps = false;

    // kasih tahu Eloquent bahwa tida de primarykey
    protected $primaryKey = null;
    public $incrementing = false;


    public function roles()
    {
     return $this->belongsToMany(Role::class, 'id', 'role_id');
    }
}