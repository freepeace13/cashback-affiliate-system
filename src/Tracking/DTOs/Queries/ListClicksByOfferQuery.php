<?php

namespace Cashback\Tracking\DTOs\Queries;

final class ListClicksByOfferQuery
{
    public function __construct(
        public readonly int $offerId,
    ) {}
}
