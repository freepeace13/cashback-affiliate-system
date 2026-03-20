<?php

namespace Cashback\Offers\Contracts\Actions;

interface AssignOfferNetworkAction
{
    public function assign(int $offerId, int $networkId): void;
}