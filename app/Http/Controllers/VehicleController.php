<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // List all vehicles
    public function index()
    {
        return response()->json([
            'status' => 200,
            'vehicles' => Vehicle::all()
        ]);
    }

    // Store a new vehicle
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'veh_no'               => 'required|string|max:255',
                'vehicle_type'         => 'required|integer',
                'veh_loading_capacity' => 'required|numeric',
                'veh_status'           => 'required|integer',
                'veh_availability'     => 'required|integer',
                'veh_diver_id'         => 'nullable|integer',
                'created_by'           => 'nullable|integer',
            ]);

            $vehicle = Vehicle::create($validated);

            return response()->json([
                'message' => 'Vehicle created successfully',
                'status' => 201,
                'vehicle' => $vehicle
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        }
    }

    // Show a single vehicle
    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return response()->json([
            'status' => 200,
            'vehicle' => $vehicle
        ]);
    }

    // Update a vehicle
    public function update(Request $request, $id)
    {
        try {
            $vehicle = Vehicle::findOrFail($id);

            $validated = $request->validate([
                'veh_no'               => 'sometimes|string|max:255',
                'vehicle_type'         => 'sometimes|integer',
                'veh_loading_capacity' => 'sometimes|numeric',
                'veh_status'           => 'sometimes|integer',
                'veh_availability'     => 'sometimes|integer',
                'veh_diver_id'         => 'nullable|integer',
                'created_by'           => 'nullable|integer',
            ]);

            $vehicle->update($validated);

            return response()->json([
                'message' => 'Vehicle updated successfully',
                'status' => 200,
                'vehicle' => $vehicle
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        }
    }

    // Delete a vehicle
    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();
        return response()->json([
            'message' => 'Vehicle deleted successfully',
            'status' => 200
        ]);
    }
}