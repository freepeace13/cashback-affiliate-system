# Cashback Affiliate System — Database Schema

## Overview

Core tables: `users`, `affiliate_networks`, `merchants`, `offers`, `clicks`, `network_events`, `transactions`, `ledger_entries`, `payout_requests`.

Relations:

```
users → clicks → transactions → ledger_entries
merchants → offers → clicks
affiliate_networks → offers, network_events → transactions
users → payout_requests
```

---

## Tables

### users

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | PK |
| name | string | Full name |
| email | string | Email |
| password | string | Password hash |
| email_verified_at | timestamp nullable | |
| country_code | string nullable | |
| currency | string | Preferred currency |
| referral_code | string nullable | |
| status | string | Account status |
| created_at, updated_at | timestamp | |

---

### affiliate_networks

External networks (e.g. Impact, Admitad, CJ).

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | PK |
| name | string | |
| slug | string | Unique |
| webhook_secret | string nullable | For webhook validation |
| api_base_url | string nullable | |
| status | string | Active / disabled |
| created_at, updated_at | timestamp | |

---

### merchants

Partner stores.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | PK |
| affiliate_network_id | bigint nullable | |
| name | string | |
| slug | string | |
| website_url | string | |
| logo_url | string nullable | |
| status | string | Active / disabled |
| created_at, updated_at | timestamp | |

---

### offers

Cashback offers shown to users.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | PK |
| merchant_id | bigint | |
| affiliate_network_id | bigint | |
| title | string | |
| description | text nullable | |
| tracking_url | string | Affiliate tracking URL |
| cashback_type | string | percentage / flat |
| cashback_value | decimal | |
| currency | string | |
| status | string | Active / disabled |
| starts_at, ends_at | timestamp nullable | |
| created_at, updated_at | timestamp | |

Example: `cashback_type = percentage`, `cashback_value = 8` → 8% cashback.

---

### clicks

Outbound affiliate clicks; core attribution.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | PK |
| uuid | uuid | Public id |
| user_id | bigint | |
| merchant_id | bigint | |
| offer_id | bigint nullable | |
| affiliate_network_id | bigint | |
| click_ref | string | Internal tracking token |
| external_click_ref | string nullable | Network click id |
| destination_url | string | |
| tracking_url | string | Redirect URL |
| ip_address | string nullable | |
| user_agent | text nullable | |
| referrer_url | string nullable | |
| device_type | string nullable | |
| metadata | json nullable | |
| clicked_at | timestamp | |
| created_at, updated_at | timestamp | |

Constraint: `unique(click_ref)`.

---

### network_events

Raw webhook/API events from networks. Used for audit, retries, idempotency.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | PK |
| affiliate_network_id | bigint | |
| event_type | string | Conversion / update type |
| external_event_id | string nullable | |
| external_transaction_id | string nullable | |
| click_ref | string nullable | |
| payload | json | Raw payload |
| signature_valid | boolean | |
| processing_status | string | pending / processed / failed |
| processing_error | text nullable | |
| received_at | timestamp | |
| processed_at | timestamp nullable | |
| created_at, updated_at | timestamp | |

---

### transactions

Normalized cashback transaction; created/updated from network events.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | PK |
| uuid | uuid | Public id |
| user_id | bigint nullable | |
| merchant_id | bigint | |
| offer_id | bigint nullable | |
| affiliate_network_id | bigint | |
| click_id | bigint nullable | |
| network_event_id | bigint nullable | Source event |
| external_transaction_id | string nullable | |
| external_order_id | string nullable | |
| status | string | pending / confirmed / reversed / paid |
| order_amount | decimal nullable | |
| commission_amount | decimal nullable | |
| cashback_amount | decimal | |
| currency | string | |
| occurred_at | timestamp nullable | |
| tracked_at, confirmed_at, reversed_at, paid_at | timestamp nullable | |
| meta | json nullable | |
| created_at, updated_at | timestamp | |

Constraint: `unique(affiliate_network_id, external_transaction_id)`.

---

### ledger_entries

Immutable wallet movements. Balance = sum of entries.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | PK |
| user_id | bigint | |
| transaction_id | bigint nullable | |
| payout_request_id | bigint nullable | |
| entry_type | string | Ledger action |
| bucket | string | pending / available / reserved / paid |
| direction | string | credit / debit |
| amount | decimal | |
| currency | string | |
| description | string nullable | |
| reference_type, reference_id | string/bigint nullable | |
| created_at, updated_at | timestamp | |

Example flow:

| entry_type | bucket | direction | amount |
|------------|--------|-----------|--------|
| cashback_pending | pending | credit | 100 |
| cashback_confirmed | pending | debit | 100 |
| cashback_confirmed | available | credit | 100 |
| payout_reserved | available | debit | 100 |
| payout_reserved | reserved | credit | 100 |
| payout_completed | reserved | debit | 100 |
| payout_completed | paid | credit | 100 |

---

### payout_requests

Withdrawal requests.

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | PK |
| user_id | bigint | |
| uuid | uuid | Public id |
| status | string | requested / approved / processing / paid / failed |
| amount | decimal | |
| currency | string | |
| method | string | Payment method |
| destination_details | json nullable | |
| requested_at | timestamp | |
| approved_at, processed_at, failed_at | timestamp nullable | |
| failure_reason | text nullable | |
| notes | text nullable | |
| created_at, updated_at | timestamp | |

---

## Indexes

**clicks:** `(user_id)`, `(offer_id)`, `(merchant_id)`, `(clicked_at)`, `unique(click_ref)`  
**network_events:** `(affiliate_network_id)`, `(external_transaction_id)`, `(click_ref)`, `(processing_status)`, `(received_at)`  
**transactions:** `(user_id)`, `(click_id)`, `(merchant_id)`, `(status)`, `(external_transaction_id)`, `unique(affiliate_network_id, external_transaction_id)`  
**ledger_entries:** `(user_id)`, `(transaction_id)`, `(payout_request_id)`, `(bucket)`, `(created_at)`  
**payout_requests:** `(user_id)`, `(status)`, `(requested_at)`

---

## Principles

- **Raw events:** Persist in `network_events` before normalizing into `transactions` (audit, idempotency, reconciliation).
- **Ledger:** Append-only; no in-place balance updates. Balances derived from `ledger_entries`.
- **Transaction lifecycle:** tracked → pending → confirmed → reversed | paid.
