<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Host extends Model
{
    //
    protected $hidden = ['created_at', 'updated_at', 'deleted_at' ,'pivot'];

    use HasFactory;

    public function events(){
        return $this->belongsToMany(Event::class);
    }

    public function categories(){
        return $this->belongsTo(Category::class);
    }
}
