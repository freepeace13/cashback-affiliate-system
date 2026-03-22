<?php

namespace Cashback\Tracking\Contracts\Queries;

use Cashback\Tracking\DTOs\Queries\ListClicksByOfferQuery;
use Cashback\Tracking\DTOs\ClickData;

interface ListsClicksByOfferQueryHandler
{
    /**
     * @return ClickData[]
     */
    public function handle(ListClicksByOfferQuery $query): array;
}
