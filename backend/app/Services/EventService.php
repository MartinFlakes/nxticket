<?php
namespace App\Services;
use App\Models\Event;
use App\Models\Category;




class EventService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    
    // categories se devuelve como null
    public function getEvents()
    {
        // se devuelve con sus relaciones
        return Event::with(['categories', 'owner', 'hosts'])->paginate(10);
    }
    public function getEventByOwner($ownerId)
    {
        return Event::with(['categories', 'owner', 'hosts'])
                    ->where('owner_id', $ownerId)
                    ->paginate(10);
    }
    public function getEventByHost($hostId)
    {
        return Event::with(['categories', 'owner', 'hosts'])
                    ->whereHas('hosts', function ($query) use ($hostId) {
                        $query->where('hosts.id', $hostId);
                    })
                    ->paginate(10);
    }
    public function getEventBytitle($title)
    {
        return Event::with(['categories', 'owner', 'hosts'])
                    ->where('title', 'like', '%' . $title . '%')
                    ->paginate();
    }
    public function getEventsByDateRange($startDate, $endDate)
    {
        return Event::with(['categories', 'owner', 'hosts'])
                    ->whereBetween('event_date', [$startDate, $endDate])
                    ->paginate(10);
    }
}
