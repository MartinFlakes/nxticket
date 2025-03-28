<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;
use App\Services\ZoneService;

class ZoneController extends Controller
{
    protected $zoneService;

    public function __construct(ZoneService $zoneService)
    {
        $this->zoneService = $zoneService;
    }
    
    public function createZone(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer',
            'price' => 'required|numeric',
            'venue_id' => 'required|integer|exists:venues,id'
        ]);

        $zone = $this->zoneService->create($data);

        return response()->json([
            'message' => 'Zone created successfully',
            'zone' => $zone
        ], 201);
    }
}
