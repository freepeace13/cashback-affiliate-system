<?php

namespace Cashback\Payouts\Repositories;

use Cashback\Payouts\Entities\PayoutRequest;

interface PayoutRequestRepository
{
    public function find(int $id): ?PayoutRequest;

    public function findByUuid(string $uuid): ?PayoutRequest;

    public function save(PayoutRequest $request): void;

    /**
     * @return PayoutRequest[]
     */
    public function listByUserId(int $userId): array;
}

