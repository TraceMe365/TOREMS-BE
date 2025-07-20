<?php

namespace App\Http\Controllers;

use App\Models\InvoiceEntry;
use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CompanyModel; // Adjust if your company model is named differently

class InvoiceController extends Controller
{
    // List all invoices
    public function index(Request $request)
    {   
        if($request->has('customer_id')){
            $customerId = $request->input('customer_id');
            return response()->json([
                'status' => 200,
                'invoices' => Invoice::with(['customer'])
                    ->where('tms_cus_id', $customerId)
                    ->get()
            ]);
        }
        else{
            return response()->json([
                'status' => 200,
                'invoices' => Invoice::with(['customer'])->get()
            ]);
        }
    }

    public function approveInvoice($id){
        $invoice = Invoice::findOrFail($id);
        $invoice->tms_inv_status = 'APPROVED';
        $invoice->save();

        return response()->json([
            'message' => 'Invoice approved successfully',
            'status' => 200,
            'invoice' => $invoice
        ]);
    }

    public function cancelInvoice($id){
        $invoice = Invoice::findOrFail($id);
        $invoice->tms_inv_status = 'CANCELLED';
        $invoice->save();

        return response()->json([
            'message' => 'Invoice cancelled successfully',
            'status' => 200,
            'invoice' => $invoice
        ]);
    }

    // Show a single invoice
    public function show($id)
    {
        $invoice = Invoice::with(['customer','entries'])->findOrFail($id);
        return response()->json([
            'status' => 200,
            'invoice' => $invoice
        ]);
    }

    // Store a new invoice
    public function store(Request $request)
    {
        $validated = $request->validate([
            'inv_no'                => 'required|string|max:255',
            'inv_date'              => 'required|date',
            'customer_id'           => 'required|integer',
            'inv_mode'              => 'required|string|max:255',
            'status'                => 'string|max:255',
            'total_delivery'        => 'nullable|numeric',
            'total_loading'         => 'nullable|numeric',
            'total_demurrage'       => 'nullable|numeric',
            'total_night_bata'      => 'nullable|numeric',
            'total_other'           => 'nullable|numeric',
            'total_deductions'      => 'nullable|numeric',
            'net_amount'            => 'nullable|numeric',
            'entries'               => 'required|array|min:1',
        ]);

        // Create the invoice
        $invoice = Invoice::create([
            'tms_inv_no'               => $validated['inv_no'],
            'tms_inv_date'             => $validated['inv_date'],
            'tms_cus_id'               => $validated['customer_id'],
            'tms_inv_mode'             => $validated['inv_mode'],
            'tms_inv_type'             => $request->input('inv_type'),
            'tms_inv_status'           => $validated['status'],
            'tms_inv_total_delivery'   => $request->input('total_delivery'),
            'tms_inv_total_loading'    => $request->input('total_loading'),
            'tms_inv_total_demurrage'  => $request->input('total_demurrage'),
            'tms_inv_total_night_bata' => $request->input('total_night_bata'),
            'tms_inv_total_other'      => $request->input('total_other'),
            'tms_inv_total_deductions' => $request->input('total_deductions'),
            'tms_inv_net_amount'       => $request->input('net_amount'),
            'tms_inv_create_date'      => now(),
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

        foreach ($validated['entries'] as $entry) {
            $shipment = Shipment::find($entry['shipment_id']);
            if ($shipment) {
                $shipment->isInvoice = 1;
                $shipment->save();
            }
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
        $invoiceLast = (Invoice::count())+1;
        $invoiceNo = 'INV-' . str_pad($invoiceLast, 6, '0', STR_PAD_LEFT);
        return response()->json([
            'invoice_no' => $invoiceNo,
            'status'     => 200,
        ]);
    }

    public function printInvoice($id)
    {
        $invoice = Invoice::with(['customer', 'entries.shipment'])->findOrFail($id);
        $company = CompanyModel::first(); // Adjust if you have a different way to get company details

        $pdf = Pdf::loadView('invoice', compact('invoice', 'company'));
        return $pdf->download('invoice_' . $invoice->tms_inv_no . '.pdf');
    }

    public function uploadProof($id){
        try {
            $invoice = Invoice::findOrFail($id);
            
            // Validate the request
            $request = request();
            $request->validate([
                'proof' => 'required|file|mimes:jpeg,jpg,png,pdf'
            ]);
            
            $file = $request->file('proof');

            if ($file) {
                $imageName = uniqid('invoice_proof_', true) . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('invoices', $imageName, 'public');
                
                $invoice->tms_inv_proof = 'storage/'.$imagePath;
                $invoice->tms_inv_proof_time = now();
                $invoice->save();
                
                return response()->json([
                    'message' => 'Proof uploaded successfully',
                    'status' => 200,
                    'proof_path' => $imagePath
                ]);
            }
            
            return response()->json([
                'message' => 'No file uploaded',
                'status' => 400
            ], 400);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Upload failed: ' . $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    public function paid($id){
        $invoice = Invoice::findOrFail($id);
        $invoice->tms_inv_status = 'PAID';
        $invoice->save();

        return response()->json([
            'message' => 'Invoice marked as paid successfully',
            'status' => 200,
            'invoice' => $invoice
        ]);
    }
}
