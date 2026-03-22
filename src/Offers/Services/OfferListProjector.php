<?php

namespace Cashback\Offers\Services;

use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Mappers\OfferEntityMapper;

/**
 * Maps collections of {@see Offer} entities to read DTOs (query-side projection).
 */
final class OfferListProjector
{
    public function __construct(
        private OfferEntityMapper $entityMapper,
    ) {}

    /**
     * @param  iterable<int, Offer>  $offers
     * @return list<OfferData>
     */
    public function toDataList(iterable $offers): array
    {
        $out = [];
        foreach ($offers as $offer) {
            $out[] = $this->entityMapper->mapEntityToData($offer);
        }

        return $out;
    }
}
