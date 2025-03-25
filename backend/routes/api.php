<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;

// Rutas de autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::post('/me', [AuthController::class, 'me']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json(['message' => '¡Hola desde Laravel!']);
});

Route::get('/events', [EventController::class, 'events']);
Route::get('/events/host/{hostId}', [EventController::class, 'eventsByHost']);
Route::get('/events/title/{title}', [EventController::class, 'eventsByTitle']);
Route::get('events/categories/{category_id}',[EventController::class, 'eventsByCategory']);
Route::get('events/detail/{idEvent}',[EventController::class, 'eventsDetail']);

