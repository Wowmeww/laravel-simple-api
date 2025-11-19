<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // List all users
    public function index()
    {
        return response()->json([
            'users' => User::all()
        ]);
    }

    // Create a new user
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users,email',
                'role'     => 'nullable|in:admin,customer',
                'suspended'=> 'boolean',
                'password' => 'required|string|min:6',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);
        }
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] ??= 'customer';
        $validated['suspended'] ??= false;

        $user = User::create($validated);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ], 201);
    }

    // Show a single user
    public function show(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json([
            'message' => 'User retrieved successfully',
            'user' => $user
        ]);
    }

    // Update a user
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (empty($request->all())) {
            return response()->json([
                'message' => 'No data provided in the request',
                'errors' => ['request' => ['You must provide at least one field to update.']]
            ], 400);
        }

        try {
            $validated = $request->validate([
                'name'      => 'sometimes|required|string|max:255',
                'email'     => 'sometimes|required|email|unique:users,email,' . $user->id,
                'role'      => 'sometimes|in:admin,customer',
                'suspended' => 'sometimes|boolean',
                'password'  => 'sometimes|required|string|min:6',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors'  => $e->errors(),
            ], 422);
        }

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    // Delete a user
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
