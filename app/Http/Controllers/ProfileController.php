<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Get user profile with all wallets and balances
     */
    public function show(User $userId)
    {
        $user = $userId->load('wallets');

        // Calculate total balance
        $totalBalance = $user->wallets->sum('balance');

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'wallets' => $user->wallets->map(function ($wallet) {
                return [
                    'id' => $wallet->id,
                    'name' => $wallet->name,
                    'balance' => $wallet->balance,
                ];
            }),
            'total_balance' => $totalBalance,
        ]);
    }
}
