<?php

namespace Cashback\Tracking\DTOs\Actions;

final class RecordOfferClickData
{
    public function __construct(
        public readonly string $userId,
        public readonly string $offerId,
        public readonly string $destinationUrl,
    ) {}
}
