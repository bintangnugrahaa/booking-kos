<?php

namespace App\Repositories;

use App\Interfaces\TransactionRepositoryInterface;
use App\Models\Room;
use App\Models\Transaction;

/**
 * Repository to manage transaction data in session and database.
 */
class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * Get transaction data from session.
     *
     * @return array|null
     */
    public function getTransactionDataFromSession()
    {
        return session()->get('transaction');
    }

    /**
     * Save or update transaction data in session.
     *
     * @param array $data
     * @return void
     */
    public function saveTransactionDataToSession($data)
    {
        $transaction = session()->get('transaction', []);

        foreach ($data as $key => $value) {
            $transaction[$key] = $value;
        }

        session()->put('transaction', $transaction);
    }

    /**
     * Save transaction data to database and clear session.
     *
     * @param array $data
     * @return \App\Models\Transaction
     */
    public function saveTransaction($data)
    {
        $room = Room::find($data['room_id']);
        $data = $this->prepareTransactionData($data, $room);

        $transaction = Transaction::create($data);
        session()->forget('transaction');

        return $transaction;
    }

    /**
     * Prepare transaction data with code, status, date, and total amount.
     *
     * @param array $data
     * @param \App\Models\Room $room
     * @return array
     */
    private function prepareTransactionData($data, $room)
    {
        $data['code'] = $this->generateTransactionCode();
        $data['payment_status'] = 'pending';
        $data['transaction_date'] = now();

        $total = $this->calculateTotalAmount($room->price_per_month, $data['duration']);
        $data['total_amount'] = $this->calculatePaymentAmount($total, $data['payment_method']);

        return $data;
    }

    /**
     * Generate unique transaction code.
     *
     * @return string
     */
    private function generateTransactionCode()
    {
        return 'NGK-' . strtoupper(uniqid());
    }

    /**
     * Calculate total transaction amount with tax and insurance.
     *
     * @param int|float $pricePerMonth
     * @param int $duration
     * @return float
     */
    private function calculateTotalAmount($pricePerMonth, $duration)
    {
        $subtotal = $pricePerMonth * $duration;
        $tax = $subtotal * 0.11;
        $insurance = $subtotal * 0.01;

        return $subtotal + $tax + $insurance;
    }

    /**
     * Calculate final payment amount based on payment method.
     *
     * @param float $total
     * @param string $paymentMethod
     * @return float
     */
    private function calculatePaymentAmount($total, $paymentMethod)
    {
        return $paymentMethod === 'full_payment' ? $total : $total * 0.3;
    }
}
