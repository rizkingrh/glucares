<?php

namespace App\Http\Controllers;

use App\Models\QrScan;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\TemporaryScan;
use App\Services\MqttService;
use Illuminate\Support\Facades\Auth;

class QrScanController extends Controller
{
    protected $mqttService;

    public function __construct(MqttService $mqttService)
    {
        $this->mqttService = $mqttService;
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'patient_id' => 'required|exists:patients,id'
        ]);

        // Get patient information
        $patient = Patient::find($request->patient_id);

        // Create QR scan record
        QrScan::create([
            'patient_id' => $request->patient_id,
            'scanned_by' => Auth::id(),
            'scanned_at' => now(),
        ]);

        // Create temporary scan record
        TemporaryScan::create([
            'patient_id' => $request->patient_id,
        ]);

        // Prepare data to send to MQTT broker
        $patientData = [
            'id' => $patient->id,
            'name' => $patient->name ?? 'Unknown',
        ];

        // Send data to MQTT broker
        $this->mqttService->publishPatientScan($patientData);

        return response()->json(['success' => true, 'patient_data' => $patientData]);
    }
}
