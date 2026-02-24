<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new user
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create($validated);

        return response()->json($user, 201);
    }

    /**
     * Update user membership
     */
    public function updateMembership(Request $request)
    {
        $validated = $request->validate([
            'membership' => 'required|in:foundation,economy,Foundation,Economy',
            'user_email' => 'required|email',
            'user_name' => 'required|string',
        ]);

        try {
            // Find user by email
            $user = User::where('email', $validated['user_email'])->first();

            if (!$user) {
                return response()->json([
                    'message' => 'User not found',
                    'success' => false
                ], 404);
            }

            // Normalize membership value (capitalize first letter)
            $membership = ucfirst(strtolower($validated['membership']));

            // Update membership
            $user->update([
                'membership' => $membership
            ]);

            return response()->json([
                'message' => 'Membership updated successfully',
                'success' => true,
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating membership: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
}
