<?php
namespace App\Services;
use App\Models\Registration;

class RegistrationService{


    public function __construct()
    {
        //
    }

    public function register($data, $eventId){
        Registration::create([
            'event_id' => $eventId,
            'user_id' => $data['user_id'],
            'seat_id' => $data['seat_id']
        ]);
        return true;
    }
}