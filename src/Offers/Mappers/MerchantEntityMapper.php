<?php

namespace Cashback\Offers\Mappers;

use Cashback\Offers\Entities\Merchant;
use Cashback\Offers\DTOs\MerchantData;

class MerchantEntityMapper
{
    public function mapDataToEntity(MerchantData $data): Merchant
    {
        return new Merchant(
            id: $data->id,
            name: $data->name,
            slug: $data->slug,
            status: $data->status,
            websiteUrl: $data->websiteUrl ?? '',
            logoUrl: $data->logoUrl ?? '',
        );
    }

    public function mapEntityToData(Merchant $entity): MerchantData
    {
        return new MerchantData(
            id: $entity->id(),
            name: $entity->name(),
            slug: $entity->slug(),
            status: $entity->status(),
            websiteUrl: $entity->websiteUrl(),
            logoUrl: $entity->logoUrl() !== '' ? $entity->logoUrl() : null,
        );
    }

    /**
     * @param  array<string, mixed>  $validated  Output of {@see UpdateMerchantData::validate()}
     */
    public function mapValidatedUpdateToData(array $validated): MerchantData
    {
        $status = $validated['status'] ?? 'active';

        return new MerchantData(
            id: (int) $validated['id'],
            name: $validated['name'],
            slug: $validated['slug'],
            websiteUrl: $validated['website_url'] ?? '',
            logoUrl: $validated['logo_url'] ?? '',
            status: $status,
        );
    }
}
