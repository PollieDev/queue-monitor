<?php

use Illuminate\Support\Facades\Route;
use QueueMonitor\Http\Controllers\DashboardController;
use QueueMonitor\Http\Middleware\HandleInertiaRequests;

Route::middleware(['web', HandleInertiaRequests::class])->prefix('queue-monitor')->group(function() {
    Route::get('/', [DashboardController::class, 'home']);
    Route::get('/jobs', [DashboardController::class, 'jobs']);
    Route::get('/activity', [DashboardController::class, 'activity']);
    Route::get('/activity/{id}', [DashboardController::class, 'activityDetails']);
});