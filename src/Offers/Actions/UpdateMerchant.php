<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Entities\Merchant;
use Cashback\Offers\Repositories\MerchantRepository;
use Cashback\Offers\DTOs\MerchantData;
use Cashback\Offers\Contracts\UpdatesMerchantAction;
use Cashback\Offers\ValueObjects\MerchantID;
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