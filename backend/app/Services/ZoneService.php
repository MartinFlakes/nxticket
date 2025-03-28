<?php

namespace App\Services;
use App\Models\Zone;

class ZoneService
{
    public function create($data)
    {
        $zone = Zone::create([
            'name' => $data['name'],
            'capacity' => $data['capacity'],
            'price' => $data['price'],
            'venue_id' => $data['venue_id'],
        ]);
        return $zone;
    }
}