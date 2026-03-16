---
name: module-structure
description: Describes the module and folder layout for the cashback system. Use when adding or relocating files, creating new modules, or reasoning about where application and domain code should live.
---

# Module and Directory Structure

This skill distills the conventions from `docs/directory-structure.md` so agents can place code consistently.

## Top-Level Modules

All core business logic lives under `src/` in module folders:

```text
src/
├── Offers/        Offers, merchants, cashback rates
├── Tracking/      Clicks and tracking URLs
├── Transactions/  Conversions, confirmations, reversals
├── Ledger/        Ledger entries, balances, posting
├── Payouts/       Payout requests and lifecycle
└── Shared/        Shared value objects and contracts
```

When adding new behavior, prefer extending one of these modules rather than creating ad-hoc folders.

## Per-Module Layout

Each module uses a flat, kind-based layout. Folders only exist when needed:

```text
ModuleName/
├── Actions/       State-changing use cases (optional)
├── Repositories/  Repository interfaces (and related persistence contracts)
├── DTOs/          Data transfer objects
├── Entities/      Domain entities
├── Enums/         Enumerations (optional)
├── Events/        Domain events (optional)
├── Exceptions/    Module-specific exceptions (optional)
├── Factories/     Entity/builders (optional)
├── Queries/       Query objects and handlers
├── Services/      Domain or application services (optional)
└── ValueObjects/  Immutable value types
```

## Folder Roles and Usage

Use these guidelines when deciding where a new type belongs:

- **Actions**: State-changing use cases like `CreateClick`, `ConfirmTransaction`, or `RequestPayout`.
  - Orchestrate domain entities and services.
  - Define transaction boundaries.
- **Repositories**: Repository interfaces and persistence-related contracts, such as `OfferRepository`, `LedgerEntryRepository`, or `LedgerPostingContract`.
  - Implementations live in infrastructure layers, not in the module itself.
- **DTOs**: Structures for action input/output and query results.
  - Keep them stable across API changes; do not put domain logic here.
- **Entities**: Domain entities with identity, state, invariants, and behavior (e.g. `Offer`, `Click`, `Transaction`, `LedgerEntry`, `PayoutRequest`).
- **Enums**: Enumeration types like `Direction`, `OfferStatus`, `TransactionStatus`, or `PayoutStatus`.
- **Events**: Domain events representing significant state changes (e.g. `ClickCreated`, `TransactionConfirmed`, `LedgerEntryPosted`, `PayoutRequested`).
- **Exceptions**: Module-specific exceptions such as `TransactionNotFound` or `TransactionCannotBeReversed`.
- **Factories**: Builders for complex entities or aggregates (e.g. `TransactionFactory`).
- **Queries**: Query request objects and handlers, colocated in the same folder (e.g. `ListUserTransactionsQuery`, `ListUserTransactionsHandler`).
  - Handlers return DTOs, not entities.
- **Services**: Domain or application services that orchestrate across entities (e.g. `LedgerPostingService`, `PayoutEligibilityService`).
- **ValueObjects**: Immutable types like `Money`, `CashbackRate`, `LedgerBucket`, `PayoutMethod`, `TransactionStatus`.

## Conventions and Principles

- **No Application/Domain split in folders**: Types are grouped by kind (Actions, Entities, etc.), not by layer.
  - Keep true domain logic in entities, value objects, and services.
  - Use actions and query handlers for orchestration and IO boundaries.
- **Repositories for interfaces**: Define repository interfaces and persistence contracts under `Repositories/` and implement them elsewhere.
- **Shared module**:
  - Use `Shared/` only for cross-module types (e.g. `Money`, `Currency`, `LedgerPostingContract`).
  - Keep module-specific types inside their respective module.

## When to Use This Skill

Use this module structure skill when:

- Deciding where to place a new file or class.
- Refactoring code into the existing module layout.
- Introducing a new module that should follow the same conventions.
- Reviewing PRs for correct file and module placement.

