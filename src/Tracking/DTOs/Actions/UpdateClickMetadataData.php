<?php

namespace Cashback\Tracking\DTOs\Actions;

final class UpdateClickMetadataData
{
    public function __construct(
        public readonly string $clickRef,
        public readonly array $metadata,
    ) {}
}
