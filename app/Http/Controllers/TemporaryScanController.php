<?php

namespace App\Http\Controllers;

use App\Models\TemporaryScan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TemporaryScanController extends Controller
{
    /**
     * Get all temporary scan data and delete them after sending
     *
     * @return JsonResponse
     */
    public function getScanData(): JsonResponse
    {
        try {
            $temporaryScans = TemporaryScan::with('patient')->get();
            
            if ($temporaryScans->isEmpty()) {
                return response()->json([
                    'error' => true,
                    'message' => 'No temporary scan data found in the database',
                ], 404);
            }
            
            $scansData = $temporaryScans->map(function ($scan) {
                return [
                    'patient_id' => $scan->patient_id,
                    'patient_name' => $scan->patient->name,
                ];
            });
            
            TemporaryScan::truncate();
            
            return response()->json([
                'error' => false,
                'message' => 'Temporary scans retrieved and deleted successfully',
                'data' => $scansData,
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
