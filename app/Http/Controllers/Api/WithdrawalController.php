<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdrawal;
use App\Models\BankAccount;

class WithdrawalController extends Controller
{
    public function store(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'amount' => 'required|numeric|min:10000'
        ]);

        if ($user->balance < $data['amount']) {
            return response()->json([
                'message' => 'Saldo tidak mencukupi'
            ], 400);
        }

        $withdrawal = Withdrawal::create([
            'user_id' => $user->id,
            'bank_account_id' => $data['bank_account_id'],
            'amount' => $data['amount'],
            'status' => 'pending'
        ]);

        // Kurangi saldo
        $user->balance -= $data['amount'];
        $user->save();

        return response()->json([
            'message' => 'Permintaan penarikan berhasil dibuat',
            'withdrawal' => $withdrawal
        ]);
    }
}
