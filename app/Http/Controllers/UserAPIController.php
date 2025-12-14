<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class UserAPIController extends Controller
{
    // List users with pagination, optional search & role filter
    public function index()
    {
        $perPage = request('per_page') ?? 20;
        $query = User::query();

        if ($search = request('search')) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        if ($role = request('role')) {
            $query->where('role', $role);
        }

        $users = $query->paginate($perPage);

        return response()->json($users, 200);
    }

    // Create new user
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'contact_number' => 'nullable|string|max:20',
                'role' => 'sometimes|required|in:admin,customer',
            ]);


            $validated['password'] = Hash::make($validated['password']);

            $user = User::create($validated);

            return response()->json([
                'message' => 'User created',
                'user' => $user
            ], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 400);
        }
    }

    // Show single user
    public function show($id)
    {
        $user = User::find($id);
        if (! $user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json($user, 200);
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (! $user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $data = $request->all(['name', 'email', 'password', 'contact_number', 'role']);
        $data = array_filter($data, fn($v) => $v != null);
        if (!$data) {
            return response()->json(['errors' => 'Must include data'], 400);
        }
        try {
            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => ['sometimes', 'required', 'email', Rule::unique('users')->ignore($user->id)],
                'password' => 'sometimes|required|string|min:6',
                'contact_number' => 'nullable|string|max:20',
                'role' => 'sometimes|required|in:admin,customer',
            ]);

            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }

            $user->update($validated);

            return response()->json([
                'message' => 'User updated successfully',
                'user' => $user
            ], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 400);
        }
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::find($id);
        if (! $user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully', 'user' => $user], 200);
    }
}
