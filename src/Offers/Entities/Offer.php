<?php

namespace Cashback\Offers\Entities;

use Cashback\Offers\Enums\OfferStatus;
use DateTimeImmutable;
use InvalidArgumentException;

final class Offer
{
    public function __construct(
        protected int $id,
        protected int $merchantId,
        protected int $affiliateNetworkId,
        protected string $title,
        protected ?string $description,
        protected string $trackingUrl,
        protected string $cashbackType,
        protected float $cashbackValue,
        protected string $currency,
        protected OfferStatus $status,
        protected ?DateTimeImmutable $startsAt = null,
        protected ?DateTimeImmutable $endsAt = null,
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

    public function withTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function withDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function trackingUrl(): string
    {
        return $this->trackingUrl;
    }

    public function withTrackingUrl(string $trackingUrl): self
    {
        $this->trackingUrl = $trackingUrl;

        return $this;
    }

    public function cashbackType(): string
    {
        return $this->cashbackType;
    }

    public function withCashbackType(string $cashbackType): self
    {
        $this->cashbackType = $cashbackType;

        return $this;
    }

    public function cashbackValue(): float
    {
        return $this->cashbackValue;
    }

    public function withCashbackValue(float $cashbackValue): self
    {
        $this->cashbackValue = $cashbackValue;

        return $this;
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
        $this->merchantId = $merchantId;

        return $this;
    }

    public function withAffiliateNetworkId(int $affiliateNetworkId): self
    {
        $this->affiliateNetworkId = $affiliateNetworkId;

        return $this;
    }

    public function withSchedule(?DateTimeImmutable $startsAt, ?DateTimeImmutable $endsAt): self
    {
        self::ensureValidAvailabilityWindow($startsAt, $endsAt);

        $this->startsAt = $startsAt;
        $this->endsAt = $endsAt;

        return $this;
    }
}
