<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'capacity',
        'price',
        'venue_id'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
