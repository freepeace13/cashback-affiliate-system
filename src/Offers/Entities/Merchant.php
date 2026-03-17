<?php

namespace Cashback\Offers\Entities;

class Merchant
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
    ) {}
}