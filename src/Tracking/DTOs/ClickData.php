<?php

namespace Cashback\Tracking\DTOs;

final class ClickData
{
    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly string $clickRef = '',
    ) {}
}