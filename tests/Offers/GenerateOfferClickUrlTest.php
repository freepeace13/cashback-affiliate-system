<?php

namespace Cashback\Tests\Offers;

use Cashback\Offers\Actions\GenerateOfferClickUrlAction;
use Cashback\Offers\DTOs\Actions\GenerateOfferClickUrlData;
use Cashback\Offers\Support\OfferClickTrackingParams;
use Cashback\Tests\TestCase;
use InvalidArgumentException;

final class GenerateOfferClickUrlTest extends TestCase
{
    public function test_it_generates_click_url_with_expected_params(): void
    {
        $action = new GenerateOfferClickUrlAction();

        $url = $action->generate(new GenerateOfferClickUrlData(
            baseUrl: 'https://cashback.test',
            path: '/click/redirect',
            userId: '42',
            offerId: '17',
            destinationUrl: 'https://merchant.test/product',
        ));

        $this->assertStringStartsWith('https://cashback.test/click/redirect?', $url);
        $params = OfferClickTrackingParams::fromUrl($url);

        $this->assertSame('42', $params['userId']);
        $this->assertSame('17', $params['offerId']);
        $this->assertSame('https://merchant.test/product', $params['destinationUrl']);
    }

    public function test_it_preserves_existing_query_params_from_path(): void
    {
        $action = new GenerateOfferClickUrlAction();

        $url = $action->generate(new GenerateOfferClickUrlData(
            baseUrl: 'https://cashback.test/',
            path: '/click/redirect?utm=offer-list',
            userId: '42',
            offerId: '17',
            destinationUrl: 'https://merchant.test/product',
        ));

        parse_str((string) parse_url($url, PHP_URL_QUERY), $query);
        $this->assertSame('offer-list', $query['utm']);
        $this->assertSame('42', $query['userId']);
        $this->assertSame('17', $query['offerId']);
        $this->assertSame('https://merchant.test/product', $query['destinationUrl']);
    }

    public function test_it_throws_when_required_tracking_params_are_missing(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Click URL is missing required parameter: offerId');

        OfferClickTrackingParams::fromUrl('https://cashback.test/click/redirect?userId=42&destinationUrl=https%3A%2F%2Fmerchant.test');
    }
}
