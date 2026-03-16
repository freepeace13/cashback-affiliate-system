---
name: creating-queries
description: Use when designing or implementing read-only queries and query handlers in the cashback affiliate system
---

# Creating Queries

## Overview

Create read-only query objects and handlers that shape data for callers without changing domain state.

## Use when
- The request **only reads data** (no side effects)
- The goal is to return **list, detail, or summary** data
- **Pagination, filtering, sorting, or projections** are required
- You are building a **read model** for APIs, dashboards, or background jobs

## Rules
- **Location**: Put query + handler in `{ModuleName}/Queries/{QueryName}/`
- **Naming**: Use pairs like `ListUserTransactionsQuery` / `ListUserTransactionsHandler`
- **Read-only**: Query handlers must not modify state or call write-side actions
- **DTOs only**: Return DTOs or value objects, never domain entities or ORM models
- **Shaping**: Shape output to caller needs; do not leak internal schema
- **Pagination/filtering**: Support pagination, filtering, and sorting when results can grow
- **Ports**: Prefer read-oriented repository or read-model contracts over direct infrastructure
- **Simplicity**: Keep handlers small, explicit, and easy to refactor as read models evolve

## Never
- Write data or change domain state
- Emit domain events or enqueue commands
- Return domain entities or persistence models directly
- Mix write-side behavior or cross-aggregate workflows into query handlers