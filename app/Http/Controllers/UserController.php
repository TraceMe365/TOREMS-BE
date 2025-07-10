<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // List all users
    public function index()
    {
        return response()->json([
            'status' => 200,
            'users' => User::all()
        ]);
    }

    // Show a single user
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'status' => 200,
            'user' => $user
        ]);
    }

    // Update a user
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'first_name' => 'sometimes|string|max:255',
                'last_name'  => 'sometimes|string|max:255',
                'email'      => 'sometimes|string|email|max:255|unique:users,email,' . $id,
                'password'   => 'nullable|string|min:6',
                'role'       => 'nullable|string|max:255',
                'contact'    => 'nullable|string|max:255',
                'status'     => 'nullable|string',
            ]);

            if (!empty($validated['password'])) {
                $validated['password'] = bcrypt($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);

            return response()->json([
                'message' => 'User updated successfully',
                'status' => 200,
                'user' => $user
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
                'status' => 422
            ], 422);
        }
    }

    // Delete a user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully',
            'status' => 200
        ]);
    }

    // Approve user
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'APPROVED';
        $user->save();

        return response()->json([
            'message' => 'User approved successfully',
            'status' => 200,
            'user' => $user
        ]);
    }

    // Reject User
    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'REJECTED';
        $user->save();

        return response()->json([
            'message' => 'User rejected successfully',
            'status' => 200,
            'user' => $user
        ]);
    }
}
