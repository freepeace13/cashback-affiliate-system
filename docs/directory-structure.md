# Hexagonal Module Structure (Domain + Application)

## Top-Level

```text
src/
├── Offers/       Application/ + Domain/
├── Tracking/     Application/ + Domain/
├── Transactions/ Application/ + Domain/
├── Ledger/       Application/ + Domain/
├── Payouts/      Application/ + Domain/
└── Shared/       Application/ + Domain/
```

---

## Per-Module Layout

Same layout under each module:

```text
ModuleName/
├── Application/
│   ├── Actions/
│   ├── Queries/
│   ├── QueryHandlers/
│   ├── DTOs/
│   └── Exceptions/
└── Domain/
    ├── Entities/
    ├── ValueObjects/
    ├── Events/
    ├── Services/
    ├── Repositories/
    ├── Specifications/
    ├── Exceptions/
    └── Enums/
```

---

## Application Layer

Orchestration and use cases; coordinates flows using domain objects.

| Folder | Role |
|--------|------|
| **Actions** | State-changing use cases (e.g. CreateClick, RecordConversion, ConfirmTransaction, RequestPayout). Use when the operation is transactional or touches multiple domain objects. |
| **Queries** | Read request objects (GetOfferDetails, GetUserTransactions, GetWalletBalance). |
| **QueryHandlers** | Execute queries; return DTOs/read models, not entities. |
| **DTOs** | Data transfer for action I/O and query results; keep layer boundaries stable. |
| **Exceptions** | Application-flow exceptions (CannotRequestPayout, InvalidTransactionTransition). |

Optional names: **UseCases** instead of Actions (pick one). **Services** for app-level coordinators (e.g. CashbackCalculationCoordinator); keep core rules in domain. **Mappers** for entity ↔ DTO ↔ read model.

---

## Domain Layer

Business rules and concepts; framework-agnostic.

| Folder | Role |
|--------|------|
| **Entities** | Identity + state + invariants + behavior (Offer, Click, Transaction, LedgerEntry, PayoutRequest). |
| **ValueObjects** | Immutable values (Money, CashbackRate, ClickReference, TransactionStatus, PayoutMethod). |
| **Events** | Domain events (ClickCreated, TransactionTracked, TransactionConfirmed, TransactionReversed, PayoutRequested). |
| **Services** | Rules that span entities (CashbackCalculator, TransactionTransitionGuard, LedgerPostingService). |
| **Repositories** | Interfaces only; implementations live in infrastructure. |
| **Specifications** | Reusable rule checks (PayoutEligibilitySpecification, TransactionConfirmableSpecification, OfferActiveSpecification). |
| **Exceptions** | Domain exceptions (InactiveOffer, TransactionAlreadyConfirmed, InsufficientAvailableBalance). |
| **Enums** | OfferStatus, TransactionStatus, LedgerBucket, LedgerDirection, PayoutStatus. |

**Aggregates**: optional folder if you want explicit aggregate roots (TransactionAggregate, WalletAggregate); omit if entities already act as roots.

---

## Example: Offers

```text
Offers/
├── Application/
│   ├── Queries/           GetOfferDetailsQuery, ListActiveOffersQuery
│   ├── QueryHandlers/     GetOfferDetailsHandler, ListActiveOffersHandler
│   ├── DTOs/              OfferData
│   └── Exceptions/
└── Domain/
    ├── Entities/          Offer, Merchant
    ├── ValueObjects/      CashbackRate, OfferStatus
    ├── Repositories/      OfferRepository, MerchantRepository
    ├── Specifications/    OfferActiveSpecification
    └── Exceptions/
```

---

## Example: Tracking

```text
Tracking/
├── Application/
│   ├── Actions/            CreateClickAction
│   ├── DTOs/               CreateClickData, ClickData
│   └── Exceptions/
└── Domain/
    ├── Entities/           Click
    ├── ValueObjects/       ClickReference, DestinationUrl, TrackingUrl
    ├── Events/             ClickCreated
    ├── Repositories/       ClickRepository
    └── Exceptions/
```

---

## Example: Transactions

```text
Transactions/
├── Application/
│   ├── Actions/            RecordConversion, ConfirmTransaction, ReverseTransaction
│   ├── Commands/           RecordConversionCommand, ConfirmTransactionCommand, ReverseTransactionCommand
│   ├── CommandHandlers/    RecordConversionHandler, ConfirmTransactionHandler, ReverseTransactionHandler
│   ├── Queries/            GetUserTransactionsQuery
│   ├── QueryHandlers/      GetUserTransactionsHandler
│   ├── DTOs/               TransactionData
│   └── Exceptions/
└── Domain/
    ├── Entities/           Transaction
    ├── ValueObjects/       TransactionStatus, ExternalTransactionId, OrderAmount
    ├── Events/             TransactionTracked, TransactionConfirmed, TransactionReversed
    ├── Services/           CashbackCalculator, TransactionTransitionGuard
    ├── Repositories/       TransactionRepository
    ├── Specifications/     TransactionConfirmableSpecification, TransactionReversibleSpecification
    └── Exceptions/
```

---

## Example: Ledger

```text
Ledger/
├── Application/
│   ├── Actions/            PostPendingCashback, MovePendingToAvailable, ReservePayoutFunds
│   ├── Queries/            GetWalletBalanceQuery, GetLedgerEntriesQuery
│   ├── QueryHandlers/      GetWalletBalanceHandler, GetLedgerEntriesHandler
│   ├── DTOs/               WalletBalanceData, LedgerEntryData
│   └── Exceptions/
└── Domain/
    ├── Entities/           LedgerEntry
    ├── ValueObjects/       Money, LedgerBucket, LedgerDirection
    ├── Events/             LedgerEntryPosted
    ├── Services/           LedgerPostingService
    ├── Repositories/       LedgerEntryRepository
    ├── Specifications/     SufficientAvailableBalanceSpecification
    └── Exceptions/
```

---

## Example: Payouts

```text
Payouts/
├── Application/
│   ├── Actions/            RequestPayout, ApprovePayout, MarkPayoutProcessing, CompletePayout, FailPayout
│   ├── Commands/           RequestPayoutCommand, ApprovePayoutCommand
│   ├── CommandHandlers/    RequestPayoutHandler, ApprovePayoutHandler
│   ├── Queries/            GetUserPayoutRequestsQuery
│   ├── QueryHandlers/      GetUserPayoutRequestsHandler
│   ├── DTOs/               PayoutRequestData
│   └── Exceptions/
└── Domain/
    ├── Entities/           PayoutRequest
    ├── ValueObjects/       PayoutMethod, PayoutStatus, PayoutDestination
    ├── Events/             PayoutRequested, PayoutApproved, PayoutCompleted, PayoutFailed
    ├── Services/           PayoutEligibilityService
    ├── Repositories/       PayoutRequestRepository
    ├── Specifications/    PayoutEligibleSpecification
    └── Exceptions/
```

---

## Example: Shared

```text
Shared/
├── Application/   DTOs, Exceptions
└── Domain/
    ├── ValueObjects/   Money, Currency, Uuid, Email
    ├── Events/
    ├── Exceptions/
    ├── Enums/
    └── Services/
```

---

## Minimal Layout

If you want fewer folders per module:

```text
ModuleName/
├── Application/   Actions, Queries, QueryHandlers, DTOs, Exceptions
└── Domain/        Entities, ValueObjects, Events, Services, Repositories, Exceptions
```

Specifications and Enums can live under Domain when needed.
