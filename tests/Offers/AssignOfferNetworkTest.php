<?php

namespace Cashback\Tests\Offers;

use Cashback\Offers\Actions\AssignOfferNetwork;
use Cashback\Offers\ValueObjects\NetworkID;
use Cashback\Offers\ValueObjects\OfferID;
use Cashback\Tests\Doubles\InMemoryOfferRepository;
use Cashback\Tests\TestCase;

final class AssignOfferNetworkTest extends TestCase
{
    public function test_assign_is_a_noop_but_accepts_ids(): void
    {
        $repository = new InMemoryOfferRepository();
        $action = new AssignOfferNetwork($repository);

        $offerId = new OfferID('offer-1');
        $networkId = new NetworkID('network-1');

        // The method is intentionally a no-op in this architecture demo; we just
        // verify that it can be called without errors and respects the types.
        $action->assign($offerId, $networkId);

        $this->assertTrue(true);
    }
}

