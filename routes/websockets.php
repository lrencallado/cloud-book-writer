<?php

use BeyondCode\LaravelWebSockets\Http\Controllers\WebSocketController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('app')->group(function () {
    Route::post('/broadcasting/auth', function() {
        if (!Auth::check()) {
            return abort(403, 'Unauthorized');
        }

        // Return the authenticated user's information
        return Auth::user();
    });
});
