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
Modules
├── Offers
├── Tracking
├── Transactions
├── Ledger
├── Payouts
└── Shared
```

Each module contains:

```
Application/
Domain/
```

This keeps business logic isolated from infrastructure and makes the system easier to evolve.

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

## Purpose

This repository is meant to demonstrate:

- real-world backend system design
- domain modeling for financial workflows
- scalable affiliate tracking architecture
- ledger-based accounting patterns

---

## License

MIT