<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    //
    protected $eventService;

    public function __construct(EventService $eventService){
        $this->eventService = $eventService;
    }

    public function events()
    {
        $events = $this->eventService->getEvents();
        return response()->json($events);
    }
    public function eventsByOwner($ownerId)
    {
        $events = $this->eventService->getEventByOwner($ownerId);
        return response()->json($events);
    }
    public function eventsByHost($hostId)
    {
        $events = $this->eventService->getEventByHost($hostId);
        return response()->json($events);
    }
    public function eventsByTitle($title)
    {
        $events = $this->eventService->getEventByTitle($title);
        if (empty($events)) {
            return response()->json(['message' => 'No events found'], 404);
        }
        return response()->json($events);
    }

}
