<?php

namespace Cashback\Offers\Mappers;

use Cashback\Offers\DTOs\OfferCashbackRuleData;
use Cashback\Offers\DTOs\OfferData;
use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Enums\OfferStatus;
use Cashback\Offers\Services\OfferValidatedScheduleInput;

class OfferEntityMapper
{
    public function mapDataToEntity(OfferData $data): Offer
    {
        return new Offer(
            id: $data->id,
            merchantId: $data->merchantId,
            affiliateNetworkId: $data->affiliateNetworkId,
            title: $data->title,
            description: $data->description,
            trackingUrl: $data->trackingUrl,
            cashbackType: $data->cashbackType,
            cashbackValue: (float) $data->cashbackValue,
            currency: $data->currency,
            status: OfferStatus::from($data->status),
            startsAt: $data->startsAt,
            endsAt: $data->endsAt,
        );
    }

    public function mapEntityToData(Offer $entity): OfferData
    {
        return new OfferData(
            id: $entity->id(),
            merchantId: $entity->merchantId(),
            affiliateNetworkId: $entity->affiliateNetworkId(),
            title: $entity->title(),
            description: $entity->description(),
            trackingUrl: $entity->trackingUrl(),
            cashbackType: $entity->cashbackType(),
            cashbackValue: (string) $entity->cashbackValue(),
            currency: $entity->currency(),
            status: $entity->status()->value,
            startsAt: $entity->startsAt(),
            endsAt: $entity->endsAt(),
        );
    }

    public function mapEntityToCashbackRuleData(Offer $entity): OfferCashbackRuleData
    {
        return new OfferCashbackRuleData(
            cashbackType: $entity->cashbackType(),
            cashbackValue: (string) $entity->cashbackValue(),
            currency: $entity->currency(),
        );
    }

    /**
     * @param  array<string, mixed>  $validated  Output of {@see UpdateOfferData::validate()}
     */
    public function mapValidatedUpdateToData(array $validated, Offer $existing): OfferData
    {
        $status = ($validated['status'] ?? '') !== '' ? $validated['status'] : 'active';

        return new OfferData(
            id: (int) $validated['id'],
            title: $validated['title'],
            description: $validated['description'] !== '' ? $validated['description'] : null,
            trackingUrl: $validated['trackingUrl'],
            cashbackType: $validated['cashbackType'],
            cashbackValue: (string) $validated['cashbackValue'],
            currency: $validated['currency'],
            status: $status,
            merchantId: (int) $validated['merchantId'],
            affiliateNetworkId: (int) $validated['affiliateNetworkId'],
            startsAt: OfferValidatedScheduleInput::optionalDateTimeOrKeepExisting($validated, 'startsAt', $existing->startsAt()),
            endsAt: OfferValidatedScheduleInput::optionalDateTimeOrKeepExisting($validated, 'endsAt', $existing->endsAt()),
        );
    }
}
