<?php

namespace Cashback\Offers\DTOs\Queries;

use DateTimeImmutable;

class ListAvailableOffersQuery
{
    public function __construct(
        public readonly ?DateTimeImmutable $asOf = null,
    ) {}
}
