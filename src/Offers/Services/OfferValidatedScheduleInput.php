<?php

namespace Cashback\Offers\Services;

use DateTimeImmutable;

/**
 * Parses optional schedule bounds from validated action input (single responsibility: string/array → datetime).
 */
final class OfferValidatedScheduleInput
{
    /**
     * @param  array<string, mixed>  $validated
     */
    public static function optionalDateTime(array $validated, string $key): ?DateTimeImmutable
    {
        $v = $validated[$key] ?? null;
        if ($v === null || $v === '') {
            return null;
        }

        return new DateTimeImmutable((string) $v);
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    public static function optionalDateTimeOrKeepExisting(
        array $validated,
        string $key,
        ?DateTimeImmutable $existing,
    ): ?DateTimeImmutable {
        $v = $validated[$key] ?? null;
        if ($v === null || $v === '') {
            return $existing;
        }

        return new DateTimeImmutable((string) $v);
    }
}
