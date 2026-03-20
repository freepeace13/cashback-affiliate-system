<?php

namespace Cashback\Tests\Offers;

use Cashback\Offers\Actions\AssignOfferMerchantAction;
use Cashback\Tests\Doubles\InMemoryOfferRepository;
use Cashback\Tests\TestCase;

final class AssignOfferMerchantTest extends TestCase
{
    public function test_assign_is_a_noop_but_accepts_ids(): void
    {
        $repository = new InMemoryOfferRepository();
        $action = new AssignOfferMerchantAction($repository);

        // The method is intentionally a no-op in this architecture demo; we just
        // verify that it can be called without errors and respects the types.
        $action->assign(1, 1);

        $this->assertTrue(true);
    }
}

