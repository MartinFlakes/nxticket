<?php
namespace App\Services;
use App\Models\Venue;

use Illuminate\Http\Request;

class VenueService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createVenue($data)
    {
        $venue = Venue::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'city' => $data['city'],
            'state' => $data['state'],
            'zip' => $data['zip']
        ]);

        return $venue;
    }

}
