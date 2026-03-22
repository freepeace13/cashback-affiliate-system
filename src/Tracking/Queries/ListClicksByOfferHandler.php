<?php

namespace Cashback\Tracking\Queries;

use Cashback\Tracking\Contracts\Queries\ListsClicksByOfferQueryHandler;
use Cashback\Tracking\DTOs\ClickData;
use Cashback\Tracking\DTOs\Queries\ListClicksByOfferQuery;
use Cashback\Tracking\Entities\Click;
use Cashback\Tracking\Repositories\ClickReadRepository;
use Cashback\Tracking\Mappers\ClickEntityMapper;

class ListClicksByOfferHandler implements ListsClicksByOfferQueryHandler
{
    public function __construct(
        private ClickReadRepository $clickReadRepository,
        private ClickEntityMapper $clickEntityMapper,
    ) {}

    /**
     * @return ClickData[]
     */
    public function handle(ListClicksByOfferQuery $query): array
    {
        $recordedClicks = $this->clickReadRepository->listByOfferId($query->offerId);

        return array_map(
            fn(Click $click): ClickData => $this->clickEntityMapper->mapEntityToData($click),
            $recordedClicks
        );
    }
}
