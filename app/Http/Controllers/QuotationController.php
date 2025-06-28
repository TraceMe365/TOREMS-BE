<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    // List all quotations
    public function index()
    {
        return response()->json([
            'status' => 200,
            'quotations' => Quotation::with('vehicleType')->get()
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

    // Store a new quotation
    public function store(Request $request)
    {
        try {
            // If customer_id is empty or not set, default to 1
            $input = $request->all();
            if (empty($input['customer_id'])) {
                $input['customer_id'] = 1;
            }

            $validated = validator($input, [
                'customer_id'           => 'required|integer|exists:tms_customer,cus_id',
                'quotation_no'          => 'nullable|string|max:255',
                'quotation_date'        => 'nullable|date',
                'origin'           => 'required|string|max:255',
                'origin_latitude'       => 'required|numeric',
                'origin_longitude'      => 'required|numeric',
                'destination'      => 'required|string|max:255',
                'destination_latitude'  => 'required|numeric',
                'destination_longitude' => 'required|numeric',
                'vehicle_type'          => 'nullable|int',
                'rate'                  => 'nullable|numeric',
                'rate_type'             => 'nullable|string|max:255',
                'estimated_distance'    => 'nullable|numeric',
                'estimated_time'        => 'nullable|numeric',
                'remarks'               => 'nullable|string',
                'status'                => 'nullable|string|max:255',
            ])->validate();

            $quotation = Quotation::create($validated);
            $quotation->quotation_no = 'Q-' . str_pad($quotation->id, 6, '0', STR_PAD_LEFT);
            $quotation->save();

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
        $quotation = Quotation::findOrFail($id);
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

            $validated = $request->validate([
                'customer_id'        => 'sometimes|integer|exists:tms_customer,cus_id',
                'quotation_no'       => 'nullable|string|max:255',
                'quotation_date'     => 'nullable|date',
                'origin'             => 'nullable|string|max:255',
                'destination'        => 'nullable|string|max:255',
                'vehicle_type'       => 'nullable|int',
                'rate'               => 'nullable|numeric',
                'rate_type'          => 'nullable|string|max:255',
                'estimated_distance' => 'nullable|numeric',
                'estimated_time'     => 'nullable|numeric',
                'remarks'            => 'nullable|string',
                'status'             => 'nullable|string|max:255',
            ]);

            $quotation->update($validated);

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