## Offers Actions & Queries Design

**Goal:** Implement Offers module actions and queries as simple application services that can be called directly from controllers, using the existing repositories, entities, value objects, and DTOs.

**Architecture:** Actions orchestrate state-changing use cases (create/update merchants and offers) via `MerchantRepository` and `OfferRepository`, returning domain entities. Query handlers are thin services that consume these repositories to fetch data and return either entities or DTOs, resolving identifiers provided as IDs or slugs where applicable.

### Actions

- **CreateMerchant**
  - Input: `MerchantData` DTO.
  - Behavior:
    - Build a `Merchant` entity from `MerchantData` (mapping fields like `name`, `slug`, URLs, status, timestamps).
    - Persist via `MerchantRepository::create`.
    - Return the created `Merchant` entity.

- **UpdateMerchant**
  - Input: `MerchantID` and `MerchantData`.
  - Behavior:
    - Load existing merchant via `MerchantRepository::find`.
    - If not found, throw a module-specific exception (e.g. `MerchantNotFound`).
    - Update mutable fields (details and status) based on `MerchantData`.
    - Persist via `MerchantRepository::update`.
    - Return the updated `Merchant`.

- **UpdateOffer**
  - Input: `OfferID` and `OfferData`.
  - Behavior:
    - Load existing offer via `OfferRepository::find`.
    - If not found, throw `OfferNotFound`.
    - Update mutable fields (name, description, tracking URL, cashback fields, status, timestamps) from `OfferData`.
    - Persist via `OfferRepository::update`.
    - Return the updated `Offer`.

### Queries

- **GetMerchantDetails**
  - Query: `GetMerchantDetailsQuery` (accepts merchant ID or slug).
  - Handler:
    - If the identifier is numeric, treat as ID and use `MerchantRepository::find` with a `MerchantID` value object.
    - Otherwise, treat it as slug and use `MerchantRepository::findBySlug`.
    - Return the resolved `Merchant` or `null` if not found.

- **ListAvailableOffers**
  - Query: marker `ListAvailableOffersQuery`.
  - Handler:
    - Use `OfferRepository::listAvailableOffers`.
    - Return an array of `OfferData` DTOs built from the `Offer` entities.

- **ListOffersByMerchant**
  - Query: `ListOffersByMerchantQuery` (merchant identifier).
  - Handler:
    - Accept a `MerchantID` (or ID-as-string) and use `OfferRepository::listMerchantOffers`.
    - Return an array of `OfferData` DTOs.

- **ListActiveOffers**
  - Query: marker `ListActiveOffersQuery`.
  - Handler:
    - Use `OfferRepository::listActiveOffers`.
    - Return an array of `OfferData` DTOs.

- **GetOfferDetails**
  - Query: `GetOfferDetailsQuery` (ID-or-slug).
  - Handler:
    - If identifier is numeric, resolve via `OfferRepository::find` and an `OfferID`.
    - Otherwise, optionally resolve via a slug-capable repository method (or adapt the repository interface as needed).
    - Return the `Offer` entity or `null`.

- **GetOfferCashbackRule**
  - Query: `GetOfferCashbackRuleQuery` (offer identifier).
  - Handler:
    - Resolve the offer using the same ID-or-slug strategy as `GetOfferDetails`.
    - Extract and return only the cashback rule fields (`cashbackType`, `cashbackValue`, `currency`), e.g. as a lightweight DTO or associative array.

This design keeps controllers thin, pushes orchestration into actions/query handlers, and relies on repositories and value objects for persistence and identity concerns.

