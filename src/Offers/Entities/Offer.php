<?php

namespace Cashback\Offers\Entities;

class Offer
{
    public function __construct(
        public  string $id,
        public string $name,
        public string $description,
        public string $trackingUrl,
        public string $cashbackType,
        public string $cashbackValue,
        public string $currency,
        public string $status,
        public string $createdAt,
        public string $updatedAt,
    ) {}
}