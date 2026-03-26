<?php

namespace Cashback\Tracking\Contracts\Actions;

use Cashback\Tracking\DTOs\ClickData;
use Cashback\Tracking\DTOs\Actions\RecordOfferClickData;

interface RecordsOfferClickAction
{
    public function record(RecordOfferClickData $data): ClickData;
}
