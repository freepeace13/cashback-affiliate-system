<?php

namespace Cashback\Offers\Entities;

final class Merchant
{
    public function __construct(
        private int $id,
        private string $name,
        private string $slug,
        private string $status,
        private string $websiteUrl = '',
        private ?string $logoUrl = null,
    ) {}

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function status(): string
    {
        return $this->status;
    }

    public function websiteUrl(): string
    {
        return $this->websiteUrl;
    }

    public function logoUrl(): ?string
    {
        return $this->logoUrl;
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
