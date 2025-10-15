<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\QrScanController;

Route::get('/', function () {
    return view('home');
});

Route::get('/patient/{patient}/qr-download', [QrCodeController::class, 'downloadPatientQrCode'])
    ->name('patient.qr-download');

Route::post('/qr-scanner/store', [QrScanController::class, 'store'])->name('qr-scanner.store');
