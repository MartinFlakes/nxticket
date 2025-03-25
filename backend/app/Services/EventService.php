<?php
namespace App\Services;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

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
    public function getEventsDetail($idEvent){
        $event = Event::with(['categories', 'owner', 'hosts', 'venue'])->find($idEvent);
        if ($event && $event->venue) {
            $event->max_registrations = $event->venue->getMaxRegistrations($idEvent);
        }
        return $event;
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
    public function getEventByCategory($idCategory){
        return Event::with(['categories', 'owner', 'hosts'])->where('category_id',$idCategory)->paginate(10);
        
    }
    public function createEvent(Request $request){
        $event = new Event;

        $event->name = $request->name;
        $event->description = $request->description;
        $event->event_date = $request->event_date;
        $event->category_id = $request->category_id;
        $event->venue_id = $request->venue_id;
        $event->owner_id = $request->owner_id;

        $event->save();

        if ($request->hosts) {
            $event->hosts()->attach($request->hosts);
        }

        return $event;
    }

}
