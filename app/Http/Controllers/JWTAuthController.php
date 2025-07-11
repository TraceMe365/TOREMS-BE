<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTAuthController extends Controller
{
    // User registration
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|string|email|max:255|unique:users',
            'password'   => 'required|string|min:6|confirmed',
            'role'       => 'nullable|string|max:255',
            'contact'    => 'nullable|string|max:255',
            'status'     => 'nullable|string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        // Create the user first
        $user = User::create([
            'first_name' => $request->get('first_name'),
            'last_name'  => $request->get('last_name'),
            'email'      => $request->get('email'),
            'password'   => Hash::make($request->get('password')),
            'role'       => $request->get('role'),
            'contact'    => $request->get('contact'),
            'status'     => $request->get('status'),    
        ]);

        // Create related Customer or Employee and update user with the ID
        if ($user->role === 'customer') {
            $customer = Customer::create([
                'cus_name' => $user->first_name . ' ' . $user->last_name,
                'cus_con_person' => $user->first_name . ' ' . $user->last_name,
                'cus_con_person_num' => $user->contact,
                'cus_con_person_email' => $user->email,
                'cus_status' => 1,
            ]);
            $user->customer_id = $customer->cus_id;
            $user->save();
        } elseif ($user->role === 'driver') {
            $employee = Employee::create([
                'emp_f_name'  => $user->first_name,
                'emp_s_name'  => $user->last_name,
                'emp_contact' => $user->contact,
                'emp_status'  => 1,
            ]);
            $user->emp_id = $employee->emp_id;
            $user->save();
        }

        return response()->json([
            'message' => 'Succesfully created user, please await administrator approval',
            'user' => $user,
        ], 201);
    }

    // User login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
            // Get the authenticated user.
            $user = auth()->user();
            if ($user->status == 'PENDING' || $user->status === 'pending') {
                return response()->json(['error' => 'Registration pending approval'],403);
            }
            if ($user->status == 'REJECTED' || $user->status === 'rejected') {
                return response()->json(['error' => 'Registration rejected'], 403);
            }
            // (optional) Attach the role to the token.
            $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);
            return response()->json(array("access_token"=>$token,"token_type"=>"Bearer","user"=>$user), 200);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
    }

    // Get authenticated user
    public function getUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Invalid token'], 400);
        }

        return response()->json(compact('user'));
    }

    // User logout
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }
}