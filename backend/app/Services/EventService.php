<?php
namespace App\Services;
use App\Models\Event;
use App\Models\Zone;
use App\Models\Seat;

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
        return Event::with(['categories', 'hosts'])->paginate(10);
    }
    
    public function getEventsDetail($idEvent){
        $event = Event::with(['categories', 'hosts', 'venue'])->find($idEvent);
        if ($event && $event->venue) {
            $zones = Zone::where('venue_id', $event->venue->id)->get();
            // colocar dento del objeto venue
            // si existe un venue puedes buscar una zona
            $event->venue->zones = $zones;
            // recorre cada zona y devuelve la coleccion de asientos
            foreach ($zones as $zone) {
                $zone->seats = Seat::where('zone_id', $zone->id)->get();
            }
            $event->venue->zones = $zones;
        }
        return $event;
    }
    public function getEventByuser($userId)
    {
        return Event::with(['categories', 'hosts'])
                    ->where('user_id', $userId)
                    ->paginate(10);
    }
    public function getEventByHost($hostId)
    {
        return Event::with(['categories', 'hosts'])
                    ->whereHas('hosts', function ($query) use ($hostId) {
                        $query->where('hosts.id', $hostId);
                    })
                    ->paginate(10);
    }
    public function getEventBytitle($title)
    {
        return Event::with(['categories', 'hosts'])
                    ->where('title', 'like', '%' . $title . '%')
                    ->paginate();
    }
    public function getEventsByDateRange($startDate, $endDate)
    {
        return Event::with(['categories', 'hosts'])
                    ->whereBetween('event_date', [$startDate, $endDate])
                    ->paginate(10);
    }
    public function getEventByCategory($idCategory){
        return Event::with(['categories', 'hosts'])->where('category_id',$idCategory)->paginate(10);
        
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
