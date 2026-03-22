<?php

namespace Cashback\Tracking\DTOs\Actions;

final class RegisterExternalClickRefData
{
    public function __construct(
        public readonly string $clickRef,
        public readonly string $externalClickRef,
    ) {}
}
