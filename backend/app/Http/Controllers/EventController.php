<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    //
    protected $eventService;
    protected $categoryService;

    public function __construct(EventService $eventService, CategoryService $categoryService){
        $this->eventService = $eventService;
        $this->categoryService = $categoryService;
    }

    public function events()
    {
        $events = $this->eventService->getEvents();
        return response()->json($events);
    }
    public function eventsByuser($ownerId)
    {
        $events = $this->eventService->getEventByuser($ownerId);
        return response()->json($events);
    }
    public function eventsByHost($hostId)
    {
        $events = $this->eventService->getEventByHost($hostId);
        return response()->json($events);
    }
    public function eventsByCategory($idCategory){
        $events = $this->eventService->getEventByCategory($idCategory);
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
    public function eventsDetail($idEvent){
        $event = $this->eventService->getEventsDetail($idEvent);
        return response()->json($event);
    }
    public function getAllCategories()
    {
        $categories = $this->categoryService->getCategories();
        return response()->json($categories);
    }

    public function createEvent(Request $request)
    {
        $event = $this->eventService->createEvent($request);
        return response()->json($event, 201);
    }

}
