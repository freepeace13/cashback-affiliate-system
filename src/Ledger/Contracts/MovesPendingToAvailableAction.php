<?php

namespace Cashback\Ledger\Contracts;

interface MovesPendingToAvailableAction
{
    public function move(string $userId): void;
}
