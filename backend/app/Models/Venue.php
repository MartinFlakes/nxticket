<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Venue extends Model
{
    //
    use HasFactory;

    public function getMaxRegistrations($eventId)
    {
        return DB::table('registrations')
            ->where('event_id', $eventId)
            ->max('event_id');
    }
}
