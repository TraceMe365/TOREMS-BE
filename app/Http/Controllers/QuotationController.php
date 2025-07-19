<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Quotation;
use App\Models\Location;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    // List all quotations
    public function index(Request $request)
    {
        $quotations = Quotation::with(['vehicleType', 'originLocation', 'destinationLocation']);
        if($request->has('customer_id')) {
            $quotations = $quotations->where('customer_id', $request->input('customer_id'));
        }
        $quotations = $quotations->get();
        return response()->json([
            'status' => 200,
            'quotations' => $quotations
        ]);
    }

    public function approve(Request $request, $id)
    {
        $user = auth()->user();
        // Only admin can approve the quotation
        if (!$user || !in_array($user->role, ['admin', 'customer'])) {
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 403,
                'role' => $user->role,
            ], 403);
        }

        $quotation = Quotation::findOrFail($id);
        if (empty($quotation->rate) || empty($quotation->rate_type) || $quotation->rate==null || $quotation->rate_type==null) {
            return response()->json([
                'message' => 'Rate and Rate type must not be empty or null to approve the quotation',
                'status' => 422,
            ], 422);
        }
        $quotation->status = 'APPROVED';
        $quotation->approve_user_id = $user->id;
        $quotation->approve_time = now();
        $quotation->save();

        return response()->json([
            'message' => 'Quotation approved successfully',
            'status' => 200,
            'quotation' => $quotation
        ]);
    }

    public function cancel(Request $request, $id){
        $user = auth()->user();
        $quotation = Quotation::findOrFail($id);
        $quotation->status = 'APPROVED';
        $quotation->approve_user_id = $user->id;
        $quotation->approve_time = now();
        $quotation->save();
        return response()->json([
            'message' => 'Quotation cancelled successfully',
            'status' => 200,
            'quotation' => $quotation
        ]);
    }

    // Store a new quotation
    public function store(Request $request)
    {
        try {
            $input = $request->all();
            // if (empty($input['customer_id'])) {
            //     $tempCustomer = Customer::first();
            //     $input['customer_id'] = $tempCustomer->cus_id; 
            // }

            // Store or get origin location
            // $originLocation = Location::firstOrCreate([
            //     'loc_name' => $input['origin'],
            //     'loc_lat'  => $input['origin_latitude'],
            //     'loc_long' => $input['origin_longitude'],
            //     'cus_id'   => $input['customer_id'] ?? null,
            // ]);
            // // Store or get destination location
            // $destinationLocation = Location::firstOrCreate([
            //     'loc_name' => $input['destination'],
            //     'loc_lat'  => $input['destination_latitude'],
            //     'loc_long' => $input['destination_longitude'],
            //     'cus_id'   => $input['customer_id'] ?? null,
            // ]);

            

            $validated = validator([
                'customer_id'           => $input['customer_id'],
                'quotation_date'        => $input['quotation_date'] ?? null,
                'origin_id'             => $input['origin'],
                'destination_id'        => $input['destination'],
                'vehicle_type'          => $input['vehicle_type'] ?? null,
                'rate'                  => $input['rate'] ?? null,
                'rate_type'             => $input['rate_type'] ?? null,
                'estimated_distance'    => $input['estimated_distance'] ?? null,
                'estimated_time'        => $input['estimated_time'] ?? null,
                'remarks'               => $input['remarks'] ?? null,
                'status'                => $input['status'] ?? null,
            ], [
                'customer_id'        => 'required|integer|exists:tms_customer,cus_id',
                'quotation_date'     => 'required|date',
                'origin_id'          => 'required|integer|exists:tms_location,loc_id',
                'destination_id'     => 'required|integer|exists:tms_location,loc_id',
                'vehicle_type'       => 'required|int',
                'rate'               => 'nullable|numeric',
                'rate_type'          => 'nullable|string|max:255',
                'estimated_distance' => 'nullable|numeric',
                'estimated_time'     => 'nullable|numeric',
                'remarks'            => 'nullable|string',
                'status'             => 'required|string|max:255',
            ])->validate();

            $quotation = Quotation::create($validated);
            $quotation->quotation_no = 'Q-' . str_pad($quotation->id, 6, '0', STR_PAD_LEFT);
            $quotation->save();

            // Add via locations (store location and link via_locations)
            if (isset($input['via_locations']) && is_array($input['via_locations'])) {
                foreach ($input['via_locations'] as $via) {
                    // $viaLocation = Location::firstOrCreate([
                    //     'loc_name' => $via['name'],
                    //     'loc_lat'  => $via['lat'],
                    //     'loc_long' => $via['lng'],
                    //     'cus_id'   => $input['customer_id'] ?? null,
                    // ]);
                    $quotation->viaLocations()->create([
                        'location_id'      => $via['via_location_id'],
                        'via_location'     => $via['via_location'],
                        'via_latitude'     => $via['via_latitude'],
                        'via_longitude'    => $via['via_longitude'],
                        'tms_quotation_id' => $quotation->id,
                    ]);
                }
            }

            return response()->json([
                'message' => 'Quotation created successfully',
                'status' => 201,
                'quotation' => $quotation
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        }
    }

    // Show a single quotation
    public function show($id)
    {
        $quotation = Quotation::with(['viaLocations', 'originLocation', 'destinationLocation'])->findOrFail($id);

        return response()->json([
            'status' => 200,
            'quotation' => $quotation
        ]);
    }

    // Update a quotation
    public function update(Request $request, $id)
    {
        try {
            $quotation = Quotation::findOrFail($id);
            $input = $request->all();

            $validated = validator([
                'customer_id'           => $input['customer_id'],
                'quotation_no'          => $input['quotation_no'] ?? null,
                'quotation_date'        => $input['quotation_date'] ?? null,
                'origin_id'             => $input['origin_location']['loc_id'],
                'destination_id'        => $input['destination_location']['loc_id'],
                'vehicle_type'          => $input['vehicle_type'] ?? null,
                'rate'                  => $input['rate'] ?? null,
                'rate_type'             => $input['rate_type'] ?? null,
                'estimated_distance'    => $input['estimated_distance'] ?? null,
                'estimated_time'        => $input['estimated_time'] ?? null,
                'remarks'               => $input['remarks'] ?? null,
                'status'                => $input['status'] ?? null,
            ], [
                'customer_id'        => 'sometimes|integer|exists:tms_customer,cus_id',
                'quotation_no'       => 'nullable|string|max:255',
                'quotation_date'     => 'nullable|date',
                'origin_id'          => 'required|integer|exists:tms_location,loc_id',
                'destination_id'     => 'required|integer|exists:tms_location,loc_id',
                'vehicle_type'       => 'nullable|int',
                'rate'               => 'nullable|numeric',
                'rate_type'          => 'nullable|string|max:255',
                'estimated_distance' => 'nullable|numeric',
                'estimated_time'     => 'nullable|numeric',
                'remarks'            => 'nullable|string',
                'status'             => 'nullable|string|max:255',
            ])->validate();

            $quotation->update($validated);

            // Update via locations: remove old and add new if provided
            if (isset($input['via_locations']) && is_array($input['via_locations'])) {
                // Remove existing via locations for this quotation
                $quotation->viaLocations()->delete();

                // Add new via locations
                foreach ($input['via_locations'] as $via) {
                    // $viaLocation = Location::firstOrCreate([
                    //     'loc_name' => $via['name'],
                    //     'loc_lat'  => $via['lat'],
                    //     'loc_long' => $via['lng'],
                    //     'cus_id'   => $input['customer_id'] ?? null,
                    // ]);

                    $quotation->viaLocations()->create([
                        'location_id'      => $via['via_location_id'],
                        'via_location'     => $via['via_location'],
                        'via_latitude'     => $via['via_latitude'],
                        'via_longitude'    => $via['via_longitude'],
                        'tms_quotation_id' => $quotation->id,
                    ]);
                }
            }

            return response()->json([
                'message' => 'Quotation updated successfully',
                'status' => 200,
                'quotation' => $quotation
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        }
    }

    // Delete a quotation
    public function destroy($id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->delete();
        return response()->json([
            'message' => 'Quotation deleted successfully',
            'status' => 200
        ]);
    }
}