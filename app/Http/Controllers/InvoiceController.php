<?php

namespace App\Http\Controllers;

use App\Models\InvoiceEntry;
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
        'inv_no'            => 'required|string|max:255',
        'inv_date'          => 'required|date',
        'customer_id'       => 'required|integer',
        'inv_mode'          => 'required|string|max:255',
        'status'            => 'required|string|max:255',
        'total_delivery'    => 'nullable|numeric',
        'total_loading'     => 'nullable|numeric',
        'total_demurrage'   => 'nullable|numeric',
        'total_night_bata'  => 'nullable|numeric',
        'total_other'       => 'nullable|numeric',
        'total_deductions'  => 'nullable|numeric',
        'net_amount'        => 'nullable|numeric',
        'entries'           => 'required|array|min:1',
        'entries.*.shipment_id' => 'required|integer',
        'entries.*.delivery'    => 'nullable|numeric',
        'entries.*.loading'     => 'nullable|numeric',
        'entries.*.demurrage'   => 'nullable|numeric',
        'entries.*.night_bata'  => 'nullable|numeric',
        'entries.*.other'       => 'nullable|numeric',
        'entries.*.deductions'  => 'nullable|numeric',
        'entries.*.total'       => 'required|numeric',
        ]);

        // Create the invoice
        $invoice = Invoice::create([
            'inv_no'            => $validated['inv_no'],
            'inv_date'          => $validated['inv_date'],
            'customer_id'       => $validated['customer_id'],
            'inv_mode'          => $validated['inv_mode'],
            'inv_type'          => $request->input('inv_type'),
            'from_date'         => $request->input('from_date'),
            'to_date'           => $request->input('to_date'),
            'status'            => $validated['status'],
            'total_delivery'    => $request->input('total_delivery'),
            'total_loading'     => $request->input('total_loading'),
            'total_demurrage'   => $request->input('total_demurrage'),
            'total_night_bata'  => $request->input('total_night_bata'),
            'total_other'       => $request->input('total_other'),
            'total_deductions'  => $request->input('total_deductions'),
            'net_amount'        => $request->input('net_amount'),
            'create_datetime'   => now(),
            'processed_datetime'=> $request->input('processed_datetime'),
        ]);

        // Store invoice entries
        foreach ($validated['entries'] as $entry) {
            InvoiceEntry::create([
                'tms_inv_id'            => $invoice->tms_inv_id,
                'tms_ien_request_id'    => $entry['shipment_id'],
                'tms_ien_delivery'      => $entry['delivery'] ?? 0,
                'tms_ien_loading'       => $entry['loading'] ?? 0,
                'tms_ien_demurrage'     => $entry['demurrage'] ?? 0,
                'tms_ien_night_bata'    => $entry['night_bata'] ?? 0,
                'tms_ien_other'         => $entry['other'] ?? 0,
                'tms_ien_deduction'     => $entry['deductions'] ?? 0,        
            ]);
        }

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
                'tms_total_trip_cost'       => $data['totalTripCost'] ?? 0,
                'tms_shp_trip_cost'         => $data['tripCost'] ?? 0,
                'tms_shp_other_amount'      => $data['other'] ?? 0,
                'tms_shp_unloading_charge'  => $data['unloading'] ?? 0,
                'tms_shp_loading_charge'    => $data['loading'] ?? 0,
                'tms_shp_highway_charge'    => $data['highway'] ?? 0,
                'tms_shp_night_bata'        => $data['nightBata'] ?? 0,
                'tms_shp_deductions'        => $data['deduction'] ?? 0,
                'tms_shp_boi_charge'        => $data['boi'] ?? 0,
                'tms_shp_demurrage_amount'  => $data['demurrage'] ?? 0,
                'tms_shp_estimated_mileage' => $data['estimatedMileage'] ?? 0,
            ]);
            $shipment->save();
        }
        return response()->json([
            'message' => 'Costs added successfully',
            'data' => $data,
            'status' => 200
        ]);
    }

    public function generateInvoiceNumber(){
        $lastInvoice = Invoice::orderBy('tms_inv_id', 'desc')->first();
        $lastId = $lastInvoice ? $lastInvoice->id : 0;
        $nextId = $lastId + 1;
        $invoiceNo = 'INV-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
        return response()->json([
            'invoice_no' => $invoiceNo,
            'status'     => 200,
        ]);
    }
}
