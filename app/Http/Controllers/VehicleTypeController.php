<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    // List all vehicle types
    public function index()
    {
        return response()->json([
            'status'        => 200,
            'vehicle_types' => VehicleType::all()
        ]);
    }

    // Store a new vehicle type
    public function store(Request $request)
    {
        $validated = $request->validate([
            'veh_type' => 'required|string|max:255',
            'veh_type_specification' => 'nullable|string|max:255',
            'veh_efficiency' => 'nullable|numeric',
            'veh_type_status' => 'nullable|integer',
            'created_by' => 'nullable|integer',
            'tms_com_id' => 'nullable|integer',
            'tms_cus_id' => 'nullable|integer',
            'veh_capacity' => 'nullable|numeric',
        ]);

        $vehicleType = VehicleType::create($validated);

        return response()->json([
            'message' => 'Vehicle type created successfully',
            'status' => 201,
            'vehicle_type' => $vehicleType
        ], 201);
    }

    // Show a single vehicle type
    public function show($id)
    {
        $vehicleType = VehicleType::findOrFail($id);
        return response()->json([
            'status' => 200,
            'vehicle_type' => $vehicleType
        ]);
    }

    // Update a vehicle type
    public function update(Request $request, $id)
    {
        $vehicleType = VehicleType::findOrFail($id);

        $validated = $request->validate([
            'veh_type' => 'sometimes|string|max:255',
            'veh_type_specification' => 'nullable|string|max:255',
            'veh_efficiency' => 'nullable|numeric',
            'veh_type_status' => 'nullable|integer',
            'created_by' => 'nullable|integer',
            'tms_com_id' => 'nullable|integer',
            'tms_cus_id' => 'nullable|integer',
            'veh_capacity' => 'nullable|numeric',
        ]);

        $vehicleType->update($validated);

        return response()->json([
            'message' => 'Vehicle type updated successfully',
            'status' => 200,
            'vehicle_type' => $vehicleType
        ]);
    }

    // Delete a vehicle type
    public function destroy($id)
    {
        $vehicleType = VehicleType::findOrFail($id);
        $vehicleType->delete();

        return response()->json([
            'message' => 'Vehicle type deleted successfully',
            'status' => 200
        ]);
    }
}