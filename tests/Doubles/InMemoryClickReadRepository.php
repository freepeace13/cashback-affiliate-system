<?php

namespace Cashback\Tests\Doubles;

use Cashback\Tracking\Entities\Click;
use Cashback\Tracking\Repositories\ClickReadRepository;

final class InMemoryClickReadRepository implements ClickReadRepository
{
    /**
     * @param list<Click> $clicks
     */
    public function __construct(
        private array $clicks = [],
    ) {}

    public function find(string $id): ?Click
    {
        foreach ($this->clicks as $click) {
            if ($click->id() === $id) {
                return $click;
            }
        }

        return null;
    }

    public function listByOfferId(int $offerId): array
    {
        return array_values(array_filter(
            $this->clicks,
            fn (Click $click) => $click->offerId() === $offerId
        ));
    }
}
