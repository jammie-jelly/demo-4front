<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /**
     * Add a transaction to a wallet
     */
    public function store(Request $request, Wallet $walletId)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
        ]);

        // Use database transaction for safety
        DB::beginTransaction();

        try {
            // Create the transaction
            $transaction = Transaction::create([
                'wallet_id' => $walletId->id,
                'type' => $validated['type'],
                'amount' => $validated['amount'],
                'description' => $validated['description'] ?? null,
            ]);

            // Update wallet balance
            if ($validated['type'] === 'income') {
                $walletId->balance += $validated['amount'];
            } else {
                $walletId->balance -= $validated['amount'];
            }
            $walletId->save();

            DB::commit();

            return response()->json($transaction, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create transaction'], 500);
        }
    }

    /**
     * Get transaction details
     */
    public function show(Transaction $transactionId)
    {
        return response()->json($transactionId);
    }
}
