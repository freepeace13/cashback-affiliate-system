# Module Structure (Flat Layout)

## Top-Level

```text
src/
├── Offers/        Merchants, offers, schedules, cashback rule fields on offers
├── Tracking/      Clicks, attribution, read/write persistence ports
├── Transactions/  Conversions, confirmations, reversals
├── Ledger/        Ledger entries, balances, posting
├── Payouts/       Payout requests and lifecycle
├── Shared/        Shared value objects and cross-module interfaces
└── Contracts/     Shared ports used across modules (e.g. EventBus)
```

---

## Per-Module Layout

Modules use a flat layout. Folders appear only when the module needs them:

```text
ModuleName/
├── Actions/       State-changing use cases (optional)
├── Contracts/     Ports: `Contracts/Actions/` and `Contracts/Queries/` handler interfaces (optional)
├── Repositories/  Repository interfaces (and related persistence contracts)
├── DTOs/          Data transfer objects; use `DTOs/Actions/` and `DTOs/Queries/` for inputs (e.g. Offers)
├── Entities/      Domain entities
├── Enums/         Enumerations (optional)
├── Events/        Domain events (optional)
├── Exceptions/    Module-specific exceptions (optional)
├── Factories/     Entity/builders (optional)
├── Mappers/       Entity ↔ DTO mapping for actions and query handlers (optional)
├── Queries/       Query objects and handlers
├── Services/      Domain or application services (optional)
└── ValueObjects/  Immutable value types
```

---

## Folder Roles


| Folder           | Role                                                                                                                                                                  |
| ---------------- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Actions**      | State-changing use cases (e.g. CreateClick, ConfirmTransaction, RequestPayout). One class per action; handles transaction boundaries and coordinates domain objects.  |
| **Contracts**    | Caller-facing ports: action interfaces under `Contracts/Actions/`, read ports under `Contracts/Queries/` (one interface per query handler). Concrete handlers implement these. |
| **Repositories** | Persistence ports. Offers: `OfferQueryRepository` + `OfferCommandRepository`; full adapters may implement `OfferRepository` (extends both). Tracking: `ClickReadRepository` + `ClickWriteRepository`. Other examples: `LedgerEntryRepository`, `LedgerPostingContract`. Implementations live in infrastructure. |
| **DTOs**         | Data transfer for action input/output and query results; keeps boundaries stable.                                                                                     |
| **Entities**     | Identity, state, invariants, and behavior (Offer, Click, Transaction, LedgerEntry, PayoutRequest).                                                                    |
| **Enums**        | Enumeration types (e.g. Direction, OfferStatus, TransactionStatus, PayoutStatus).                                                                                     |
| **Events**       | Domain events (ClickCreated, TransactionConfirmed, LedgerEntryPosted, PayoutRequested).                                                                               |
| **Exceptions**   | Domain or application exceptions (TransactionNotFound, TransactionCannotBeReversed).                                                                                  |
| **Factories**    | Build entities or complex value objects (e.g. TransactionFactory).                                                                                                    |
| **Mappers**      | Map domain entities to/from DTOs so actions and query handlers stay thin (e.g. `OfferEntityMapper`, `TransactionEntityMapper`).                                        |
| **Queries**      | Query handlers (read orchestration), flat under `Queries/`. Request objects live in `DTOs/Queries/`. Handlers return DTOs, not entities. |
| **Services**     | Logic that spans entities or coordinates flows (LedgerPostingService, PayoutEligibilityService).                                                                      |
| **ValueObjects** | Immutable values (e.g. `Money`, `LedgerBucket`, `PayoutMethod`). Offer cashback is modeled as primitive fields on `Offer` aligned with the `offers` table (`cashback_type`, `cashback_value`, `currency`). |


---

## Example: Shared

```text
Shared/
├── Repositories/    LedgerPostingContract
└── ValueObjects/    Currency, Email, Money
```

---

## Example: Tracking

```text
Tracking/
├── Actions/
├── Contracts/
│   ├── Actions/
│   └── Queries/
├── DTOs/
│   ├── Actions/
│   └── Queries/
├── Entities/
├── Events/
├── Mappers/
├── Queries/
└── Repositories/    ClickReadRepository, ClickWriteRepository
```

---

## Example: Offers (query/command split)

```text
Offers/
├── Actions/
├── Contracts/
│   ├── Actions/
│   └── Queries/
├── Repositories/    OfferQueryRepository, OfferCommandRepository, OfferRepository (both)
├── Services/        e.g. OfferListProjector, schedule validation helpers
└── ...
```

---

## Conventions

- **No Application/Domain split**: Types are grouped by kind (Actions, Entities, etc.), not by layer. Keep domain logic in entities, value objects, and services; use actions and query handlers for orchestration.
- **Repositories for interfaces**: Repository interfaces and persistence contracts live in `Repositories/`; concrete implementations belong in infrastructure.
- **Queries**: Put `*Query.php` under `DTOs/Queries/` and `*Handler.php` flat under `Queries/` (e.g. `DTOs/Queries/ListUserLedgerEntriesQuery.php`, `Queries/ListUserLedgerEntriesHandler.php`).
- **Shared**: Use `Shared/` for types used by more than one module (e.g. Money, Currency, LedgerPostingContract). Module-specific types stay in their module.

