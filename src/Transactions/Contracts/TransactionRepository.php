<?php

namespace CashbackAffiliateSystem\Transactions\Contracts;

use CashbackAffiliateSystem\Transactions\Entities\Transaction;
use CashbackAffiliateSystem\Transactions\ValueObjects\TransactionID;
use CashbackAffiliateSystem\Transactions\ValueObjects\ExternalTransactionID;

interface TransactionRepository
{
    public function find(TransactionID $id): ?Transaction;

    public function findByExternalTransactionId(ExternalTransactionID $externalTransactionId): ?Transaction;

    public function listByUserId($userId): array;

    public function save(Transaction $transaction): void;
}