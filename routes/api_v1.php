<?php

use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// http://localhost:8000/api/
// univseral resource locator
// tickets
// users


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::get('users/{user}/tickets', [\App\Http\Controllers\Api\V1\UserTicketsController::class, 'index']);
    Route::apiResource('users.tickets', \App\Http\Controllers\Api\V1\UserTicketsController::class)->except('update');
    Route::put('users/{user}/tickets/{ticket}', [\App\Http\Controllers\Api\V1\UserTicketsController::class, 'replace'])->name('users.tickets.replace');
    Route::apiResource('tickets', TicketController::class)->except('update');
    Route::patch('tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::put('tickets/{ticket}', [TicketController::class, 'replace'])->name('tickets.replace');
});
