<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class HistoryController extends Controller
{
    /**
     * Store historical data for a patient
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function storeData(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'patient_id' => 'required|string|exists:patients,id',
                'glucose_level' => 'required|string',
                'status' => 'required|string'
            ]);

            // Check if patient exists
            $patient = Patient::find($validatedData['patient_id']);
            if (!$patient) {
                return response()->json([
                    'error' => true,
                    'message' => 'Patient not found'
                ], 404);
            }

            // Create new history record
            History::create([
                'patient_id' => $validatedData['patient_id'],
                'glucose_level' => $validatedData['glucose_level'],
                'status' => $validatedData['status']
            ]);

            return response()->json([
                'error' => false,
                'message' => 'Historical data stored successfully',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'An error occurred while storing historical data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get historical data for a patient
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getPatientHistory(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'patient_id' => 'required|string|exists:patients,id'
            ]);

            $histories = History::with('patient')
                ->where('patient_id', $request->patient_id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Historical data retrieved successfully',
                'data' => $histories
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving historical data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all historical data
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $histories = History::with('patient')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'message' => 'All historical data retrieved successfully',
                'data' => $histories
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving historical data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
