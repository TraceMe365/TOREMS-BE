<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyModel;

class CompanyController extends Controller
{
    // List all companies
    public function index()
    {
        return response()->json([
            'status'    => 200,
            'companies' => CompanyModel::first()
        ]);
    }

    // Store a new company
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'company_name'               => 'required|string|max:255',
                'address'                    => 'nullable|string|max:255',
                'contact'                    => 'nullable|string|max:255',
                'email'                      => 'nullable|string|max:255',
                'website'                    => 'nullable|string|max:255',
                'business_registration_code' => 'nullable|string|max:255',
                'company_vat_number'         => 'nullable|string|max:255',
                'image'                      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($request->hasFile('image')) {
                $image                   = $request->file('image');
                $imageName               = uniqid('company_', true) . '.' . $image->getClientOriginalExtension();
                $imagePath               = $image->storeAs('company_images', $imageName, 'public');
                $validated['image_path'] = 'storage/' . $imagePath;
            }

            $company = CompanyModel::create($validated);

            return response()->json([
                'message' => 'Company created successfully',
                'status' => 201,
                'company' => $company
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        }
    }

    // Show a single company
    public function show($id)
    {
        $company = CompanyModel::findOrFail($id);
        return response()->json([
            'status' => 200,
            'company' => $company
        ]);
    }

    // Update a company
    public function update(Request $request, $id)
    {
        try {
            $company = CompanyModel::findOrFail($id);

            $validated = $request->validate([
                'company_name'               => 'required|string|max:255',
                'address'                    => 'nullable|string|max:255',
                'contact'                    => 'nullable|string|max:255',
                'email'                      => 'nullable|string|max:255',
                'website'                    => 'nullable|string|max:255',
                'business_registration_code' => 'nullable|string|max:255',
                'company_vat_number'         => 'nullable|string|max:255',
                'image'                      => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = uniqid('company_', true) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('company_images', $imageName, 'public');
                $validated['image_path'] = 'storage/' . $imagePath;
            }

            $company->update($validated);

            return response()->json([
                'message' => 'Company updated successfully',
                'status' => 200,
                'company' => $company
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        }
    }

    // Delete a company
    public function destroy($id)
    {
        $company = CompanyModel::findOrFail($id);
        $company->delete();
        return response()->json([
            'message' => 'Company deleted successfully',
            'status' => 200
        ]);
    }
}
