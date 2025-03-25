<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'row',
        'number',
        'zone_id'
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
