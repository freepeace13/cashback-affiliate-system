<?php

namespace Cashback\Tracking\Mappers;

use Cashback\Tracking\Entities\Click;
use Cashback\Tracking\DTOs\ClickData;

class ClickEntityMapper
{
    public function mapEntityToData(Click $entity): ClickData
    {
        return new ClickData(
            id: $entity->id(),
            userId: $entity->userId() ?? '',
            clickRef: $entity->clickRef(),
        );
    }

    public function mapDataToEntity(ClickData $data): Click
    {
        return new Click(
            id: $data->id,
            userId: $data->userId !== '' ? $data->userId : null,
            merchantId: (int) $data->merchantId,
            offerId: $data->offerId !== '' ? (int) $data->offerId : null,
            affiliateNetworkId: (int) $data->affiliateNetworkId,
            destinationUrl: $data->destinationUrl,
            trackingUrl: $data->trackingUrl,
            clickedAt: new \DateTimeImmutable(),
            clickRef: $data->clickRef,
        );
    }
}
