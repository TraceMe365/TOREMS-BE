<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // List all customers
    public function index()
    {
        $user = auth()->user();
        $customers = [];
        if ($user->role === 'admin') {
            $customers = Customer::all();
        } else if($user->role === 'customer') {
            $customers = Customer::where('cus_id', $user->customer_id)->get();
        }
        return response()->json([
            'status' => 200,
            'customers' => $customers
        ]);
    }

    // Store a new customer
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'cus_code' => 'required|string|max:255',
                'cus_name' => 'required|string|max:255',
                'cus_address' => 'nullable|string|max:255',
                'cus_con_person' => 'nullable|string|max:255',
                'cus_con_person_num' => 'nullable|string|max:255',
                'cus_con_person_email' => 'nullable|string|max:255',
                'cus_other_details' => 'nullable|string',
                'cus_status' => 'nullable|integer',
                'created_by' => 'nullable|integer',
                'tms_package' => 'nullable|string|max:255',
                'tms_com_id' => 'nullable|integer',
                'start_loc_type' => 'nullable|string|max:255',
                'end_loc_type' => 'nullable|string|max:255',
                'aditional_mileage_pre' => 'nullable|numeric',
                'cus_vat_number' => 'nullable|string|max:255',
                'cus_nbt_number' => 'nullable|string|max:255',
            ]);

            $customer = Customer::create($validated);

            return response()->json([
                'message' => 'Customer created successfully',
                'status' => 201,
                'customer' => $customer
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        }
    }

    // Show a single customer
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json([
            'status' => 200,
            'customer' => $customer
        ]);
    }

    // Update a customer
    public function update(Request $request, $id)
    {
        try {
            $customer = Customer::findOrFail($id);

            $validated = $request->validate([
                'cus_code' => 'sometimes|string|max:255',
                'cus_name' => 'sometimes|string|max:255',
                'cus_address' => 'nullable|string|max:255',
                'cus_con_person' => 'nullable|string|max:255',
                'cus_con_person_num' => 'nullable|string|max:255',
                'cus_con_person_email' => 'nullable|string|max:255',
                'cus_other_details' => 'nullable|string',
                'cus_status' => 'nullable|integer',
                'created_by' => 'nullable|integer',
                'tms_package' => 'nullable|string|max:255',
                'tms_com_id' => 'nullable|integer',
                'start_loc_type' => 'nullable|string|max:255',
                'end_loc_type' => 'nullable|string|max:255',
                'aditional_mileage_pre' => 'nullable|numeric',
                'cus_vat_number' => 'nullable|string|max:255',
                'cus_nbt_number' => 'nullable|string|max:255',
            ]);

            $customer->update($validated);

            return response()->json([
                'message' => 'Customer updated successfully',
                'status' => 200,
                'customer' => $customer
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        }
    }

    // Delete a customer
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return response()->json([
            'message' => 'Customer deleted successfully',
            'status' => 200
        ]);
    }

    public function getAllCustomers()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            $customers = Customer::all();
        } else if($user->role === 'customer') {
            $customers = Customer::where('id', $user->customer_id)->get();
        }
        return response()->json([
            'status'    => 200,
            'customers' => $customers,
            'role'      => $user->role
        ]);
    }
}