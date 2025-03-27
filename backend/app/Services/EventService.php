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
    public function createEvent(Request $request)
    {
        $imageService = new ImageService();
     
        try {
            $event = Event::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'image_url' => $imageService->uploadImage($request->file('image')) ,
                'start_date' => $request->input('start_date'), 
                'end_date' => $request->input('end_date'),
                'category_id' => $request->input('category_id'),
                'venue_id' => $request->input('venue_id'),
                'user_id' => $request->input('user_id'),
            ]);
            // asignar al evento los hosts
            if ($request->has('hosts') || is_array($request->input('hosts'))) {
                $event->hosts()->attach($request->input('hosts'));
            }
            return response()->json(['success' => true, 'event' => $event], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

}
