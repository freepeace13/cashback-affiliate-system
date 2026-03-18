<?php

namespace Cashback\Tests\Offers;

use Cashback\Offers\Actions\AssignOfferMerchant;
use Cashback\Offers\ValueObjects\MerchantID;
use Cashback\Offers\ValueObjects\OfferID;
use Cashback\Tests\Doubles\InMemoryOfferRepository;
use Cashback\Tests\TestCase;

final class AssignOfferMerchantTest extends TestCase
{
    public function test_assign_is_a_noop_but_accepts_ids(): void
    {
        $repository = new InMemoryOfferRepository();
        $action = new AssignOfferMerchant($repository);

        $offerId = new OfferID('offer-1');
        $merchantId = new MerchantID('merchant-1');

        // The method is intentionally a no-op in this architecture demo; we just
        // verify that it can be called without errors and respects the types.
        $action->assign($offerId, $merchantId);

        $this->assertTrue(true);
    }
}

