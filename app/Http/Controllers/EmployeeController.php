<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // List all employees
    public function index(Request $request)
    {
        $query = Employee::query();

        if ($request->has('emp_type')) {
            $query->where('emp_type', $request->get('emp_type'));
        }

        return response()->json([
            'status' => 200,
            'employees' => $query->get()
        ]);
    }

    // Store a new employee
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'emp_f_name'   => 'required|string|max:255',
                'emp_s_name'   => 'nullable|string|max:255',
                'emp_mobile'   => 'nullable|string|max:255',
                'emp_type'     => 'nullable|string|max:255',
                'emp_status'   => 'nullable|integer',
                'emp_address'  => 'nullable|string|max:255',
                'created_by'   => 'nullable|integer',
            ]);

            $employee = Employee::create($validated);

            return response()->json([
                'message' => 'Employee created successfully',
                'status' => 201,
                'employee' => $employee
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        }
    }

    // Show a single employee
    public function show($id)
    {
        $employee = Employee::with(['user'])->findOrFail($id);
        return response()->json([
            'status' => 200,
            'employee' => $employee
        ]);
    }

    // Update an employee
    public function update(Request $request, $id)
    {
        try {
            $employee = Employee::findOrFail($id);

            $validated = $request->validate([
                'emp_f_name'   => 'sometimes|string|max:255',
                'emp_s_name'   => 'nullable|string|max:255',
                'emp_mobile'   => 'nullable|string|max:255',
                'emp_type'     => 'nullable|string|max:255',
                'emp_status'   => 'nullable|integer',
                'emp_address'  => 'nullable|string|max:255',
            ]);

            $employee->update($validated);

            return response()->json([
                'message' => 'Employee updated successfully',
                'status' => 200,
                'employee' => $employee
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        }
    }

    // Delete an employee
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return response()->json([
            'message' => 'Employee deleted successfully',
            'status' => 200
        ]);
    }
}