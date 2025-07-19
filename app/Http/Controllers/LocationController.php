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
                'loc_name'           => 'required|string|max:255|unique:tms_location,loc_name',
                'loc_lat'            => 'required|numeric',
                'loc_long'           => 'required|numeric',
                'cus_id'             => 'nullable|integer',
                'loc_contact_person' => 'required|string',
                'loc_contact_mobile' => 'required|string',
                'loc_status'         => 'required|string',
                'loc_address'        => 'nullable|string',
            ]);
            
            $locationCode            = 'LOC' . str_pad(Location::count() + 1, 3, '0', STR_PAD_LEFT);
            $validated['created_by'] = auth()->id();
            $validated['loc_code']   = $locationCode;
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
                'loc_name'           => 'sometimes|string|max:255',
                'loc_lat'            => 'required|numeric',
                'loc_long'           => 'required|numeric',
                'cus_id'             => 'nullable|integer',
                'loc_contact_person' => 'required|string',
                'loc_contact_mobile' => 'required|string',
                'loc_status'         => 'required|string',
                'loc_address'        => 'nullable|string',
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