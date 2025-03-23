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

    //columnas que no se muestran
    protected $hidden = ['created_at', 'updated_at', 'deleted_at' ,'category_id', 'venue_id', 'owner_id'];

    //Define la relacion con el otro modelo
    public function hosts(){
        //se define como host.id para que no haya problema de amniguedad en la consulta
        return $this->belongsToMany(Host::class)->select(['hosts.id','hosts.name']);
    }

    public function categories(){
        return $this->belongsTo(Category::class)->select(['categories.id', 'categories.name']);
    }

    public function owner(){
        return $this->belongsTo(Owner::class)->select('owners.id', 'owners.name');
    }
    //
}
