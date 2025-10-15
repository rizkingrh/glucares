<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use App\Models\Patient;
use App\Models\QrScan;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;

class RecordController extends Controller
{
    /**
     * Display the record page
     */
    public function index(Request $request)
    {
        $scannedPatient = null;
        $histories = collect();
        $currentPage = 1;
        $perPage = 10;
        $total = 0;

        // Check if there's a scanned patient ID in session or request
        $patientId = $request->get('patient_id') ?? Session::get('scanned_patient_id');
        
        if ($patientId) {
            // Get patient information
            $scannedPatient = Patient::find($patientId);
            
            if ($scannedPatient) {
                // Store in session for persistence
                Session::put('scanned_patient_id', $patientId);
                
                // Get histories for this patient with pagination
                $currentPage = $request->get('page', 1);
                $historiesQuery = History::where('patient_id', $patientId)
                    ->orderBy('created_at', 'desc');
                
                $total = $historiesQuery->count();
                $histories = $historiesQuery
                    ->skip(($currentPage - 1) * $perPage)
                    ->take($perPage)
                    ->get();
            }
        }

        // Create manual pagination
        $paginatedHistories = new LengthAwarePaginator(
            $histories,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'pageName' => 'page',
                'query' => $request->query()
            ]
        );

        return view('record', compact('scannedPatient', 'paginatedHistories'));
    }

    /**
     * Process QR scan and redirect to records
     */
    public function processQrScan(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|string|exists:patients,id'
        ]);

        // Handle JSON requests from QR scanner
        if ($request->expectsJson() || $request->header('Content-Type') === 'application/json') {
            // Store in session for next request
            Session::put('scanned_patient_id', $request->patient_id);
            
            return response()->json([
                'success' => true,
                'message' => 'QR scan processed successfully',
                'redirect_url' => route('record.index', ['patient_id' => $request->patient_id])
            ]);
        }

        // Handle regular form submission
        return redirect()->route('record.index', ['patient_id' => $request->patient_id]);
    }

    /**
     * Clear scanned patient session
     */
    public function clearScan()
    {
        Session::forget('scanned_patient_id');
        return redirect()->route('record.index');
    }
}