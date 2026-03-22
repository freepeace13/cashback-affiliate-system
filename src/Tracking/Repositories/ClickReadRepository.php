<?php

namespace Cashback\Tracking\Repositories;

use Cashback\Tracking\Entities\Click;

interface ClickReadRepository
{
    public function find(string $id): ?Click;

    public function listByOfferId(int $offerId): array;
}
