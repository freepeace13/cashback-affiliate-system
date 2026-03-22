<?php

namespace Cashback\Offers\Repositories;

/**
 * Full offer persistence contract for adapters that implement both reads and writes.
 */
interface OfferRepository extends OfferQueryRepository, OfferCommandRepository
{
}
