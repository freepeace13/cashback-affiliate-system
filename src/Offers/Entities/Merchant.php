<?php

namespace Cashback\Offers\Entities;

class Merchant
{
    public function __construct(
        protected int $id,
        protected string $name,
        protected string $slug,
        protected string $status,
        protected string $websiteUrl,
        protected string $logoUrl,
    ) {}

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

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

    public function logoUrl(): string
    {
        return $this->logoUrl;
    }
}
