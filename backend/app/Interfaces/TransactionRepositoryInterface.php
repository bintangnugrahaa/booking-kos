<?php

namespace App\Interfaces;

/**
 * Interface for transaction repository to manage transaction data in session.
 */
interface TransactionRepositoryInterface
{
    /**
     * Get transaction data from session.
     *
     * @return array|null
     */
    public function getTransactionDataFromSession();

    /**
     * Save transaction data to session.
     *
     * @param array $data
     * @return void
     */
    public function saveTransactionDataToSession($data);

    /**
     * Save the final transaction.
     *
     * @param array $data
     * @return mixed
     */
    public function saveTransaction($data);
}
