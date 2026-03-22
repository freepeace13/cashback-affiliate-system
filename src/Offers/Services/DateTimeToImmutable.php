<?php

namespace Cashback\Offers\Services;

use DateTimeImmutable;
use DateTimeInterface;

final class DateTimeToImmutable
{
    public static function convert(DateTimeInterface $date): DateTimeImmutable
    {
        return $date instanceof DateTimeImmutable
            ? $date
            : DateTimeImmutable::createFromInterface($date);
    }
}
