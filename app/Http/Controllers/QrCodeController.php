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
        $qrCodeDir = public_path('qr-code');
        if (!File::exists($qrCodeDir)) {
            File::makeDirectory($qrCodeDir, 0755, true);
        }

        $svg = QrCode::format('svg')
            ->size(300)
            ->margin(2)
            ->generate($patient->id);

        $filePath = public_path("qr-code/patient-qr-{$patient->id}.svg");
        file_put_contents($filePath, $svg);

        return response()->download($filePath, "patient-qr-{$patient->id}.svg", [
            'Content-Type' => 'image/svg+xml',
        ]);
    }
}
