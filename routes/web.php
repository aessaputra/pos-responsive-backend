<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'application_name' => config('app.name'),
        'status' => 'API is running',
        'environment' => config('app.env'),
        'timestamp' => now()
    ]);
});
