<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\returnSelf;

class Event extends Model
{
    use HasFactory;

    // columnas que no se registran;
    protected $fillable =[];

    //Define la relacion con el otro modelo
    public function hosts(){
        return $this->belongsToMany(Host::class);
    }

    public function categories(){
        return $this->belongsTo(Category::class);
    }
    //
}
