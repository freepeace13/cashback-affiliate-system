<?php

namespace Cashback\Offers\Repositories;

use Cashback\Offers\Entities\Offer;
use DateTimeImmutable;

/**
 * Read-only persistence port for offers (interface segregation: query side).
 */
interface OfferQueryRepository
{
    /**
     * @return list<Offer>
     */
    public function listActiveOffers(): array;

    /**
     * Offers that are {@see Offer::isAvailable()} at the given instant.
     *
     * @return list<Offer>
     */
    public function listAvailableOffers(DateTimeImmutable $asOf): array;

    /**
     * @return list<Offer>
     */
    public function listOffersByAffiliateNetwork(int $affiliateNetworkId): array;

    /**
     * @return list<Offer>
     */
    public function listMerchantOffers(int $merchantId): array;

    public function find(int|string $id): ?Offer;
}
