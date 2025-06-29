<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    // List all shipments
    public function index()
    {
        return response()->json([
            'status' => 200,
            'shipments' => Shipment::all()
        ]);
    }

    // Store a new shipment
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'tms_shp_request_no'   => 'required|string|max:255',
                'tms_shp_pickup_loc'   => 'required|integer',
                'tms_shp_delivery_loc' => 'required|integer',
                'tms_shp_weight'       => 'required|string|max:255',
                'tms_cus_id'           => 'required|integer',
                'tms_vty_id'           => 'required|integer',
                'tms_shp_request_date' => 'required|date',
                'tms_shp_status'       => 'required|string|max:255',
                
                'quotation_id'              => 'nullable|integer',
                'tms_end_odometer'          => 'nullable|numeric',
                'tms_shp_arrived_delivery'  => 'nullable|date',
                'tms_shp_arrived_pickup'    => 'nullable|date',
                'tms_shp_cbm'               => 'nullable|string|max:255',
                'tms_shp_departed_delivery' => 'nullable|date',
                'tms_shp_departed_pickup'   => 'nullable|date',
                'tms_shp_driver'            => 'nullable|string|max:255',
                'tms_shp_helper'            => 'nullable|string|max:255',
                'tms_shp_remarks'           => 'nullable|string',
                'tms_start_odometer'        => 'nullable|numeric',
                'tms_veh_id'                => 'nullable|integer',
            ]);
            $shipment = Shipment::create($validated);

            return response()->json([
                'message' => 'Shipment created successfully',
                'status' => 201,
                'shipment' => $shipment
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        }
    }

    // Show a single shipment
    public function show($id)
    {
        $shipment = Shipment::findOrFail($id);
        return response()->json([
            'status' => 200,
            'shipment' => $shipment
        ]);
    }

    // Update a shipment
    public function update(Request $request, $id)
    {
        try {
            $shipment = Shipment::findOrFail($id);

            $validated = $request->validate([
                // Add your shipment validation rules here
            ]);

            $shipment->update($validated);

            return response()->json([
                'message' => 'Shipment updated successfully',
                'status' => 200,
                'shipment' => $shipment
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        }
    }

    // Delete a shipment
    public function destroy($id)
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->delete();
        return response()->json([
            'message' => 'Shipment deleted successfully',
            'status' => 200
        ]);
    }

    // Get request number for a new shipment
    public function getRequestNo(){
        $lastShipment = Shipment::orderBy('tms_shp_id', 'desc')->first();
        $lastId       = $lastShipment ? $lastShipment->tms_shp_id : 0;
        $nextId       = $lastId + 1;
        $requestNo    = 'SHP-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
        return response()->json([
            'request_no'   => $requestNo,
            'status'       => 200,
        ]);
    }
}