# Cashback Affiliate System — Architecture

The platform (1) sends users to merchants via affiliate links, (2) tracks clicks, (3) receives conversion/sale events, (4) calculates cashback, (5) records movements in a ledger, and (6) pays out when eligible. It combines affiliate tracking, event ingestion, a financial ledger, and a wallet/payout system.

---

## 1. Core Flow

```
User → Cashback Platform → Affiliate Click Tracking → Affiliate Network / Merchant
  → Conversion / Sale Event → Transaction Processing → Cashback Ledger / Wallet → Payout
```

Concretely:

```
[Frontend App] → [API / Backend]
   ├── Click Tracking
   ├── Offer / Merchant
   ├── Transaction Ingestion
   ├── Cashback Engine
   ├── Ledger / Wallet
   ├── Payout
   ├── Admin / Reconciliation
   └── Notifications
```

---

## 2. Components

### A. Frontend

Browse merchants/offers, “Shop Now” clicks, pending/confirmed cashback, payout requests, transaction history.

### B. API / Backend

Entry point: auth, offers/merchants, trackable clicks, transaction history, wallet balance, payout requests, admin tooling.

### C. Click Tracking

Attribution: on offer click the system creates a unique click ID, stores it, redirects to the network/merchant URL; conversions are matched back to that click.

Stored: `click_id`, `user_id`, `merchant_id`, `offer_id`, `affiliate_network_id`, outbound URL, timestamp, IP/user agent, device/session metadata, optional subid/tracking params.

Feature reference: [`docs/features/offer-click-url-and-tracking-flow.md`](features/offer-click-url-and-tracking-flow.md).

### D. Affiliate Network / Merchant Integration

The platform does not track the final sale; it relies on networks, merchant APIs, postbacks, batch reports, webhooks. This layer normalizes external payloads into an internal conversion event:

```
External payload → Normalizer → Internal conversion event
```

Typical payload fields: order id, click ref/subid, sale amount, commission, status, time, reversal/cancellation.

### E. Transaction Ingestion

Accepts events from webhooks, API polling, CSV imports, manual admin import. For each event: store raw payload (audit), validate signature if required, normalize, detect duplicates, process idempotently, emit domain event. Must handle duplicate retries, partial data, pending→confirmed, reversals, out-of-order events.

### F. Cashback / Rewards Engine

Computes user cashback from commission (e.g. keep $4 of $10, user gets $6) or from offer rules (e.g. 8% on $100 → $8). Supports flat/percentage cashback, promos, category rules, caps, tiers, campaigns.

### G. Transaction State Machine

States: `tracked` → `pending` → `confirmed` → `reversed` or `paid`. Lifecycle: click → conversion → pending cashback → network confirmation → confirmed → user requests payout → paid. Reversals move pending → reversed. Invalid: paying before confirmation, reversing after paid without adjustment, double confirmation. Model as a state machine and enforce transitions.

### H. Ledger / Wallet

Avoid a single mutable balance column. Use a ledger: every movement is an immutable row; balance is derived. Entries: e.g. cashback_pending +100, cashback_confirmed +100, cashback_reversed -100, payout_requested -80. Alternatively use buckets: pending, available, reserved, paid. Enables audit, reconciliation, and correct balances.

### I. Payout

Check eligibility and available balance, create request, reserve funds, send to provider (or manual), mark completed/failed, write ledger, notify user. Methods: bank, PayPal, GCash, manual, gift cards.

### J. Admin / Reconciliation

Review clicks and conversions, inspect raw webhooks, retry failed ingestion, reconcile missing data, handle disputes, reverse transactions, approve payouts, monitor performance, fraud checks.

### K. Notifications

Notify on: tracked, confirmed, reversed, payout requested, payout completed. Channels: email, push, in-app.

---

## 3. High-Level Layout

```
Frontend / Mobile → API → Application Services / Use Cases → Domain
   (Offers, Clicks, Tracking, Transactions, Cashback, Ledger, Payouts, Admin)
   → Infrastructure (DB, Queue, Cache, Webhooks, Network Clients, Notifications, Payout Providers)
```

---

## 4. Domain Breakdown

| Area | Scope |
|------|--------|
| Offers / Merchants | Merchants, stores, offers, cashback rules, affiliate destinations |
| Click Tracking | Click creation, redirects, attribution IDs, session metadata |
| Conversion / Transactions | Incoming events, status transitions, raw storage, duplicate detection |
| Cashback | Reward calculation, eligibility, promos |
| Ledger / Wallet | Movements, balance derivation, reconciliation |
| Payouts | Withdrawal requests, processing, provider integration |
| Admin / Risk | Review, fraud, support, exceptions |

---

## 5. Sync vs Async

**Synchronous:** browse offers, create click, redirect, show wallet/transactions, create payout request.

**Asynchronous (queue/jobs):** webhook handling, normalization, reward calculation after ingestion, reconciliation, emails/notifications, payout execution, retries.

---

## 6. Event-Driven Design

Internal events (e.g. ClickCreated, ConversionReceived, TransactionTracked, TransactionConfirmed, TransactionReversed, CashbackCalculated, LedgerEntryCreated, PayoutRequested, PayoutCompleted) reduce coupling, simplify tests, and support audit and retries.

---

## 7. Code organization (this repository)

- **Modular monolith**: domain code under `src/<Module>/` with a **flat, kind-based** layout (`Actions/`, `Entities/`, `Queries/`, …). There is no `Application/` vs `Domain/` directory split; see [`directory-structure.md`](directory-structure.md).
- **Ports**: caller-facing interfaces live under each module’s `Contracts/` (`Contracts/Actions/`, `Contracts/Queries/`). Shared ports that are not module-specific (for example `EventBus`) live under `src/Contracts/`.
- **Persistence**: some modules split **reads and writes** into separate repository interfaces (Offers: `OfferQueryRepository` / `OfferCommandRepository`; Tracking: `ClickReadRepository` / `ClickWriteRepository`). Adapters can implement one side, both, or a composing interface such as `OfferRepository`.
- **Tests**: `tests/` mirrors usage with in-memory repository doubles and focused unit tests; a full end-to-end integration suite is not wired yet.

---

## 8. Conceptual Diagram

```
                ┌─────────────────┐
                │   Frontend App  │
                └────────┬────────┘
                         │
                         ▼
                ┌─────────────────┐
                │   API Backend   │
                └────────┬────────┘
                         │
     ┌───────────────────┼───────────────────┐
     ▼                   ▼                   ▼
┌─────────────┐   ┌──────────────┐   ┌──────────────┐
│ Click       │   │ Transactions │   │ Payouts      │
│ Tracking    │   │ / Cashback   │   │              │
└──────┬──────┘   └──────┬───────┘   └──────┬───────┘
       │                 │                  │
       ▼                 ▼                  ▼
┌─────────────┐   ┌──────────────┐   ┌──────────────┐
│ Affiliate   │   │ Ledger /     │   │ Notifications│
│ Networks    │   │ Wallet       │   │ / Admin      │
└─────────────┘   └──────────────┘   └──────────────┘
```
