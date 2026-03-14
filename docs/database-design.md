# Cashback Affiliate System — Database Schema

## Overview

Core tables required for the system:

```
users
affiliate_networks
merchants
offers
clicks
network_events
transactions
ledger_entries
payout_requests
```

Relationship overview:

```
users
  └── clicks
        └── transactions
              └── ledger_entries

merchants
  └── offers
        └── clicks

affiliate_networks
  └── offers
  └── network_events
        └── transactions

users
  └── payout_requests
```

---

# Tables

---

# users

Represents registered users of the cashback platform.

| Column | Type | Description |
|------|------|-------------|
| id | bigint | Primary key |
| name | string | User full name |
| email | string | User email |
| password | string | Password hash |
| email_verified_at | timestamp nullable | Email verification timestamp |
| country_code | string nullable | Country of user |
| currency | string | Preferred currency |
| referral_code | string nullable | Referral code |
| status | string | Account status |
| created_at | timestamp | Created timestamp |
| updated_at | timestamp | Updated timestamp |

---

# affiliate_networks

Represents external affiliate networks.

Example: Impact, Admitad, CJ, etc.

| Column | Type | Description |
|------|------|-------------|
| id | bigint | Primary key |
| name | string | Network name |
| slug | string | Unique slug |
| webhook_secret | string nullable | Secret for webhook validation |
| api_base_url | string nullable | Network API base URL |
| status | string | Active / disabled |
| created_at | timestamp | Created timestamp |
| updated_at | timestamp | Updated timestamp |

---

# merchants

Represents partner stores.

Examples:

- Lazada  
- Nike  
- Agoda  

| Column | Type | Description |
|------|------|-------------|
| id | bigint | Primary key |
| affiliate_network_id | bigint nullable | Associated network |
| name | string | Merchant name |
| slug | string | Merchant slug |
| website_url | string | Merchant website |
| logo_url | string nullable | Merchant logo |
| status | string | Active / disabled |
| created_at | timestamp | Created timestamp |
| updated_at | timestamp | Updated timestamp |

---

# offers

Represents cashback offers shown to users.

| Column | Type | Description |
|------|------|-------------|
| id | bigint | Primary key |
| merchant_id | bigint | Merchant reference |
| affiliate_network_id | bigint | Network reference |
| title | string | Offer title |
| description | text nullable | Offer description |
| tracking_url | string | Affiliate tracking URL |
| cashback_type | string | percentage / flat |
| cashback_value | decimal | Cashback value |
| currency | string | Currency |
| status | string | Active / disabled |
| starts_at | timestamp nullable | Offer start |
| ends_at | timestamp nullable | Offer expiry |
| created_at | timestamp | Created timestamp |
| updated_at | timestamp | Updated timestamp |

Example cashback:

```
cashback_type = percentage
cashback_value = 8
```

User receives **8% cashback**.

---

# clicks

Stores every outbound affiliate click.

This is the **core attribution record**.

| Column | Type | Description |
|------|------|-------------|
| id | bigint | Primary key |
| uuid | uuid | Public click identifier |
| user_id | bigint | User who clicked |
| merchant_id | bigint | Merchant reference |
| offer_id | bigint nullable | Offer reference |
| affiliate_network_id | bigint | Network reference |
| click_ref | string | Internal tracking token |
| external_click_ref | string nullable | Network click id |
| destination_url | string | Final merchant URL |
| tracking_url | string | Affiliate redirect URL |
| ip_address | string nullable | IP address |
| user_agent | text nullable | Browser agent |
| referrer_url | string nullable | Page where click occurred |
| device_type | string nullable | Device info |
| metadata | json nullable | Extra click context |
| clicked_at | timestamp | Time of click |
| created_at | timestamp | Created timestamp |
| updated_at | timestamp | Updated timestamp |

Important constraint:

```
unique(click_ref)
```

---

# network_events

Stores **raw webhook or API events from affiliate networks**.

Purpose:

- audit trail
- retry processing
- debugging
- idempotency protection

| Column | Type | Description |
|------|------|-------------|
| id | bigint | Primary key |
| affiliate_network_id | bigint | Network source |
| event_type | string | Conversion / update type |
| external_event_id | string nullable | Network event id |
| external_transaction_id | string nullable | Network transaction id |
| click_ref | string nullable | Click reference |
| payload | json | Raw payload |
| signature_valid | boolean | Webhook validation |
| processing_status | string | pending / processed / failed |
| processing_error | text nullable | Error message |
| received_at | timestamp | Webhook received time |
| processed_at | timestamp nullable | Processing completion |
| created_at | timestamp | Created timestamp |
| updated_at | timestamp | Updated timestamp |

---

# transactions

Represents a **normalized cashback transaction**.

Created or updated from network events.

| Column | Type | Description |
|------|------|-------------|
| id | bigint | Primary key |
| uuid | uuid | Public transaction id |
| user_id | bigint nullable | User reference |
| merchant_id | bigint | Merchant reference |
| offer_id | bigint nullable | Offer reference |
| affiliate_network_id | bigint | Network reference |
| click_id | bigint nullable | Click reference |
| network_event_id | bigint nullable | Source event |
| external_transaction_id | string nullable | Network transaction id |
| external_order_id | string nullable | Merchant order id |
| status | string | pending / confirmed / reversed / paid |
| order_amount | decimal nullable | Customer order amount |
| commission_amount | decimal nullable | Commission received |
| cashback_amount | decimal | Cashback amount |
| currency | string | Currency |
| occurred_at | timestamp nullable | Order time |
| tracked_at | timestamp nullable | First tracked |
| confirmed_at | timestamp nullable | Confirmed time |
| reversed_at | timestamp nullable | Reversal time |
| paid_at | timestamp nullable | Payout time |
| meta | json nullable | Additional data |
| created_at | timestamp | Created timestamp |
| updated_at | timestamp | Updated timestamp |

Unique constraint recommended:

```
unique(affiliate_network_id, external_transaction_id)
```

---

# ledger_entries

Immutable financial records representing **all wallet movements**.

Balances are calculated from ledger entries.

| Column | Type | Description |
|------|------|-------------|
| id | bigint | Primary key |
| user_id | bigint | User reference |
| transaction_id | bigint nullable | Related transaction |
| payout_request_id | bigint nullable | Related payout |
| entry_type | string | Ledger action type |
| bucket | string | pending / available / reserved / paid |
| direction | string | credit / debit |
| amount | decimal | Amount |
| currency | string | Currency |
| description | string nullable | Optional description |
| reference_type | string nullable | Reference model |
| reference_id | bigint nullable | Reference id |
| created_at | timestamp | Created timestamp |
| updated_at | timestamp | Updated timestamp |

Example ledger flow:

| entry_type | bucket | direction | amount |
|------|------|------|------|
| cashback_pending | pending | credit | 100 |
| cashback_confirmed | pending | debit | 100 |
| cashback_confirmed | available | credit | 100 |
| payout_reserved | available | debit | 100 |
| payout_reserved | reserved | credit | 100 |
| payout_completed | reserved | debit | 100 |
| payout_completed | paid | credit | 100 |

---

# payout_requests

Represents user withdrawal requests.

| Column | Type | Description |
|------|------|-------------|
| id | bigint | Primary key |
| user_id | bigint | User reference |
| uuid | uuid | Public payout id |
| status | string | requested / approved / processing / paid / failed |
| amount | decimal | Requested amount |
| currency | string | Currency |
| method | string | Payment method |
| destination_details | json nullable | Payment details |
| requested_at | timestamp | Request time |
| approved_at | timestamp nullable | Approval time |
| processed_at | timestamp nullable | Completion time |
| failed_at | timestamp nullable | Failure time |
| failure_reason | text nullable | Failure explanation |
| notes | text nullable | Admin notes |
| created_at | timestamp | Created timestamp |
| updated_at | timestamp | Updated timestamp |

---

# Core Indexes

### clicks

```
index(user_id)
index(offer_id)
index(merchant_id)
index(clicked_at)
unique(click_ref)
```

---

### network_events

```
index(affiliate_network_id)
index(external_transaction_id)
index(click_ref)
index(processing_status)
index(received_at)
```

---

### transactions

```
index(user_id)
index(click_id)
index(merchant_id)
index(status)
index(external_transaction_id)
unique(affiliate_network_id, external_transaction_id)
```

---

### ledger_entries

```
index(user_id)
index(transaction_id)
index(payout_request_id)
index(bucket)
index(created_at)
```

---

### payout_requests

```
index(user_id)
index(status)
index(requested_at)
```

---

# Core Design Principles

## Raw events must be stored

External payloads should always be stored first:

```
network_events
```

Then normalized into:

```
transactions
```

This improves:

- debugging
- idempotency
- reconciliation

---

## Ledger must be immutable

Never modify wallet balances directly.

Instead record movements in:

```
ledger_entries
```

Balances are derived from ledger history.

---

## Transaction state lifecycle

Typical lifecycle:

```
tracked
pending
confirmed
reversed
paid
```