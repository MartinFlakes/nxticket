<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Host extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'bio',
        'photo',
        'email'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'pivot'
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
}
