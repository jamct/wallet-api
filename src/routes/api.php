<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketsController;

Route::controller(TicketsController::class)->group(function () {
    Route::post('/tickets/event', 'createEventTicket');
});
