<?php

namespace Cashback\Offers\Queries\GetOfferCashbackRule;

use Cashback\Offers\Repositories\OfferRepository;
use Cashback\Offers\ValueObjects\OfferID;

class GetOfferCashbackRuleHandler
{
    public function __construct(
        private OfferRepository $offerRepository,
    ) {}

    /**
     * @return array{cashbackType: string, cashbackValue: string, currency: string}|null
     */
    public function handle(GetOfferCashbackRuleQuery $query): ?array
    {
        $identifier = $query->offerId;

        if (!is_int($identifier) && !ctype_digit((string) $identifier)) {
            return null;
        }

        $offer = $this->offerRepository->find(new OfferID((string) $identifier));

        if ($offer === null) {
            return null;
        }

        return [
            'cashbackType' => $offer->cashbackType(),
            'cashbackValue' => (string) $offer->cashbackValue(),
            'currency' => $offer->currency(),
        ];
    }
}

