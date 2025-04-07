<?php

namespace App\Repositories;

use App\Interfaces\TransactionRepositoryInterface;

/**
 * Repository to manage transaction data in session.
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
     * Save or update transaction data to session.
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
}
