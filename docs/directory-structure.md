# Hexagonal Module Structure (Domain + Application Only)

# Top-Level Structure

```text
src/
├── Offers/
│   ├── Application/
│   └── Domain/
├── Tracking/
│   ├── Application/
│   └── Domain/
├── Transactions/
│   ├── Application/
│   └── Domain/
├── Ledger/
│   ├── Application/
│   └── Domain/
├── Payouts/
│   ├── Application/
│   └── Domain/
└── Shared/
    ├── Application/
    └── Domain/
```

---

# Per-Module Internal Structure

Use this same internal structure for each module.

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

# Folder Responsibilities

## Application Layer

Contains orchestration and use-case execution.
This is where the module coordinates business flows using domain objects.

### `Application/Actions`
Use-case classes for state-changing operations.

Examples:
- `CreateClickAction.php`
- `RecordConversionAction.php`
- `ConfirmTransactionAction.php`
- `RequestPayoutAction.php`

Recommended when:
- operation modifies state
- operation is transactional
- operation coordinates multiple domain objects/repositories

---

### `Application/Queries`
Read-intent request objects.

Examples:
- `GetOfferDetailsQuery.php`
- `GetUserTransactionsQuery.php`
- `GetWalletBalanceQuery.php`

---

### `Application/QueryHandlers`
Handlers for queries.

Examples:
- `GetOfferDetailsHandler.php`
- `GetUserTransactionsHandler.php`

These should return DTOs/read models, not domain entities directly.

---

### `Application/DTOs`
Application data transfer objects.

Examples:
- `ClickData.php`
- `TransactionData.php`
- `PayoutRequestData.php`
- `WalletBalanceData.php`

Useful for:
- action input/output
- query results
- stable boundaries between layers

---

### `Application/UseCases`
Optional alternative to `Actions/`.

If you prefer the term `UseCases` instead of `Actions`, you can use one or the other, not both.

Examples:
- `CreateClick.php`
- `CalculateCashback.php`
- `SubmitPayoutRequest.php`

---

### `Application/Services`
Application-level coordinators that do not belong in domain services.

Examples:
- `CashbackCalculationCoordinator.php`
- `TransactionLifecycleManager.php`
- `PayoutApprovalWorkflow.php`

These orchestrate flows, but should not hold core business rules that belong in domain.

---

### `Application/Mappers`
Maps between:
- domain entities
- DTOs
- read models

Examples:
- `TransactionDataMapper.php`
- `OfferViewMapper.php`

---

### `Application/Exceptions`
Exceptions related to application flow.

Examples:
- `CannotRequestPayout.php`
- `InvalidTransactionTransition.php`

---

# Domain Layer

Contains core business rules and concepts.
This layer should be framework-light and business-centered.

### `Domain/Entities`
Core business entities with identity.

Examples:
- `Offer.php`
- `Click.php`
- `Transaction.php`
- `LedgerEntry.php`
- `PayoutRequest.php`

Entities contain:
- state
- invariants
- behavior

---

### `Domain/ValueObjects`
Immutable value types.

Examples:
- `Money.php`
- `CashbackRate.php`
- `ClickReference.php`
- `TransactionStatus.php`
- `PayoutMethod.php`

These help keep logic expressive and safe.

---

### `Domain/Aggregates`
Aggregate roots or aggregate grouping if you want them explicit.

Examples:
- `TransactionAggregate.php`
- `WalletAggregate.php`
- `PayoutAggregate.php`

You may skip this folder if your entities already act as aggregate roots clearly.

---

### `Domain/Events`
Domain events representing business-significant occurrences.

Examples:
- `ClickCreated.php`
- `TransactionTracked.php`
- `TransactionConfirmed.php`
- `TransactionReversed.php`
- `PayoutRequested.php`

These describe what happened in domain language.

---

### `Domain/Services`
Pure domain services for business rules that do not naturally belong to a single entity.

Examples:
- `CashbackCalculator.php`
- `TransactionTransitionGuard.php`
- `LedgerPostingService.php`

Use this when logic spans multiple entities/value objects but is still domain logic.

---

### `Domain/Repositories`
Repository contracts/interfaces only.

Examples:
- `OfferRepository.php`
- `ClickRepository.php`
- `TransactionRepository.php`
- `LedgerEntryRepository.php`
- `PayoutRequestRepository.php`

Keep implementations outside this layer.

---

### `Domain/Specifications`
Business rule specifications.

Examples:
- `PayoutEligibilitySpecification.php`
- `TransactionConfirmableSpecification.php`
- `OfferActiveSpecification.php`

Useful for reusable rule checks.

---

### `Domain/Exceptions`
Core business exceptions.

Examples:
- `InactiveOffer.php`
- `TransactionAlreadyConfirmed.php`
- `InsufficientAvailableBalance.php`

---

### `Domain/Enums`
Domain enums.

Examples:
- `OfferStatus.php`
- `TransactionStatus.php`
- `LedgerBucket.php`
- `LedgerDirection.php`
- `PayoutStatus.php`

---

# Example Structure Per Module

## Offers

```text
Offers/
├── Application/
│   ├── Queries/
│   │   ├── GetOfferDetailsQuery.php
│   │   └── ListActiveOffersQuery.php
│   ├── QueryHandlers/
│   │   ├── GetOfferDetailsHandler.php
│   │   └── ListActiveOffersHandler.php
│   ├── DTOs/
│   │   └── OfferData.php
│   └── Exceptions/
└── Domain/
    ├── Entities/
    │   ├── Offer.php
    │   └── Merchant.php
    ├── ValueObjects/
    │   ├── CashbackRate.php
    │   └── OfferStatus.php
    ├── Repositories/
    │   ├── OfferRepository.php
    │   └── MerchantRepository.php
    ├── Specifications/
    │   └── OfferActiveSpecification.php
    └── Exceptions/
```

---

## Tracking

```text
Tracking/
├── Application/
│   ├── Actions/
│   │   └── CreateClickAction.php
│   ├── DTOs/
│   │   ├── CreateClickData.php
│   │   └── ClickData.php
│   └── Exceptions/
└── Domain/
    ├── Entities/
    │   └── Click.php
    ├── ValueObjects/
    │   ├── ClickReference.php
    │   ├── DestinationUrl.php
    │   └── TrackingUrl.php
    ├── Events/
    │   └── ClickCreated.php
    ├── Repositories/
    │   └── ClickRepository.php
    └── Exceptions/
```

---

## Transactions

```text
Transactions/
├── Application/
│   ├── Actions/
│   │   ├── RecordConversionAction.php
│   │   ├── ConfirmTransactionAction.php
│   │   └── ReverseTransactionAction.php
│   ├── Commands/
│   │   ├── RecordConversionCommand.php
│   │   ├── ConfirmTransactionCommand.php
│   │   └── ReverseTransactionCommand.php
│   ├── CommandHandlers/
│   │   ├── RecordConversionHandler.php
│   │   ├── ConfirmTransactionHandler.php
│   │   └── ReverseTransactionHandler.php
│   ├── Queries/
│   │   └── GetUserTransactionsQuery.php
│   ├── QueryHandlers/
│   │   └── GetUserTransactionsHandler.php
│   ├── DTOs/
│   │   └── TransactionData.php
│   └── Exceptions/
└── Domain/
    ├── Entities/
    │   └── Transaction.php
    ├── ValueObjects/
    │   ├── TransactionStatus.php
    │   ├── ExternalTransactionId.php
    │   └── OrderAmount.php
    ├── Events/
    │   ├── TransactionTracked.php
    │   ├── TransactionConfirmed.php
    │   └── TransactionReversed.php
    ├── Services/
    │   ├── CashbackCalculator.php
    │   └── TransactionTransitionGuard.php
    ├── Repositories/
    │   └── TransactionRepository.php
    ├── Specifications/
    │   ├── TransactionConfirmableSpecification.php
    │   └── TransactionReversibleSpecification.php
    └── Exceptions/
```

---

## Ledger

```text
Ledger/
├── Application/
│   ├── Actions/
│   │   ├── PostPendingCashbackAction.php
│   │   ├── MovePendingToAvailableAction.php
│   │   └── ReservePayoutFundsAction.php
│   ├── Queries/
│   │   ├── GetWalletBalanceQuery.php
│   │   └── GetLedgerEntriesQuery.php
│   ├── QueryHandlers/
│   │   ├── GetWalletBalanceHandler.php
│   │   └── GetLedgerEntriesHandler.php
│   ├── DTOs/
│   │   ├── WalletBalanceData.php
│   │   └── LedgerEntryData.php
│   └── Exceptions/
└── Domain/
    ├── Entities/
    │   └── LedgerEntry.php
    ├── ValueObjects/
    │   ├── Money.php
    │   ├── LedgerBucket.php
    │   └── LedgerDirection.php
    ├── Events/
    │   └── LedgerEntryPosted.php
    ├── Services/
    │   └── LedgerPostingService.php
    ├── Repositories/
    │   └── LedgerEntryRepository.php
    ├── Specifications/
    │   └── SufficientAvailableBalanceSpecification.php
    └── Exceptions/
```

---

## Payouts

```text
Payouts/
├── Application/
│   ├── Actions/
│   │   ├── RequestPayoutAction.php
│   │   ├── ApprovePayoutAction.php
│   │   ├── MarkPayoutProcessingAction.php
│   │   ├── CompletePayoutAction.php
│   │   └── FailPayoutAction.php
│   ├── Commands/
│   │   ├── RequestPayoutCommand.php
│   │   └── ApprovePayoutCommand.php
│   ├── CommandHandlers/
│   │   ├── RequestPayoutHandler.php
│   │   └── ApprovePayoutHandler.php
│   ├── Queries/
│   │   └── GetUserPayoutRequestsQuery.php
│   ├── QueryHandlers/
│   │   └── GetUserPayoutRequestsHandler.php
│   ├── DTOs/
│   │   └── PayoutRequestData.php
│   └── Exceptions/
└── Domain/
    ├── Entities/
    │   └── PayoutRequest.php
    ├── ValueObjects/
    │   ├── PayoutMethod.php
    │   ├── PayoutStatus.php
    │   └── PayoutDestination.php
    ├── Events/
    │   ├── PayoutRequested.php
    │   ├── PayoutApproved.php
    │   ├── PayoutCompleted.php
    │   └── PayoutFailed.php
    ├── Services/
    │   └── PayoutEligibilityService.php
    ├── Repositories/
    │   └── PayoutRequestRepository.php
    ├── Specifications/
    │   └── PayoutEligibleSpecification.php
    └── Exceptions/
```

---

## Shared

```text
Shared/
├── Application/
│   ├── DTOs/
│   └── Exceptions/
└── Domain/
    ├── ValueObjects/
    │   ├── Money.php
    │   ├── Currency.php
    │   ├── Uuid.php
    │   └── Email.php
    ├── Events/
    ├── Exceptions/
    ├── Enums/
    └── Services/
```

---

# Recommended Simplified Version

If you want less folder noise, this is a more practical version:

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
    └── Exceptions/
```

This is usually enough for most projects.

---

# My Recommendation

For your cashback system, I’d start with this balance:

```text
src/
├── Offers/
├── Tracking/
├── Transactions/
├── Ledger/
├── Payouts/
└── Shared/
```

And inside each module, use:

```text
Application/
  Actions/
  Queries/
  QueryHandlers/
  DTOs/
  Exceptions/

Domain/
  Entities/
  ValueObjects/
  Events/
  Services/
  Repositories/
  Specifications/
  Exceptions/
  Enums/
```