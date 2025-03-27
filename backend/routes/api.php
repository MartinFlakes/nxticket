<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthController;

// Rutas de autenticación
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh', [AuthController::class, 'refresh']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
});

Route::get('/test', function () {
    return response()->json(['message' => '¡Hola desde Laravel!']);
});

Route::get('/events', [EventController::class, 'events']);
Route::get('/events/host/{hostId}', [EventController::class, 'eventsByHost']);
Route::get('/events/title/{title}', [EventController::class, 'eventsByTitle']);
Route::get('/events/categories/{category_id}',[EventController::class, 'eventsByCategory']);
Route::get('/events/detail/{idEvent}',[EventController::class, 'eventsDetail']);
Route::get('/events/myevents/{useId}',[EventController::class, 'eventsByUser']);


Route::get('/events/categories',[EventController::class, 'getAllCategories']);

