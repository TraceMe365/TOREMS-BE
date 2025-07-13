<?php

namespace App\Http\Controllers;

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
}
