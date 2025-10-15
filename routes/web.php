<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\QrScanController;
use App\Http\Controllers\RecordController;

// Home | landing page
Route::get('/', function () {
    return view('home');
});
Route::get('/record', [RecordController::class, 'index'])->name('record.index');
Route::post('/record/qr-scan', [RecordController::class, 'processQrScan'])->name('record.qr-scan');
Route::post('/record/clear-scan', [RecordController::class, 'clearScan'])->name('record.clear-scan');

// Admin panel
Route::get('/patient/{patient}/qr-download', [QrCodeController::class, 'downloadPatientQrCode'])
    ->name('patient.qr-download');

Route::post('/qr-scanner/store', [QrScanController::class, 'store'])->name('qr-scanner.store');
