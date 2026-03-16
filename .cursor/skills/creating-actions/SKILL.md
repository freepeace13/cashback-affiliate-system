---
name: creating-actions
description: Use when designing or implementing state-changing actions in the cashback affiliate system
---

# Creating Actions

## Overview

Create state-changing use cases (Actions) that orchestrate domain services, entities, and repositories for this cashback affiliate system.

## Use when
- The request **changes domain state** (transactions, offers, ledger, payouts, tracking)
- The flow **writes to repositories** or emits domain events
- The operation **coordinates multiple entities/services** or transaction boundaries
- **Idempotency, consistency, or invariants** need to be enforced

## Rules
- **Location**: Put classes in `{ModuleName}/Actions/`
- **Shape**: One class per use case, implementing the appropriate action contract
- **Naming**: Use verb-first names like `ConfirmTransaction`, `RequestPayout`, `ReverseTransaction`
- **Responsibility**: Actions orchestrate; business rules live in entities, value objects, or domain services
- **Boundaries**: Prefer DTO input/output for stable module boundaries
- **Ports**: Depend on repository interfaces and shared contracts, never infrastructure implementations
- **State machines**: Respect transaction and payout state machines; never skip states
- **Ledger**: Use append-only ledger entries; never mutate balances directly
- **Idempotency**: Design idempotent behavior for retry-prone flows (webhooks, queues, external callbacks)
- **Events**: Emit domain events only after successful state changes commit

## Never
- Put **read-only** flows in Actions (use Queries instead)
- Return ORM/persistence models to callers
- Bypass domain invariant checks or construct entities in an invalid state
- Hide infrastructure details inside the action instead of behind ports/contracts