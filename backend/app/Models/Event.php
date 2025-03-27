<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'image_url',
        'start_date',
        'end_date',
        'category_id',
        'venue_id',
        'user_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $dates = [
        'start_date',
        'end_date'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories(){
        return $this->belongsTo(Category::class, 'category_id')->select('categories.id', 'categories.name');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function venue(){
        return $this->belongsTo(Venue::class, 'venue_id')->select('venues.id', 'venues.name', 'venues.address', 'venues.city', 'venues.state');
    }
    public function hosts(){
        return $this->BelongsToMany(Host::class);
    }

    //
}
