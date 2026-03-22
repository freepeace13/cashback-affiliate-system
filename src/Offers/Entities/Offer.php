<?php

namespace Cashback\Offers\Entities;

use Cashback\Offers\Enums\OfferStatus;
use DateTimeImmutable;
use InvalidArgumentException;

final class Offer
{
    public function __construct(
        private readonly int $id,
        private readonly int $merchantId,
        private readonly int $affiliateNetworkId,
        private readonly string $title,
        private readonly ?string $description,
        private readonly string $trackingUrl,
        private readonly string $cashbackType,
        private readonly float $cashbackValue,
        private readonly string $currency,
        private readonly OfferStatus $status,
        private readonly ?DateTimeImmutable $startsAt = null,
        private readonly ?DateTimeImmutable $endsAt = null,
    ) {}

    public function id(): int
    {
        return $this->id;
    }

    public function merchantId(): int
    {
        return $this->merchantId;
    }

    public function affiliateNetworkId(): int
    {
        return $this->affiliateNetworkId;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function trackingUrl(): string
    {
        return $this->trackingUrl;
    }

    public function cashbackType(): string
    {
        return $this->cashbackType;
    }

    public function cashbackValue(): float
    {
        return $this->cashbackValue;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function status(): OfferStatus
    {
        return $this->status;
    }

    public function startsAt(): ?DateTimeImmutable
    {
        return $this->startsAt;
    }

    public function endsAt(): ?DateTimeImmutable
    {
        return $this->endsAt;
    }

    public function isAvailable(DateTimeImmutable $at): bool
    {
        if ($this->status !== OfferStatus::ACTIVE) {
            return false;
        }
        if ($this->startsAt !== null && $at < $this->startsAt) {
            return false;
        }
        if ($this->endsAt !== null && $at > $this->endsAt) {
            return false;
        }

        return true;
    }

    /**
     * Invariant when both bounds are set: end must be strictly after start.
     */
    public static function ensureValidAvailabilityWindow(
        ?DateTimeImmutable $startsAt,
        ?DateTimeImmutable $endsAt,
    ): void {
        if ($startsAt !== null && $endsAt !== null && $endsAt <= $startsAt) {
            throw new InvalidArgumentException('Offer availability end must be after start');
        }
    }

    public function withMerchantId(int $merchantId): self
    {
        return new self(
            id: $this->id,
            merchantId: $merchantId,
            affiliateNetworkId: $this->affiliateNetworkId,
            title: $this->title,
            description: $this->description,
            trackingUrl: $this->trackingUrl,
            cashbackType: $this->cashbackType,
            cashbackValue: $this->cashbackValue,
            currency: $this->currency,
            status: $this->status,
            startsAt: $this->startsAt,
            endsAt: $this->endsAt,
        );
    }

    public function withAffiliateNetworkId(int $affiliateNetworkId): self
    {
        return new self(
            id: $this->id,
            merchantId: $this->merchantId,
            affiliateNetworkId: $affiliateNetworkId,
            title: $this->title,
            description: $this->description,
            trackingUrl: $this->trackingUrl,
            cashbackType: $this->cashbackType,
            cashbackValue: $this->cashbackValue,
            currency: $this->currency,
            status: $this->status,
            startsAt: $this->startsAt,
            endsAt: $this->endsAt,
        );
    }

    public function withSchedule(?DateTimeImmutable $startsAt, ?DateTimeImmutable $endsAt): self
    {
        return new self(
            id: $this->id,
            merchantId: $this->merchantId,
            affiliateNetworkId: $this->affiliateNetworkId,
            title: $this->title,
            description: $this->description,
            trackingUrl: $this->trackingUrl,
            cashbackType: $this->cashbackType,
            cashbackValue: $this->cashbackValue,
            currency: $this->currency,
            status: $this->status,
            startsAt: $startsAt,
            endsAt: $endsAt,
        );
    }
}
