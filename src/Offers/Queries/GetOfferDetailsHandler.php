<?php

namespace Cashback\Offers\Queries;

use Cashback\Offers\Contracts\Queries\GetOfferDetailsQueryHandler;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\DTOs\Queries\GetOfferDetailsQuery;
use Cashback\Offers\Mappers\OfferEntityMapper;
use Cashback\Offers\Repositories\OfferQueryRepository;

class GetOfferDetailsHandler implements GetOfferDetailsQueryHandler
{
    public function __construct(
        private OfferQueryRepository $offerQueries,
        private OfferEntityMapper $offerEntityMapper,
    ) {}

    public function handle(GetOfferDetailsQuery $query): ?OfferData
    {
        $identifier = $query->offerId;

        if (! is_int($identifier) && ! ctype_digit((string) $identifier)) {
            return null;
        }

        $offer = $this->offerQueries->find((int) $identifier);

        if ($offer === null) {
            return null;
        }

        return $this->offerEntityMapper->mapEntityToData($offer);
    }
}
