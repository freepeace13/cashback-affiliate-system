<?php

namespace Cashback\Tests\Doubles\Mappers;

use Cashback\Offers\Entities\Merchant;

class MerchantMapper
{
    public static function toDomain(array $row): Merchant
    {
        return new Merchant(
            id: $row['id'],
            name: $row['name'],
            slug: $row['slug'],
            status: $row['status'],
            websiteUrl: $row['website_url'],
            logoUrl: $row['logo_url'],
        );
    }

    public static function toPersistence(Merchant $merchant): array
    {
        return [
            'id' => $merchant->id(),
            'name' => $merchant->name(),
            'slug' => $merchant->slug(),
            'status' => $merchant->status(),
            'website_url' => $merchant->websiteUrl(),
            'logo_url' => $merchant->logoUrl(),
        ];
    }
}
