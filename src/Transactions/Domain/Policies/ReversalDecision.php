<?php

declare(strict_types=1);

final class ReversalDecision
{
    public function __construct(
        public readonly bool $allowed,
        public readonly ?string $ledgerBucketToDebit,
        public readonly ?int $amountInMinor,
        public readonly ?string $reason = null,
    ) {}

    public static function allow(string $bucket, int $amountInMinor): self
    {
        return new self(true, $bucket, $amountInMinor);
    }

    public static function deny(string $reason): self
    {
        return new self(false, null, null, $reason);
    }
}