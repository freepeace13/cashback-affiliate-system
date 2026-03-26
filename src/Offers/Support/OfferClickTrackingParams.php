<?php

namespace Cashback\Offers\Support;

use InvalidArgumentException;

final class OfferClickTrackingParams
{
    /**
     * @return array{userId:string, offerId:string, destinationUrl:string}
     */
    public static function fromUrl(string $url): array
    {
        $query = parse_url($url, PHP_URL_QUERY);
        if (! is_string($query) || $query === '') {
            throw new InvalidArgumentException('Click URL is missing query parameters');
        }

        parse_str($query, $params);

        $required = ['userId', 'offerId', 'destinationUrl'];
        foreach ($required as $key) {
            if (! isset($params[$key]) || ! is_string($params[$key]) || trim($params[$key]) === '') {
                throw new InvalidArgumentException("Click URL is missing required parameter: {$key}");
            }
        }

        return [
            'userId' => $params['userId'],
            'offerId' => $params['offerId'],
            'destinationUrl' => $params['destinationUrl'],
        ];
    }
}
