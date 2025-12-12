<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class QrCodeController extends Controller
{
    public function downloadPatientQrCode(Patient $patient)
    {
        // Generate QR code SVG
        $qrCodeSvg = QrCode::format('svg')
            ->size(300)
            ->margin(2)
            ->generate($patient->id);

        // Pass data to the printable view
        return view('patient-qr-card', [
            'patient' => $patient,
            'qrCodeSvg' => $qrCodeSvg,
        ]);
    }
}
