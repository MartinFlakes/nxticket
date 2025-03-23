<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'pivot'];

    //
    use HasFactory;
}
