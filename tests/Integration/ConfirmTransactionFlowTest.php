<?php

namespace Cashback\Tests\Integration;

use Cashback\Tests\TestCase;

/**
 * Reserved for a future full-stack flow (e.g. click → transaction → ledger).
 * Current coverage is unit-style tests under tests/Offers and tests/Tracking with in-memory doubles.
 */
final class ConfirmTransactionFlowTest extends TestCase
{
    public function test_placeholder(): void
    {
        $this->markTestSkipped(
            'End-to-end integration (DB, queues, webhooks) is not wired in this demo repo yet.'
        );
    }
}
