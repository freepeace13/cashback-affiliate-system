<?php

namespace Cashback\Tracking\Entities;

use DateTimeImmutable;

final class Click
{
    public function __construct(
        private string $id,
        private string $clickRef,
        private ?string $userId,
        private int $merchantId,
        private ?int $offerId,
        private int $affiliateNetworkId,
        private string $destinationUrl,
        private string $trackingUrl,
        private DateTimeImmutable $clickedAt,
    ) {}

    public function id(): string
    {
        return $this->id;
    }

    public function clickRef(): string
    {
        return $this->clickRef;
    }

    public function userId(): ?string
    {
        return $this->userId;
    }

    public function merchantId(): int
    {
        return $this->merchantId;
    }

    public function offerId(): ?int
    {
        return $this->offerId;
    }

    public function affiliateNetworkId(): int
    {
        return $this->affiliateNetworkId;
    }

    public function destinationUrl(): string
    {
        return $this->destinationUrl;
    }

    public function trackingUrl(): string
    {
        return $this->trackingUrl;
    }

    public function clickedAt(): DateTimeImmutable
    {
        return $this->clickedAt;
    }

    public function isAttributed(): bool
    {
        return $this->userId !== null;
    }
}
