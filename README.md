# Cashback Affiliate System

A backend architecture demo for building a **cashback affiliate platform** similar to Rakuten or TopCashback.

This project explores how real-world affiliate cashback systems work internally, including:

- Affiliate click tracking
- Webhook / conversion ingestion
- Transaction lifecycle management
- Cashback calculation
- Ledger-based wallet accounting
- Payout processing

The goal is to **document the engineering behind the system step-by-step**.

---

## Architecture

The project follows a **Hexagonal Architecture (Ports & Adapters)** with a **modular monolith** structure.

```
src/
├── Offers/        merchants, offers, availability, cashback rules on offers
├── Tracking/      clicks and attribution
├── Transactions/  conversions and lifecycle (in progress)
├── Ledger/        ledger entries and balances (in progress)
├── Payouts/       payout requests (in progress)
├── Shared/        cross-module value objects and contracts
└── Contracts/     shared ports (e.g. event bus)
```

Within each module, code is grouped **by kind** (`Actions/`, `Entities/`, `Queries/`, `Repositories/`, …), not by a separate Application/Domain folder tree. See [`docs/directory-structure.md`](docs/directory-structure.md) for the full layout.

Ports live under `Contracts/` (per module) or `src/Contracts/` when shared. Infrastructure adapters are expected to sit outside `src/` when you wire a real app.

---

## Core Ideas

**Click Attribution**

```
User → Click → Merchant → Conversion → Transaction
```

**Transaction Lifecycle**

```
tracked → pending → confirmed → reversed → paid
```

**Ledger-Based Wallet**

Balances are derived from immutable ledger entries rather than mutable wallet fields.

---

## Documentation

- [`docs/architecture.md`](docs/architecture.md) — end-to-end flows and components
- [`docs/directory-structure.md`](docs/directory-structure.md) — module layout and naming
- [`docs/database-design.md`](docs/database-design.md) — conceptual schema

Run tests: `composer test` or `./vendor/bin/phpunit`.

---

## Purpose

This repository is meant to demonstrate:

- real-world backend system design
- domain modeling for financial workflows
- scalable affiliate tracking architecture
- ledger-based accounting patterns

---

## License

MIT