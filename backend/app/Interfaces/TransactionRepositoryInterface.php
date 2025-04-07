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
     * @return mixed
     */
    public function getTransactionDataFromSession();

    /**
     * Save transaction data to session.
     *
     * @param mixed $data
     * @return void
     */
    public function saveTransactionDataToSession($data);
}
