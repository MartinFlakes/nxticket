<?php

namespace App\Services;
use App\Models\Seat;

class SeatService
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

    public function getSeatsByEvent($eventId, $available = false)
    {
        if ($available == false) {
            return Seat::where('event_id', $eventId)
                ->where('status', 'available')
                ->with(['zone.venue'])
                ->get();
        }
        else {
            // Buscar en la tabla de registrations los registros por el event_id y devolver los asientos que no aparezcan en la tabla
            return Seat::where('event_id', $eventId)
                ->whereNotIn('id', function($query) use ($eventId) {
                    $query->select('seat_id')
                        ->from('registrations')
                        ->where('event_id', $eventId);
                })
                ->with(['zone.venue'])
                ->get();
        }
    }
}