<?php

namespace Cashback\Offers\Contracts\Actions;

use Cashback\Offers\DTOs\Actions\GenerateOfferClickUrlData;

interface GeneratesOfferClickUrlAction
{
    public function generate(GenerateOfferClickUrlData $data): string;
}
