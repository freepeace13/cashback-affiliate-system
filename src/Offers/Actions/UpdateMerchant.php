<?php

namespace CashbackAffiliateSystem\Offers\Actions;

use CashbackAffiliateSystem\Offers\Entities\Merchant;
use CashbackAffiliateSystem\Offers\Repositories\MerchantRepository;
use CashbackAffiliateSystem\Offers\DTOs\MerchantData;
use CashbackAffiliateSystem\Offers\Contracts\UpdatesMerchantAction;
use CashbackAffiliateSystem\Offers\ValueObjects\MerchantID;
use RuntimeException;

class UpdateMerchant implements UpdatesMerchantAction
{
    public function __construct(
        private MerchantRepository $merchantRepository
    ) {}

    public function update(MerchantID $id, MerchantData $data): MerchantData
    {
        $existing = $this->merchantRepository->find($id);

        if (! $existing instanceof Merchant) {
            throw new RuntimeException('Merchant not found for ID '.$id->value());
        }

        $updated = new Merchant(
            id: $existing->id,
            name: $data->name,
        );

        $this->merchantRepository->update($id, $updated);

        // Map back to DTO (for now, we use the provided data as the source of truth).
        return $data;
    }
}