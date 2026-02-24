<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use App\Http\Requests\StoreWalletRequest;

class WalletController extends Controller
{
    /**
     * Create a new wallet for a user
     */
    public function store(StoreWalletRequest $request, User $userId)
    {
        $validated = $request->validated();

        $wallet = Wallet::create([
            'user_id' => $userId->id,
            'name' => $validated['name'],
            'balance' => 0,
        ]);

        return response()->json($wallet, 201);
    }

    /**
     * Get wallet details with transactions
     */
    public function show(Wallet $walletId)
    {
        $wallet = $walletId->load('transactions');

        return response()->json($wallet);
    }

    /**
     * Get all wallets for all users with total balance
     */
    public function getAllWallets()
    {
        $wallets = User::with('wallets.transactions')
            ->get()
            ->map(function ($user) {
                $totalBalance = $user->wallets->sum('balance');

                return [
                    'user_name' => $user->name,
                    'total_balance' => (float) $totalBalance,
                ];
            });

        return response()->json($wallets);
    }
}
