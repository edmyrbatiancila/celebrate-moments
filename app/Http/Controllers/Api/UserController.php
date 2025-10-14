<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Basic implementation - you can add admin checks later
        $users = User::with(['creatorProfile'])
            ->when($request->role, function ($query, $role) {
                if ($role === 'creator') {
                    $query->where('is_creator', true);
                } elseif ($role === 'celebrant') {
                    $query->where('is_creator', false);
                }
            })
            ->paginate(15);

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'is_creator' => 'boolean',
            'date_of_birth' => 'required|date|before:today',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_creator' => $request->is_creator ?? false,
            'date_of_birth' => $request->date_of_birth,
            'current_role' => $request->is_creator ? 'creator' : 'celebrant',
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user->load('creatorProfile')
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json([
            'user' => $user->load(['creatorProfile'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Users can only update their own profile
        if (Auth::id() !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'date_of_birth' => 'sometimes|required|date|before:today',
            'current_role' => 'sometimes|in:creator,celebrant',
        ]);

        // Validate role switching
        if ($request->has('current_role')) {
            if ($request->current_role === 'creator' && !$user->is_creator) {
                return response()->json([
                    'message' => 'User must be a creator to switch to creator role'
                ], 400);
            }
        }

        $user->update($request->validated());

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user->fresh()->load('creatorProfile')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Users can only delete their own account
        if (Auth::id() !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }
}
