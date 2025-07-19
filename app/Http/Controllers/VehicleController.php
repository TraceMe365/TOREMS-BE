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
            'vehicles' => Vehicle::with(['vehicle_type'])->get()
        ]);
    }

    // Store a new vehicle
    public function store(Request $request)
    {
        $user = auth()->user();
        try {
            $validated = $request->validate([
                'veh_no'           => 'required|string|max:255',
                'vehicle_type'         => 'required|integer',
                'vehicle_status'       => 'required|integer',
                'veh_loading_capacity' => 'required|integer',
                'veh_image_link'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $validated['created_by']       = $user->id;
            $validated['veh_availability'] = 1;
            $validated['veh_gps_status']   = 0;
            $validated['veh_permanent']    = 0;
            $validated['veh_diver_id']     = 9;
            $validated['veh_is_available'] = 1;

            if ($request->hasFile('veh_image_link')) {
                $image = $request->file('veh_image_link');
                $imageName = uniqid('user_', true) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('vehicle_images', $imageName, 'public');
                $validated['veh_image_link'] = 'storage/' . $imagePath;
            }

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