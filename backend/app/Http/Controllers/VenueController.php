<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\VenueService;

class VenueController extends Controller
{
    protected $venueService;
    
    public function __construct(VenueService $venueService){
        $this->venueService = $venueService;
    }

    public function getVenues()
    {
        $venueService = new VenueService();
        $venues = $venueService->getVenues();
        return response()->json($venues);
    }

    public function createVenue(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:10'
        ]);

        $venue = $this->venueService->createVenue($data);

        return response()->json([
            'message' => 'Venue created successfully',
            'venue' => $venue
            ], 201);
    }
}
