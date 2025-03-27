<?php

namespace App\Services;
use App\Models\Seat;
use App\Models\Venue;
use App\Models\Zone;


class VenueService{
    

    public function getVenues(){
        // se obtienen todos los lugares con sus zonas y asientos
        $venues = Venue::all();

        // se obtiene las zonas de cada venue
        foreach($venues as $venue){
            $zones = Zone::where('venue_id', $venue->id)->get();

            // asignar zonas
            $venue->zones = $zones;

            // si existen las zonas buscar sus lugares
            foreach($zones as $zone){
                $seats = Seat::where('zone_id', $zone->id)->get();
                $zone->seats = $seats;
            }
        }
        return $venues;
    }
}
