<?php

interface TransactionConfirmableSpecification
{
    public function isSatisfiedBy(Transaction $transaction): bool;
}