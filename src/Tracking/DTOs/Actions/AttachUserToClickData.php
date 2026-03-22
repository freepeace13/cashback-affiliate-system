<?php

namespace Cashback\Tracking\DTOs\Actions;

final class AttachUserToClickData
{
    public function __construct(
        public readonly string $clickRef,
        public readonly string $userId,
    ) {}
}
