<?php

namespace App\Interfaces;

interface TransactionRepositoryInterface
{
    public function getTransactionDataFromSession(): ?array;

    public function saveTransactionDataToSession(array $data): void;

    public function saveTransaction(array $data);

    public function getTransactionByCode(string $code);
}
