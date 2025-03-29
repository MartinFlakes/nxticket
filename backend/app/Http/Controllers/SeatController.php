<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SeatService;

class SeatController extends Controller
{
    protected $seatService;

    public function __construct(SeatService $seatService)
    {
        $this->seatService = $seatService;
    }

    public function createSeat(Request $request)
    {
        $data = $request->validate([
            'row' => 'required|string|max:255',
            'number' => 'required|integer',
            'zone_id' => 'required|integer|exists:zones,id'
        ]);

        $seat = $this->seatService->create($data);

        return response()->json([
            'message' => 'Seat created successfully',
            'seat' => $seat
        ], 201);
    }

    public function getSeatsByEvent($eventId, $available = false)
    {
        $seats = $this->seatService->getSeatsByEvent($eventId, $available);

        return response()->json($seats);
    }
}
