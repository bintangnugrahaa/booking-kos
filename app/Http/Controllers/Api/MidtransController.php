<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.serverKey');
        $hashedKey = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashedKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature key'], 403);
        }

        $transaction = Transaction::where('code', $request->order_id)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $status = $request->transaction_status;
        $paymentType = $request->payment_type;
        $fraudStatus = $request->fraud_status;

        $statusMap = [
            'settlement' => 'success',
            'pending' => 'pending',
            'deny' => 'failed',
            'expire' => 'expired',
            'cancel' => 'canceled',
        ];

        if ($status === 'capture' && $paymentType === 'credit_card') {
            $transaction->update([
                'payment_status' => $fraudStatus === 'challenge' ? 'pending' : 'success'
            ]);
        } else {
            $transaction->update([
                'payment_status' => $statusMap[$status] ?? 'unknown'
            ]);
        }

        return response()->json(['message' => 'Callback received successfully']);
    }
}
