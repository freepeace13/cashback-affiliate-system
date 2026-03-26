<?php

namespace Cashback\Offers\Value;

use DateTimeImmutable;
use InvalidArgumentException;

final class DateRange
{
    public function __construct(
        private readonly DateTimeImmutable $start,
        private readonly DateTimeImmutable $end,
    ) {
        if ($start !== null && $end !== null && $end <= $start) {
            throw new InvalidArgumentException('End date must be after start date');
        }
    }

    public function startsAt(): DateTimeImmutable
    {
        return $this->start;
    }

    public function endsAt(): DateTimeImmutable
    {
        return $this->end;
    }
}
