<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CategoryService;
use App\Services\RegistrationService;

class RegistrationController extends Controller
{
    protected $registrationService;
    protected $categoryService;

    public function __construct(RegistrationService $registrationService, CategoryService $categoryService){
        $this->registrationService = $registrationService;
        $this->categoryService = $categoryService;
    }

    public function event_registration(Request $request, $eventId)
    {
        $request->validate([
            'seat_id' => 'required'
        ]);

        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $registration = $this->registrationService->register([
            'user_id' => $user->id,
            'seat_id' => $request->seat_id
        ], $eventId);

        return response()->json($registration);
    }
}
