<?php

namespace Cashback\Offers\Queries;

use Cashback\Offers\Contracts\Queries\ListAvailableOffersQueryHandler;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\DTOs\Queries\ListAvailableOffersQuery;
use Cashback\Offers\Repositories\OfferQueryRepository;
use Cashback\Offers\Services\OfferListProjector;
use DateTimeImmutable;

class ListAvailableOffersHandler implements ListAvailableOffersQueryHandler
{
    public function __construct(
        private OfferQueryRepository $offerQueries,
        private OfferListProjector $offerListProjector,
    ) {}

    /**
     * @return OfferData[]
     */
    public function handle(ListAvailableOffersQuery $query): array
    {
        $asOf = $query->asOf ?? new DateTimeImmutable;

        return $this->offerListProjector->toDataList(
            $this->offerQueries->listAvailableOffers($asOf)
        );
    }
}
