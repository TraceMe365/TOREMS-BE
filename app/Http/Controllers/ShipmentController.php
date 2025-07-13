<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\ViaLocation;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ShipmentController extends Controller
{
    // List all shipments
    public function index()
    {
        return response()->json([
            'status' => 200,
            'shipments' => Shipment::with(['customer', 'vehicle', 'pickupLocation', 'deliveryLocation','driver'])->get()
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
                'tms_shp_mode'              => 'nullable|string',
            ]);
            // Convert ISO 8601 time fields to SQL datetime format if present
            $timeFields = [
                'tms_shp_arrived_delivery',
                'tms_shp_arrived_pickup',
                'tms_shp_departed_delivery',
                'tms_shp_departed_pickup',
            ];
            foreach ($timeFields as $field) {
                if (!empty($validated[$field])) {
                    $validated[$field] = date('Y-m-d H:i:s', strtotime($validated[$field]));
                }
            }
            $shipment = Shipment::create($validated);
            
            // Attach via locations if provided
            if ($request->has('via_locations') && is_array($request->via_locations)) {
                foreach ($request['via_locations'] as $via) {
                    $shipment->viaLocations()->create([
                            'location_id'     => $via['via_location'],
                            'via_location'    => $via['via_location_name'],
                            'via_latitude'    => $via['via_latitude'],
                            'via_longitude'   => $via['via_longitude'],
                            'tms_shipment_id' => $shipment->id,
                    ]);
                }
            }

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
        $shipment = Shipment::with(['customer', 'vehicle', 'pickupLocation', 'deliveryLocation','viaLocations'])->where('tms_shp_id',$id)->firstOrFail();
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
                'tms_shp_mode'              => 'nullable|string',
            ]);

            $shipment->update($validated);

            // Attach via locations if provided
            if ($request->has('via_locations') && is_array($request->via_locations)) {
                // First, delete existing via locations
                ViaLocation::where('tms_shipment_id', $shipment->tms_shp_id)->delete();
                foreach ($request['via_locations'] as $via) {
                    if(is_numeric($via['via_location'])){
                        $shipment->viaLocations()->create([
                            'location_id'     => $via['via_location'],
                            'via_location'    => $via['via_location_name'],
                            'via_latitude'    => $via['via_latitude'],
                            'via_longitude'   => $via['via_longitude'],
                            'tms_shipment_id' => $shipment->id,
                        ]);
                    }
                    else{
                        $shipment->viaLocations()->create([
                            'location_id'     => $via['id'],
                            'via_location'    => $via['via_location_name'],
                            'via_latitude'    => $via['via_latitude'],
                            'via_longitude'   => $via['via_longitude'],
                            'tms_shipment_id' => $shipment->id,
                        ]);
                    }
                    
                }
            }

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

    // Approve a shipment
    public function approve($id)
    {
        $user = auth()->user();
        if($user->role == 'admin'){
            $shipment = Shipment::findOrFail($id);
            $shipment->tms_shp_status = 'APPROVED';
            $shipment->tms_shp_approved_user = $user->id;
            $shipment->tms_shp_approved_date = now();
            $shipment->save();

            return response()->json([
                'message' => 'Shipment approved successfully',
                'status' => 200,
                'shipment' => $shipment
            ]);
        }
        else{
            return response()->json([
                'message' => 'Unauthorized action',
                'status' => 403
            ], 403);
        }
    }

    // Cancel a shipment
    public function cancel($id)
    {
        $user = auth()->user();
        if($user->role == 'admin'){
            $shipment = Shipment::findOrFail($id);
            $shipment->tms_shp_status = 'CANCELLED';
            $shipment->save();

            return response()->json([
                'message' => 'Shipment cancelled successfully',
                'status' => 200,
                'shipment' => $shipment
            ]);
        }
        else{
            return response()->json([
                'message' => 'Unauthorized action',
                'status' => 403
            ], 403);
        }
    }

    // Attend a shipment
    public function attend($id)
    {
        $user = auth()->user();
            if($user->role == 'admin'){
            $shipment = Shipment::findOrFail($id);
            $shipment->tms_shp_status = 'Attended';
            $shipment->save();

            return response()->json([
                'message' => 'Shipment attended successfully',
                'status' => 200,
                'shipment' => $shipment
            ]);
        }
        else{
            return response()->json([
                'message' => 'Unauthorized action',
                'status' => 403
            ], 403);
        }
    }

    // Change shipment to ongoing status
    public function setOngoing($id)
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->tms_shp_status = 'Ongoing';
        $shipment->tms_shp_shipment_start = now(); // Set the start time to now
        $shipment->save();

        return response()->json([
            'message' => 'Shipment status changed to Ongoing',
            'status' => 200,
            'shipment' => $shipment
        ]);
    }

    // Change shipment to complete status
    public function setComplete($id)
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->tms_shp_status = 'Complete';
        $shipment->tms_shp_shipment_end = now(); // Set the end time to now
        $shipment->save();

        return response()->json([
            'message' => 'Shipment status changed to Complete',
            'status' => 200,
            'shipment' => $shipment
        ]);
    }

    // Arrived at pickup
    public function arrivedAtPickup($id)
    {
        $shipment = Shipment::findOrFail($id);
        $shipment->tms_shp_arrived_pickup = now();
        $shipment->tms_shp_arrived_at_pickup_by = auth()->user()->id;
        $shipment->save();

        return response()->json([
            'message' => 'Shipment arrived at pickup location',
            'status' => 200,
            'shipment' => $shipment
        ]);
    }

    public function arrivedAtVia($id,$locationId){
        $shipment = Shipment::with('viaLocations')->findOrFail($id);
        $shipment->viaLocations()->where('location_id', $locationId)
        ->where('tms_shipment_id', $shipment->tms_shp_id)
        ->update([
            'arrived_at' => now()
        ]);
        return response()->json([
            'message' => 'Arrived at via location',
            'status' => 200,
            'shipment' => $shipment
        ]);
    }

    // Assign vehicle and driver to a shipment
    public function assignVehicleDriver($id){
        $shipment = Shipment::findOrFail($id);
        $user = auth()->user();
        if($user->role == 'admin'){
            $validated = request()->validate([
                'tms_veh_id'     => 'required|integer',
                'tms_shp_driver' => 'required|string|max:255',
                'tms_shp_helper' => 'nullable|string|max:255'
            ]);

            $shipment->update($validated);
            // Update shipment status to Attended
            $shipment->tms_shp_status = 'Attended';
            $shipment->tms_ship_attended_date = now();
            $shipment->save();
            return response()->json([
                'message'  => 'Vehicle and driver assigned successfully',
                'status'   => 200,
                'shipment' => $shipment
            ]);
        }
        else{
            return response()->json([
                'message' => 'Unauthorized action',
                'status'  => 403
            ], 403);
        }
    }

    public function printGatepass($id)
    {
        $shipment = Shipment::with([
            'customer',
            'vehicle.vehicle_type',
            'pickupLocation',
            'deliveryLocation',
            'driver'
        ])->findOrFail($id);
        $company = \App\Models\CompanyModel::first();
        
        $pdf = Pdf::loadView('gatepass', compact('shipment', 'company'));
        $shipment->tms_is_gate_pass_print = ($shipment->tms_is_gate_pass_print) + 1;
        $shipment->save();
        return $pdf->download('gatepass_'.$shipment->tms_shp_request_no.'.pdf');

    }
}