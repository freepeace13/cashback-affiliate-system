# Module Structure (Flat Layout)

## Top-Level

```text
src/
├── Offers/        Offers, merchants, cashback rates
├── Tracking/      Clicks and tracking URLs
├── Transactions/  Conversions, confirmations, reversals
├── Ledger/        Ledger entries, balances, posting
├── Payouts/       Payout requests and lifecycle
└── Shared/        Shared value objects and contracts
```

---

## Per-Module Layout

Modules use a flat layout. Folders appear only when the module needs them:

```text
ModuleName/
├── Actions/       State-changing use cases (optional)
├── Contracts/     Repository and service interfaces
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

---

## Folder Roles

| Folder | Role |
|--------|------|
| **Actions** | State-changing use cases (e.g. CreateClick, ConfirmTransaction, RequestPayout). One class per action; handles transaction boundaries and coordinates domain objects. |
| **Contracts** | Interfaces for repositories and shared services (e.g. OfferRepository, LedgerEntryRepository, LedgerPostingContract). Implementations live in infrastructure. |
| **DTOs** | Data transfer for action input/output and query results; keeps boundaries stable. |
| **Entities** | Identity, state, invariants, and behavior (Offer, Click, Transaction, LedgerEntry, PayoutRequest). |
| **Enums** | Enumeration types (e.g. Direction, OfferStatus, TransactionStatus, PayoutStatus). |
| **Events** | Domain events (ClickCreated, TransactionConfirmed, LedgerEntryPosted, PayoutRequested). |
| **Exceptions** | Domain or application exceptions (TransactionNotFound, TransactionCannotBeReversed). |
| **Factories** | Build entities or complex value objects (e.g. TransactionFactory). |
| **Queries** | Query request object + handler in the same folder (e.g. ListUserTransactionsQuery, ListUserTransactionsHandler). Handlers return DTOs, not entities. |
| **Services** | Logic that spans entities or coordinates flows (LedgerPostingService, PayoutEligibilityService). |
| **ValueObjects** | Immutable values (Money, CashbackRate, LedgerBucket, PayoutMethod, TransactionStatus). |

---

## Example: Shared

```text
Shared/
├── Contracts/       LedgerPostingContract
└── ValueObjects/   Currency, Email, Money
```

---

## Conventions

- **No Application/Domain split**: Types are grouped by kind (Actions, Entities, etc.), not by layer. Keep domain logic in entities, value objects, and services; use actions and query handlers for orchestration.
- **Contracts over Repositories**: Repository interfaces live in `Contracts/`; implementations belong in infrastructure.
- **Queries**: Query class and handler live together in `Queries/` (e.g. `ListUserLedgerEntriesQuery.php`, `ListUserLedgerEntriesHandler.php`).
- **Shared**: Use `Shared/` for types used by more than one module (e.g. Money, Currency, LedgerPostingContract). Module-specific types stay in their module.
