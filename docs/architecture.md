# Cashback Affiliate System - Architecture

A cashback affiliate system is basically a platform that:
1. sends a user to a merchant through an affiliate link,
2. tracks that click,
3. receives a sale/conversion event later,
4. calculates the user’s cashback,
5. keeps that money in a controlled ledger,
6. pays the user when eligible.

Think of it as a mix of:
* affiliate tracking
* event ingestion
* financial ledger/accounting
* user wallet + payout system

---

## 1. Core Flow
At a high level, the flow looks like this:
```
User
  ↓
Cashback Platform
  ↓
Affiliate Click Tracking
  ↓
Affiliate Network / Merchant
  ↓
Conversion / Sale Event returns later
  ↓
Transaction Processing Engine
  ↓
Cashback Ledger / Wallet
  ↓
Payout System
```
A more practical version:
```
[Frontend App]
   ↓
[API / Backend]
   ├── Click Tracking Service
   ├── Offer / Merchant Service
   ├── Transaction Ingestion Service
   ├── Cashback Engine
   ├── Ledger / Wallet Service
   ├── Payout Service
   ├── Admin / Reconciliation Service
   └── Notification Service
```

---

## 2. Main Architectural Components
Here’s the architecture I’d recommend for a serious version of this system.

### A. Frontend / Client App
This is where users:
* browse merchants/offers
* click “Shop Now”
* view pending cashback
* see confirmed cashback
* request payouts
* view transaction history

### B. API / Application Backend
This is the main entry point.

Responsibilities:
* authenticate users
* serve offers/merchants
* create trackable outbound clicks
* expose transaction history
* expose wallet balance
* handle payout requests
* power admin tools

### C. Click Tracking Service
This is the heart of attribution.

When a user clicks an offer:
* user clicks merchant offer in your platform
* your system generates a unique click ID
* you store the click
* you redirect the user to the affiliate network or merchant URL
* later, when the network sends a conversion, you try to match it back to that click

Typical stored click data:
* click_id
* user_id
* merchant_id
* offer_id
* affiliate_network_id
* outbound URL
* timestamp
* IP / user agent
* device/session metadata
* optional subid/tracking parameters

### D. Affiliate Network / Merchant Integration Layer
Your platform usually does not track the actual final sale itself. Instead, it relies on:
* affiliate networks
* merchant APIs
* postback callbacks
* batch reports
* webhook events

Examples of what they may send later:
* order identifier
* click reference / subid
* sale amount
* commission amount
* event status
* event time
* reversal/cancellation update
This integration layer must normalize different external formats into your internal model.

So instead of letting every network shape your system, you do:
```
External payload → Normalizer → Internal conversion event
```
That keeps the rest of your system clean.

### E. Transaction Ingestion Service
This service receives incoming events from external sources.

Examples:
* webhook from affiliate network
* API polling result
* CSV import from network report
* manual admin reconciliation import

Responsibilities:
* receive raw event
* store raw payload for audit
* validate signature/auth if needed
* normalize event
* detect duplicates
* process idempotently
* emit internal domain event
This service should never just “insert and hope.” It must be defensive.

This is where you handle problems like:
* duplicate webhook retries
* partial data
* status changes from pending → confirmed
* reversed commissions
* out-of-order events

### F. Cashback / Rewards Engine
This decides how much cashback the user gets.

Example logic:
* merchant commission received = $10
* your business keeps $4
* user gets $6 cashback
Or:
* merchant has 8% cashback rate
* order amount = $100
* cashback = $8

This engine should support rules like:
* flat cashback
* percentage cashback
* promotional boosted cashback
* category-specific rules
* capped cashback
* user-tier bonuses
* temporary campaigns

### G. Transaction State Machine
Cashback transactions are not instantly final.

Typical states:
* `tracked`
* `pending`
* `confirmed`
* `reversed`
* `paid`

Example lifecycle:
```
click created
  ↓
conversion received
  ↓
pending cashback created
  ↓
merchant/network confirms it
  ↓
confirmed cashback
  ↓
user requests payout
  ↓
paid
```

Possible failure path:
```
pending
  ↓
reversed
```

You need a controlled transition model so you don’t end up with bad states like:
* paid before confirmed
* reversed after already paid without adjustment
* duplicate confirmation creating extra money

This is why treating this as a state machine is very important.

### H. Ledger / Wallet Service
This is one of the most important design decisions.
Do not store wallet balance as just one mutable column and keep incrementing/decrementing it blindly.

Better approach:
* maintain a ledger table
* every money movement creates an immutable entry
* balance is derived from ledger entries

Example ledger entries:
* cashback_pending +100
* cashback_confirmed +100
* cashback_reversed -100
* payout_requested -80
* payout_completed 0 or status update depending on design

Or a cleaner model:
* pending ledger bucket
* available ledger bucket
* reserved ledger bucket
* paid ledger bucket

This gives you:
* auditability
* reconciliation
* financial correctness
* easier debugging

### I. Payout Service
Once cashback is confirmed and eligible, the user can withdraw.

Responsibilities:
* validate payout eligibility
* ensure enough withdrawable balance
* create payout request
* reserve funds
* send to payout provider or manual process
* mark payout as completed or failed
* write ledger movements
* notify user

Payout methods may include:
* bank transfer
* PayPal
* GCash
* manual payout
* gift cards

### J. Admin / Operations / Reconciliation
You will need an internal admin panel.

Admins need to:
* review clicks
* review conversions
* inspect raw webhook payloads
* retry failed ingestion
* manually reconcile missing transactions
* handle disputes
* reverse transactions
* approve payouts
* view merchant/network performance
* investigate fraud

### K. Notifications / Communication
Users should know what’s happening.

Typical notifications:
* cashback tracked
* cashback confirmed
* cashback reversed
* payout requested
* payout completed

Could be:
* email
* push
* in-app notifications

---

## 3. Recommended High-Level Architecture

For a clean system, I’d split it like this:
```
Frontend / Mobile
   ↓
API Layer
   ↓
Application Services / Use Cases
   ↓
Domain Modules
   ├── Offers
   ├── Clicks
   ├── Tracking
   ├── Transactions
   ├── Cashback
   ├── Ledger
   ├── Payouts
   └── Admin/Reconciliation
   ↓
Infrastructure
   ├── Database
   ├── Queue
   ├── Cache
   ├── Webhook Handlers
   ├── Affiliate Network Clients
   ├── Notification Providers
   └── Payout Providers
```

---

## 4. Suggested Domain Breakdown
For you, I’d probably structure it around these bounded areas:

### Offers / Merchants
Handles:
* merchants
* stores
* offer listings
* cashback rules
* affiliate destinations

### Click Tracking
Handles:
* click generation
* redirect tracking
* attribution identifiers
* session metadata

### Conversion / Transactions
Handles:
* incoming conversion events
* status transitions
* raw event storage
* duplicate detection

### Cashback
Handles:
* reward calculation
* cashback eligibility
* promotional rules

### Ledger / Wallet
Handles:
* money movements
* balance views
* reconciliation basis

### Payouts
Handles:
* withdrawal requests
* payout processing
* provider integration

### Admin / Risk / Reconciliation
Handles:
* manual review
* fraud checks
* support investigation
* exception handling

---

## 5. Synchronous vs Asynchronous Parts
A mistake many people make is trying to do everything in one request.

Better split:
### Synchronous
Things that should happen immediately:
* browse offers
* create click record
* redirect user to merchant
* show wallet/transactions
* create payout request

### Asynchronous
Things better handled in queue/jobs:
* webhook processing
* conversion normalization
* reward calculation after ingestion
* reconciliation
* sending emails/notifications
* payout execution
* retry failed external calls

---

## 6. Event-Driven Mindset
This system benefits a lot from internal events.

Example:
```
ClickCreated
ConversionReceived
ConversionNormalized
TransactionTracked
TransactionConfirmed
TransactionReversed
CashbackCalculated
LedgerEntryCreated
PayoutRequested
PayoutCompleted
```

Why this helps:
* reduces tight coupling
* easier to test
* easier to add notifications later
* easier to build audit trail
* easier to support retries

---

## 7. Simple Architecture Diagram
Here’s a clean conceptual version:
```
                ┌─────────────────┐
                │   Frontend App  │
                └────────┬────────┘
                         │
                         ▼
                ┌─────────────────┐
                │   API Backend   │
                └────────┬────────┘
                         │
     ┌───────────────────┼───────────────────┐
     ▼                   ▼                   ▼
┌─────────────┐   ┌──────────────┐   ┌──────────────┐
│ Click       │   │ Transactions │   │ Payouts      │
│ Tracking    │   │ / Cashback   │   │              │
└──────┬──────┘   └──────┬───────┘   └──────┬───────┘
       │                 │                  │
       ▼                 ▼                  ▼
┌─────────────┐   ┌──────────────┐   ┌──────────────┐
│ Affiliate   │   │ Ledger /     │   │ Notifications│
│ Networks    │   │ Wallet       │   │ / Admin      │
└─────────────┘   └──────────────┘   └──────────────┘
```