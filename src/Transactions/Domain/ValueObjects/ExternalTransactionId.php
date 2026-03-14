<?php

final class ExternalTransactionId
{
    public function __construct(private string $value)
    {
        if (trim($value) === '') {
            throw new InvalidExternalTransactionId();
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value();
    }
}