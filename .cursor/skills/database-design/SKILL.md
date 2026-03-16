---
name: database-design
description: Summarizes the cashback system database schema and principles. Use when designing queries, changing schema, or reasoning about how users, clicks, transactions, ledger entries, and payouts relate.
---

# Database Design and Schema

This skill distills the schema from `docs/database-design.md` so agents can safely reason about data flows.

## Core Tables and Relationships

Primary tables:

- `users`
- `affiliate_networks`
- `merchants`
- `offers`
- `clicks`
- `network_events`
- `transactions`
- `ledger_entries`
- `payout_requests`

High-level relationships:

```text
users → clicks → transactions → ledger_entries
merchants → offers → clicks
affiliate_networks → offers, network_events → transactions
users → payout_requests
```

When changing data flows, validate they align with these relationships.

## Key Tables (Short Reference)

- **users**
  - Identity and profile: name, email, password hash, verification, country, currency, referral code, status.
- **affiliate_networks**
  - External networks (e.g. Impact, Admitad, CJ): name, slug, webhook secret, API base URL, status.
- **merchants**
  - Partner stores: associated `affiliate_network_id`, name, slug, URLs, logo, status.
- **offers**
  - Cashback offers: link `merchant_id` and `affiliate_network_id`, plus title, description, `tracking_url`, `cashback_type` (percentage/flat), `cashback_value`, currency, active window, status.
  - Example: `cashback_type = percentage`, `cashback_value = 8` → 8% cashback.
- **clicks**
  - Outbound affiliate clicks; core attribution:
    - Links `user_id`, `merchant_id`, optional `offer_id`, `affiliate_network_id`.
    - Tracks `click_ref` (internal token), optional `external_click_ref`, destination/tracking URLs, IP, user agent, referrer, device, metadata, timestamps.
    - Constraint: `unique(click_ref)`.
- **network_events**
  - Raw webhook/API events from networks for audit and idempotency:
    - Fields for `affiliate_network_id`, event type, external IDs, `click_ref`, raw JSON payload, signature validity, processing status/error, received/processed timestamps.
- **transactions**
  - Normalized cashback transactions created/updated from `network_events`:
    - Links to `user_id`, `merchant_id`, optional `offer_id`, `affiliate_network_id`, optional `click_id`, optional `network_event_id`.
    - External transaction/order IDs.
    - `status`: `pending`, `confirmed`, `reversed`, `paid`.
    - Financials: `order_amount`, `commission_amount`, `cashback_amount`, `currency`.
    - Lifecycle timestamps: `tracked_at`, `confirmed_at`, `reversed_at`, `paid_at`.
    - Constraint: `unique(affiliate_network_id, external_transaction_id)`.
- **ledger_entries**
  - Immutable wallet movements; balance is derived:
    - Links `user_id`, optional `transaction_id`, optional `payout_request_id`.
    - `entry_type`, `bucket` (pending/available/reserved/paid), `direction` (credit/debit), amount, currency, optional reference fields, timestamps.
    - Example lifecycle for a 100 unit cashback moving from pending to paid:
      - `cashback_pending` pending credit 100
      - `cashback_confirmed` pending debit 100
      - `cashback_confirmed` available credit 100
      - `payout_reserved` available debit 100
      - `payout_reserved` reserved credit 100
      - `payout_completed` reserved debit 100
      - `payout_completed` paid credit 100
- **payout_requests**
  - Withdrawal requests:
    - Links `user_id`, has UUID, `status` (`requested`, `approved`, `processing`, `paid`, `failed`), amount, currency, method, destination details, timestamps for lifecycle, failure reason, notes.

## Indexing and Performance

Important indexes:

- `clicks`: user, offer, merchant, `clicked_at`, `unique(click_ref)`.
- `network_events`: network ID, external transaction ID, `click_ref`, processing status, received time.
- `transactions`: user, click, merchant, status, external transaction ID, unique compound key `(affiliate_network_id, external_transaction_id)`.
- `ledger_entries`: user, transaction, payout request, bucket, created time.
- `payout_requests`: user, status, requested time.

When adding queries or new indexes, align with these access patterns and avoid conflicting uniqueness guarantees.

## Design Principles

Use these principles whenever you modify the schema or write data-manipulating code:

- **Raw event first**: Persist incoming network events in `network_events` before normalizing to `transactions` so you can audit, retry, and handle idempotency correctly.
- **Append-only ledger**: Do not maintain wallet balances via mutable columns; always derive balances from `ledger_entries`.
- **Lifecycle alignment**: Ensure transaction lifecycle (`tracked → pending → confirmed → reversed | paid`) is reflected correctly in both `transactions` and corresponding `ledger_entries`.

## When to Use This Skill

Use this database design skill when:

- Proposing schema changes or new tables.
- Writing queries or migrations touching transactions, ledger, or payouts.
- Debugging data inconsistencies between clicks, transactions, ledger entries, and payouts.
- Explaining how financial data flows through the system.

