<?php

namespace Cashback\Tracking\Events;

use Cashback\Tracking\DTOs\ClickData;

final class ClickCreated
{
    public function __construct(
        public readonly ClickData $clickData,
        public readonly \DateTimeImmutable $createdAt,
    ) {}
}
