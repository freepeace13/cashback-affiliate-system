## Project Overview

- **Name**: Cashback Affiliate System
- **Purpose**: Backend architecture demo for a Rakuten/TopCashback-style cashback platform, focusing on affiliate tracking, transaction lifecycle, ledger-based wallets, and payouts.
- **Architecture**: Modular monolith with hexagonal (ports & adapters) style; modules for Offers, Tracking, Transactions, Ledger, Payouts, and Shared.

## How Agents Should Work in This Repo

- **Stay architecture-driven**: Align behavior and explanations with the documented architecture in `docs/architecture.md`, `docs/directory-structure.md`, and `docs/database-design.md`.
- **Prefer domain language**: Use terms like *clicks*, *transactions*, *ledger entries*, *payout requests*, *affiliate networks*, and *offers* consistently.
- **Keep it educational**: This repo is a learning/demo environment; favor clarity and explanation of trade-offs over aggressive optimization.
- **Respect module boundaries**: When suggesting or editing code, keep logic inside the appropriate module (`Offers`, `Tracking`, `Transactions`, `Ledger`, `Payouts`, `Shared`) and use repository interfaces and shared contracts (under `Repositories/`) to cross boundaries.
- **Ledger-first thinking**: Any wallet-related change should preserve the append-only `ledger_entries` model and derive balances from it; avoid introducing mutable balance columns.

## Key Docs and Related Skills

- **System Architecture**
  - Doc: `docs/architecture.md`
  - Skill: `.cursor/skills/architecture/SKILL.md`
  - **Use when**: Explaining or changing high-level flows (click tracking, conversions, cashback, ledger, payouts, events, sync vs async).

- **Module & Directory Structure**
  - Doc: `docs/directory-structure.md`
  - Skill: `.cursor/skills/module-structure/SKILL.md`
  - **Use when**: Adding modules, placing new files, or refactoring into the existing module layout and naming conventions.

- **Database Design**
  - Doc: `docs/database-design.md`
  - Skill: `.cursor/skills/database-design/SKILL.md`
  - **Use when**: Designing queries, changing schema, reasoning about transaction/ledger/payout data, or explaining data flows.

## Agent Behavior Guidelines

- **When unsure**: Prefer reading the relevant skill under `.cursor/skills/*` and the corresponding `docs/*` file before making architectural or data-model decisions.
- **Testing & safety**:
  - Be explicit about how changes impact transaction lifecycle (`tracked → pending → confirmed → reversed → paid`) and ledger entries.
  - Avoid suggesting destructive schema changes without clear migration steps and rationale.
- **Tone & documentation**:
  - Write explanations and docs as if teaching another backend engineer.
  - Keep new documentation short but precise; link back to existing docs instead of duplicating large sections.

