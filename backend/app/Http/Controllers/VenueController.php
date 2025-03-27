<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VenueService;

class VenueController extends Controller
{
    //
    public function getVenues()
    {
        $venueService = new VenueService();
        $venues = $venueService->getVenues();
        return response()->json($venues);
    }
}
