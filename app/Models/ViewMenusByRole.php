<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewMenusByRole extends Model
{
    protected $table = 'view_menus_by_role';

    // Karena ini view tidak ada timestamp (created_at, updated_at)
    public $timestamps = false;

    // kasih tahu Eloquent bahwa tida de primarykey
    protected $primaryKey = null;
    public $incrementing = false;
}