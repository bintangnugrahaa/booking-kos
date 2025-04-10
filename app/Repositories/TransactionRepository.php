<?php

namespace App\Repositories;

use App\Interfaces\TransactionRepositoryInterface;
use App\Models\Room;
use App\Models\Transaction;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function getTransactionDataFromSession(): ?array
    {
        return session('transaction');
    }

    public function saveTransactionDataToSession(array $data): void
    {
        $transaction = session('transaction', []);

        foreach ($data as $key => $value) {
            $transaction[$key] = $value;
        }

        session()->put('transaction', $transaction);
    }

    public function saveTransaction(array $data): Transaction
    {
        $room = Room::findOrFail($data['room_id']);

        $data = $this->prepareTransactionData($data, $room);

        $transaction = Transaction::create($data);

        session()->forget('transaction');

        return $transaction;
    }

    public function getTransactionByCode(string $code): ?Transaction
    {
        return Transaction::where('code', $code)->first();
    }

    private function prepareTransactionData(array $data, Room $room): array
    {
        $data['code'] = $this->generateTransactionCode();
        $data['payment_status'] = 'pending';
        $data['transaction_date'] = now();

        $total = $this->calculateTotalAmount($room->price_per_month, $data['duration']);
        $data['total_amount'] = $this->calculatePaymentAmount($total, $data['payment_method']);

        return $data;
    }

    private function generateTransactionCode(): string
    {
        return 'NGK' . strtoupper(uniqid());
    }

    private function calculateTotalAmount(float $pricePerMonth, int $duration): float
    {
        $subtotal = $pricePerMonth * $duration;
        $tax = $subtotal * 0.11;
        $insurance = $subtotal * 0.01;

        return $subtotal + $tax + $insurance;
    }

    private function calculatePaymentAmount(float $total, string $paymentMethod): float
    {
        return $paymentMethod === 'full_payment' ? $total : $total * 0.3;
    }
}
