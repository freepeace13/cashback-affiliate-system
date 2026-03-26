<?php

namespace Cashback\Tracking\Entities;

use DateTimeImmutable;

final class Click
{
    public function __construct(
        protected string $id,
        protected string $clickRef,
        protected ?string $userId,
        protected int $merchantId,
        protected ?int $offerId,
        protected int $affiliateNetworkId,
        protected string $destinationUrl,
        protected string $trackingUrl,
        protected DateTimeImmutable $clickedAt,
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

    public function withId(string $id): self
    {
        return new self(
            id: $id,
            clickRef: $this->clickRef,
            userId: $this->userId,
            merchantId: $this->merchantId,
            offerId: $this->offerId,
            affiliateNetworkId: $this->affiliateNetworkId,
            destinationUrl: $this->destinationUrl,
            trackingUrl: $this->trackingUrl,
            clickedAt: $this->clickedAt,
        );
    }
}
