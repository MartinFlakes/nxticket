<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\ZoneController;

// Rutas de autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    Route::post('/venue', [VenueController::class, 'createVenue']);

    Route::post('/zone', [ZoneController::class, 'createZone']);

    Route::post('/event_registration/{eventId}', [RegistrationController::class, 'event_registration']);
});

Route::get('/user/myevents/{idUser}', [RegistrationController::class, 'getUserEventsRegistration']);

Route::get('/events', [EventController::class, 'events']);
Route::get('/events/host/{hostId}', [EventController::class, 'eventsByHost']);
Route::get('/events/title/{title}', [EventController::class, 'eventsByTitle']);
Route::get('/events/categories/{category_id}',[EventController::class, 'eventsByCategory']);
Route::get('/events/{idEvent}',[EventController::class, 'eventsDetail']);
// devolver eventos que se registro un usuario, no los que creo
//esta incompleto
Route::get('/events/myevents/{useId}',[EventController::class, 'eventsByUser']);


Route::get('/categories',[EventController::class, 'getAllCategories']);

Route::post('/events/create', [EventController::class, 'createEvent']);
Route::get('/venues', [VenueController::class, 'getVenues']);