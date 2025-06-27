<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    // List all quotations
    public function index()
    {
        return response()->json(Quotation::all());
    }

    // Store a new quotation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'        => 'required|integer|exists:tms_customer,cus_id',
            'quotation_no'       => 'nullable|string|max:255',
            'quotation_date'     => 'nullable|date',
            'origin'             => 'nullable|string|max:255',
            'destination'        => 'nullable|string|max:255',
            'vehicle_type'       => 'nullable|string|max:255',
            'rate'               => 'nullable|numeric',
            'rate_type'          => 'nullable|string|max:255',
            'estimated_distance' => 'nullable|numeric',
            'estimated_time'     => 'nullable|numeric',
            'remarks'            => 'nullable|string',
            'status'             => 'nullable|string|max:255',
        ]);
        $quotation = Quotation::create($validated);
        $quotation->quotation_no = 'Q-' . str_pad($quotation->id, 6, '0', STR_PAD_LEFT);
        $quotation->save();
        return response()->json($quotation, 201);
    }

    // Show a single quotation
    public function show($id)
    {
        $quotation = Quotation::findOrFail($id);
        return response()->json($quotation);
    }

    // Update a quotation
    public function update(Request $request, $id)
    {
        $quotation = Quotation::findOrFail($id);

        $validated = $request->validate([
            'customer_id'        => 'sometimes|integer|exists:tms_customer,cus_id',
            'quotation_no'       => 'nullable|string|max:255',
            'quotation_date'     => 'nullable|date',
            'origin'             => 'nullable|string|max:255',
            'destination'        => 'nullable|string|max:255',
            'vehicle_type'       => 'nullable|string|max:255',
            'rate'               => 'nullable|numeric',
            'rate_type'          => 'nullable|string|max:255',
            'estimated_distance' => 'nullable|numeric',
            'estimated_time'     => 'nullable|numeric',
            'remarks'            => 'nullable|string',
            'status'             => 'nullable|string|max:255',
        ]);

        $quotation->update($validated);
        return response()->json($quotation);
    }

    // Delete a quotation
    public function destroy($id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->delete();
       return response()->json(['message' => 'Quotation deleted successfully']);
    }
}