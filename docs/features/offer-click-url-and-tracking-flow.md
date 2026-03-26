# Offer Click URL and Tracking Flow

## Purpose

This document describes the design and usage of the new offer click flow:

1. Generate a click URL in the `Offers` module.
2. Extract required click parameters from that URL.
3. Record the click in the `Tracking` module with offer-derived tracking fields.

The controller/router is intentionally outside this project, so callers provide both `baseUrl` and `path`.

## Design Overview

### Offers: URL generation and extraction

- `Cashback\Offers\Actions\GenerateOfferClickUrlAction`
  - Accepts `GenerateOfferClickUrlData`.
  - Builds URL from:
    - `baseUrl` (host/app base)
    - `path` (controller/routing path, may include query string)
    - canonical params: `userId`, `offerId`, `destinationUrl`
  - Preserves existing query parameters from `path`.

- `Cashback\Offers\Support\OfferClickTrackingParams`
  - Parses a generated URL and extracts only required params:
    - `userId`
    - `offerId`
    - `destinationUrl`
  - Throws `InvalidArgumentException` when required params are missing/empty.

### Tracking: purpose-specific click recording

- `Cashback\Tracking\Actions\RecordOfferClick`
  - Replaces the old generic `CreateClick` naming with a specific action purpose.
  - Accepts minimal input DTO `RecordOfferClickData`:
    - `userId`
    - `offerId`
    - `destinationUrl`
  - Derives offer-linked fields by querying `OfferQueryRepository` with `offerId`:
    - `merchantId`
    - `affiliateNetworkId`
    - `trackingUrl`
  - Persists click through `ClickWriteRepository` and emits `ClickCreated`.
  - Throws `OfferNotFoundForClick` when the offer does not exist.

## Why this shape

- Keeps URL concerns in `Offers`, not in controllers.
- Keeps recording concerns in `Tracking`.
- Reduces DTO coupling by passing only the minimum data across boundary.
- Prevents callers from duplicating or spoofing offer-linked tracking fields that can be derived from trusted offer data.

## Usage

## 1) Generate an offer click URL

```php
use Cashback\Offers\Actions\GenerateOfferClickUrlAction;
use Cashback\Offers\DTOs\Actions\GenerateOfferClickUrlData;

$generator = new GenerateOfferClickUrlAction();

$clickUrl = $generator->generate(new GenerateOfferClickUrlData(
    baseUrl: 'https://cashback.example',
    path: '/click/redirect?utm=offer-list',
    userId: 'user-42',
    offerId: '17',
    destinationUrl: 'https://merchant.example/product/123',
));
```

Example output shape:

`https://cashback.example/click/redirect?utm=offer-list&userId=user-42&offerId=17&destinationUrl=...`

## 2) Extract required params from URL

```php
use Cashback\Offers\Support\OfferClickTrackingParams;

$params = OfferClickTrackingParams::fromUrl($clickUrl);
// ['userId' => 'user-42', 'offerId' => '17', 'destinationUrl' => 'https://merchant.example/product/123']
```

## 3) Record click in Tracking

```php
use Cashback\Tracking\Actions\RecordOfferClick;
use Cashback\Tracking\DTOs\Actions\RecordOfferClickData;

$result = $recordOfferClick->record(new RecordOfferClickData(
    userId: $params['userId'],
    offerId: $params['offerId'],
    destinationUrl: $params['destinationUrl'],
));
```

`RecordOfferClick` will derive `merchantId`, `affiliateNetworkId`, and `trackingUrl` from the offer identified by `offerId`.

## Error handling

- URL extraction errors: `InvalidArgumentException` from `OfferClickTrackingParams::fromUrl`.
- Missing offer during click recording: `OfferNotFoundForClick` from `RecordOfferClick`.

## Test coverage

Current tests that validate this design:

- `tests/Offers/GenerateOfferClickUrlTest.php`
- `tests/Tracking/RecordOfferClickTest.php`
- `tests/Integration/OfferClickTrackingFlowTest.php`
