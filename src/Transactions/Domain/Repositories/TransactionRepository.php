<?php

interface TransactionRepository
{
    public function findById(TransactionId $id): ?Transaction;

    public function save(Transaction $transaction): void;
}