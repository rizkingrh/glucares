<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemporaryScanController;
use App\Http\Controllers\HistoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Temporary Scan API Routes
Route::get('/get-data-patient', [TemporaryScanController::class, 'getScanData']);

// History API Routes
Route::post('/store-data-history', [HistoryController::class, 'storeData']);
