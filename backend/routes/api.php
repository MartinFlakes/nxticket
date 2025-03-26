<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function () {
    return response()->json(['message' => '¡Hola desde Laravel!']);
});

Route::get('/events', [EventController::class, 'events']);
Route::get('/events/owner/{ownerId}', [EventController::class, 'eventsByOwner']);
Route::get('/events/host/{hostId}', [EventController::class, 'eventsByHost']);
Route::get('/events/title/{title}', [EventController::class, 'eventsByTitle']);
Route::get('events/categories/{category_id}',[EventController::class, 'eventsByCategory']);
Route::get('events/detail/{idEvent}',[EventController::class, 'eventsDetail']);

