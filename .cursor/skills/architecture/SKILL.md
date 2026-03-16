---
name: architecture
description: Guides agents on the overall cashback affiliate system architecture, flows, and components. Use when reasoning about end-to-end behavior, designing new features, or explaining how clicks, conversions, cashback, ledger, and payouts fit together.
---

# Cashback Affiliate System Architecture

This skill summarizes the core architectural ideas from `docs/architecture.md` so agents can quickly reason about end-to-end flows.

## Core User and Data Flow

High-level path:

- User clicks an offer on the cashback platform.
- The platform redirects via an affiliate tracking link to the merchant or affiliate network.
- An external conversion/sale event comes back via webhook, API, or batch.
- The system ingests and normalizes the event into an internal transaction.
- Cashback is calculated.
- Ledger entries are written to represent wallet movements.
- Payouts are created and processed when eligible.

Conceptually:

```text
User → Cashback Platform → Affiliate Click Tracking → Affiliate Network / Merchant
  → Conversion / Sale Event → Transaction Processing → Cashback Ledger / Wallet → Payout
```

When designing features, always consider which part of this flow is affected and how events should propagate through it.

## Main Backend Components

Use this breakdown when deciding where new logic belongs:

- **Frontend**: Browses merchants/offers, triggers “Shop Now” clicks, shows pending/confirmed cashback, payout requests, and history.
- **API / Backend**: Entry point for auth, offers/merchants, trackable clicks, transaction history, wallet balance, payout requests, and admin tools.
- **Click Tracking**: Creates unique click IDs on offer clicks, stores attribution data (user, merchant, offer, network, metadata), and redirects to outbound URLs.
- **Affiliate Network / Merchant Integrations**: Receive raw payloads from networks/merchants and normalize them into internal conversion events.
- **Transaction Ingestion**: Accepts webhooks, API polling responses, CSV/manual imports; validates, normalizes, deduplicates, and processes events idempotently.
- **Cashback / Rewards Engine**: Computes user cashback from commissions or explicit offer rules (percentage/flat, promos, caps, tiers).
- **Transaction State Machine**: Enforces valid transitions like `tracked → pending → confirmed → reversed | paid` and prevents illegal states.
- **Ledger / Wallet**: Immutable ledger entries from which balances are derived; avoid a single mutable balance column.
- **Payout**: Handles eligibility, reserving funds, sending to providers, marking success/failure, and notifying users.
- **Admin / Reconciliation & Notifications**: Surfaces raw events, retries, reconciles mismatches, and notifies users on lifecycle changes.

## Sync vs Async Responsibilities

When implementing or refactoring flows:

- **Synchronous responsibilities** (user-facing): browsing offers, creating clicks/redirects, showing wallet and transactions, creating payout requests.
- **Asynchronous responsibilities** (background jobs/queues): webhook handling, normalization, cashback computation, reconciliation, notifications, payout execution, and retries.

Favor asynchronous processing for anything driven by external events, retries, or potentially slow network calls.

## Event-Driven Design

The system benefits from internal domain events such as:

- `ClickCreated`
- `ConversionReceived`
- `TransactionTracked`
- `TransactionConfirmed`
- `TransactionReversed`
- `CashbackCalculated`
- `LedgerEntryCreated`
- `PayoutRequested`
- `PayoutCompleted`

When introducing new behavior, prefer emitting and handling domain events instead of tightly coupling modules. This helps with:

- Reduced coupling between components.
- Easier testing (events can be replayed).
- Better auditability and replayability.

## When to Use This Skill

Use this architecture skill when:

- Explaining how a new feature fits into the end-to-end cashback flow.
- Deciding where a new capability should live (click tracking vs transactions vs ledger vs payouts).
- Evaluating the impact of changes on transaction lifecycle, ledger, or payouts.
- Designing event flows or deciding what should be synchronous vs asynchronous.

