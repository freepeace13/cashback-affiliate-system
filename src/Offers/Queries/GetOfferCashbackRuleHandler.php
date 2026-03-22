<?php

namespace Cashback\Offers\Queries;

use Cashback\Offers\Contracts\Queries\GetOfferCashbackRuleQueryHandler;
use Cashback\Offers\DTOs\OfferCashbackRuleData;
use Cashback\Offers\DTOs\Queries\GetOfferCashbackRuleQuery;
use Cashback\Offers\Mappers\OfferEntityMapper;
use Cashback\Offers\Repositories\OfferQueryRepository;

class GetOfferCashbackRuleHandler implements GetOfferCashbackRuleQueryHandler
{
    public function __construct(
        private OfferQueryRepository $offerQueries,
        private OfferEntityMapper $offerEntityMapper,
    ) {}

    public function handle(GetOfferCashbackRuleQuery $query): ?OfferCashbackRuleData
    {
        $identifier = $query->offerId;

        if (! is_int($identifier) && ! ctype_digit((string) $identifier)) {
            return null;
        }

        $offer = $this->offerQueries->find((int) $identifier);

        if ($offer === null) {
            return null;
        }

        return $this->offerEntityMapper->mapEntityToCashbackRuleData($offer);
    }
}
