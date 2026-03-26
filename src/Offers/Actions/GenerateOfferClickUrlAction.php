<?php

namespace Cashback\Offers\Actions;

use Cashback\Offers\Contracts\Actions\GeneratesOfferClickUrlAction as GeneratesOfferClickUrlActionContract;
use Cashback\Offers\DTOs\Actions\GenerateOfferClickUrlData;

final class GenerateOfferClickUrlAction implements GeneratesOfferClickUrlActionContract
{
    public function generate(GenerateOfferClickUrlData $data): string
    {
        $validated = $data->validate();

        $baseUrl = rtrim($validated['baseUrl'], '/');
        $path = ltrim($validated['path'], '/');

        $parts = parse_url($path);
        $pathWithoutQuery = $parts['path'] ?? '';

        $existingQuery = [];
        if (isset($parts['query']) && $parts['query'] !== '') {
            parse_str($parts['query'], $existingQuery);
        }

        $query = array_merge($existingQuery, [
            'userId' => $validated['userId'],
            'offerId' => $validated['offerId'],
            'destinationUrl' => $validated['destinationUrl'],
        ]);

        $url = "{$baseUrl}/{$pathWithoutQuery}";
        $queryString = http_build_query($query);

        if ($queryString === '') {
            return $url;
        }

        return "{$url}?{$queryString}";
    }
}
