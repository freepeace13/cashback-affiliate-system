<?php

namespace Cashback\Tests\Doubles\Mappers;

use Cashback\Offers\Entities\Offer;
use Cashback\Offers\Enums\OfferStatus;
use DateTimeImmutable;

class OfferMapper
{
    public static function toDomain(array $row): Offer
    {
        return new Offer(
            id: $row['id'],
            merchantId: $row['merchant_id'],
            affiliateNetworkId: $row['affiliate_network_id'],
            title: $row['title'],
            description: $row['description'],
            trackingUrl: $row['tracking_url'],
            cashbackType: $row['cashback_type'],
            cashbackValue: $row['cashback_value'],
            currency: $row['currency'],
            status: OfferStatus::from($row['status']),
            startsAt: $row['starts_at'] ? new DateTimeImmutable($row['starts_at']) : null,
            endsAt: $row['ends_at'] ? new DateTimeImmutable($row['ends_at']) : null,
        );
    }

    public static function toPersistence(Offer $offer): array
    {
        return [
            'id' => $offer->id(),
            'merchant_id' => $offer->merchantId(),
            'affiliate_network_id' => $offer->affiliateNetworkId(),
            'title' => $offer->title(),
            'description' => $offer->description(),
            'tracking_url' => $offer->trackingUrl(),
            'cashback_type' => $offer->cashbackType(),
            'cashback_value' => $offer->cashbackValue(),
            'currency' => $offer->currency(),
            'status' => $offer->status()->value,
            'starts_at' => $offer->startsAt()?->format('Y-m-d H:i:s'),
            'ends_at' => $offer->endsAt()?->format('Y-m-d H:i:s'),
        ];
    }
}
