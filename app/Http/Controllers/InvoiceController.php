<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    // List all invoices
    public function index()
    {
        return response()->json([
            'status' => 200,
            'invoices' => Invoice::all()
        ]);
    }

    // Show a single invoice
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        return response()->json([
            'status' => 200,
            'invoice' => $invoice
        ]);
    }

    // Store a new invoice
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Add your invoice fields and validation rules here
            'customer_id' => 'required|integer',
            'amount'      => 'required|numeric',
            'status'      => 'nullable|string|max:255',
            // Add more fields as needed
        ]);

        $invoice = Invoice::create($validated);

        return response()->json([
            'message' => 'Invoice created successfully',
            'status' => 201,
            'invoice' => $invoice
        ], 201);
    }

    // Update an invoice
    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $validated = $request->validate([
            // Add your invoice fields and validation rules here
            'customer_id' => 'sometimes|integer',
            'amount'      => 'sometimes|numeric',
            'status'      => 'nullable|string|max:255',
            // Add more fields as needed
        ]);

        $invoice->update($validated);

        return response()->json([
            'message' => 'Invoice updated successfully',
            'status' => 200,
            'invoice' => $invoice
        ]);
    }

    // Delete an invoice
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return response()->json([
            'message' => 'Invoice deleted successfully',
            'status' => 200
        ]);
    }

    public function addCosts(){
        $data = request()->all();
        $shipment = Shipment::find($data['shipmentId']);
        if (!$shipment) {
            return response()->json([
                'message' => 'Shipment not found',
                'status' => 404
            ], 404);
        }
        else{
            $shipment->update([
                'tms_total_trip_cost'      => $data['totalTripCost'] ?? 0,
                'tms_shp_trip_cost'        => $data['tripCost'] ?? 0,
                'tms_shp_other_amount'     => $data['other'] ?? 0,
                'tms_shp_unloading_charge' => $data['unloading'] ?? 0,
                'tms_shp_loading_charge'   => $data['loading'] ?? 0,
                'tms_shp_highway_charge'   => $data['highway'] ?? 0,
                'tms_shp_night_bata'       => $data['nightBata'] ?? 0,
                'tms_shp_deductions'       => $data['deduction'] ?? 0,
                'tms_shp_boi_charge'       => $data['boi'] ?? 0,
                'tms_shp_demurrage_amount' => $data['demurrage'] ?? 0,
            ]);
            $shipment->save();
        }
        return response()->json([
            'message' => 'Costs added successfully',
            'data' => $data,
            'status' => 200
        ]);
    }
}
