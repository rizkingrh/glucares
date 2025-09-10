<?php

namespace App\Http\Controllers;

use App\Models\QrScan;
use Illuminate\Http\Request;
use App\Models\TemporaryScan;
use Illuminate\Support\Facades\Auth;

class QrScanController extends Controller
{
    public function store(Request $request)
    {
        QrScan::create([
            'patient_id' => $request->patient_id,
            'scanned_by' => Auth::id(),
            'scanned_at' => now(),
        ]);

        TemporaryScan::create([
            'patient_id' => $request->patient_id,
        ]);

        return response()->json(['success' => true]);
    }
}
