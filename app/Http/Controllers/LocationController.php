<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // List all locations
    public function index()
    {
        return response()->json([
            'status' => 200,
            'locations' => Location::all()
        ]);
    }

    // Store a new location
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'loc_name' => 'required|string|max:255',
                'loc_lat'  => 'nullable|numeric',
                'loc_long' => 'nullable|numeric',
                'cus_id'   => 'nullable|integer',
            ]);

            $location = Location::create($validated);

            return response()->json([
                'message' => 'Location created successfully',
                'status' => 201,
                'location' => $location
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        }
    }

    // Show a single location
    public function show($id)
    {
        $location = Location::findOrFail($id);
        return response()->json([
            'status' => 200,
            'location' => $location
        ]);
    }

    // Update a location
    public function update(Request $request, $id)
    {
        try {
            $location = Location::findOrFail($id);

            $validated = $request->validate([
                'loc_name' => 'sometimes|string|max:255',
                'loc_lat'  => 'nullable|numeric',
                'loc_long' => 'nullable|numeric',
                'cus_id'   => 'nullable|integer',
            ]);

            $location->update($validated);

            return response()->json([
                'message' => 'Location updated successfully',
                'status' => 200,
                'location' => $location
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        }
    }

    // Delete a location
    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();
        return response()->json([
            'message' => 'Location deleted successfully',
            'status' => 200
        ]);
    }
}