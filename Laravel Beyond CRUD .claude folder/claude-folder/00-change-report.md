# V1 → V2 Update Report: Laravel Beyond CRUD

## Edition Summary

| | V1 (2020) | V2 (2022) |
|---|---|---|
| PHP baseline | 7.4 | 8.2 |
| Laravel baseline | 8 | 9 |
| Revised by | — | Freek Van der Herten (Oct 2022) |
| Test syntax | PHPUnit (`$this->assert...`) | Pest (`it()`, `expect()`, `test()`) |
| DTO package | `spatie/data-transfer-object` | `spatie/laravel-data` |
| Enum approach | `spatie/enum` + `myclabs/php-enum` | Native PHP 8.1 enums |
| Terminology | "DTO" / "data transfer object" | "data object" (preferred) / "DTO" (still used) |
| Domain structure | Can live inside `app/` OR extracted to `src/` | **Default: inside `app/Domain/`**; extraction to `src/` presented as optional "going further" |
| Practical examples | None | **New section**: Flare and Mailcoach domain examples |
| Factory chapter | Custom factories vs. old Laravel factories | Custom factories **and** Laravel 8+ `Model::factory()` shown side-by-side |
| Code style | PHP 7.4 property assignment | PHP 8.2 constructor promotion, readonly, match, named args throughout |
| State chapter opening | Uses `spatie/enum` for initial example | Uses **native PHP 8.1 enum** for initial example |
| Tim MacDonald references | Cited in footnotes | **Removed** from V2 footnotes |
| Martin Fowler anemic models | Cited in footnotes | **Removed** from V2 footnotes |
| Christopher Okhravi | Cited in footnotes | **Removed** from V2 footnotes |
| Inertia.js | Not mentioned | Mentioned in HTTP queries chapter |
| Shared domain | Not mentioned | **New**: `Domain/Shared/` as cross-cutting domain concept |

---

## Artifact-by-Artifact Changes

### 1. `README.md` → root
**Changes:** Update edition reference, terminology note.
- Change "Extracted from *Laravel Beyond CRUD* by Brent Roose (Spatie, 2020)" → "Extracted from *Laravel Beyond CRUD* by Brent Roose (Spatie, 2020; 2nd edition revised 2022 by Freek Van der Herten). Code samples target PHP 8.2 / Laravel 9."
- Add terminology note: the book uses "data objects" and "DTOs" interchangeably.

### 2. `rules/architecture.md`
**Changes:** Update namespace structure to reflect V2's preferred default.
- V2 **default** is `app/Domain/` inside the standard Laravel `app/` folder (NOT requiring `src/` extraction). The `src/Domain/` + `src/App/` approach is presented as an **optional further step**.
- Add note about `Commands` subfolder in domain structure (V2 adds it).
- Update principle #4 to present both approaches (default vs extracted).

### 3. `rules/domain-vs-application.md`
**Changes:** Minor terminology update (DTO → data object). Add `Commands` to domain list.

### 4. `rules/naming-conventions.md`
**Changes:** No structural changes needed. Content is accurate for both editions.

### 5. `rules/anti-patterns.md`
**Changes:** No structural changes needed. All anti-patterns remain valid.

### 6. `rules/decision-guide.md`
**Changes:**
- Update DTO construction guide to emphasize `spatie/laravel-data` as the primary package.
- Update test template to show Pest syntax alongside PHPUnit.
- Add `Commands` to domain class list.

### 7. `context/folder-structure.md`
**Changes:** SIGNIFICANT UPDATE.
- V2 presents **two tiers**: default (domain inside `app/`) and extracted (`src/Domain/`).
- Add `Commands` subfolder to domain structure.
- The application layer structure in V2 stays in `app/Http/` by default (not `src/App/`).
- Add `Domain/Shared/` as a recognised pattern.

### 8. `context/php-type-system.md`
**Changes:** No significant changes needed. The V2 type system discussion is essentially identical.

### 9. `context/managing-domains.md`
**Changes:** SIGNIFICANT UPDATE.
- **New section**: "Some practical examples" — Flare and Mailcoach domain structures.
- Remove named reference to "Ruben" (V2 anonymises to "a new colleague").
- Add note about `Domain/Shared/` pattern with guidance on when it's appropriate.
- Add note about starting without domains and refactoring into them later.
- Add reference to Freek's Mailcoach refactoring video.

### 10. `context/spatie-packages.md`
**Changes:** SIGNIFICANT UPDATE.
- **Replace** `spatie/data-transfer-object` with `spatie/laravel-data` as the primary DTO package.
- Update the package reference table.
- Add `spatie/laravel-data` documentation link and features (form request replacement, API resources, TypeScript generation, validation via attributes).
- Note that `spatie/enum` and `myclabs/php-enum` are superseded by native PHP 8.1 enums.

### 11. `context/further-reading.md`
**Changes:** UPDATE.
- **Remove**: Tim MacDonald custom collections reference (not in V2 footnotes).
- **Remove**: Tim MacDonald dedicated query builders reference (not in V2 footnotes).
- **Remove**: Martin Fowler anemic domain model reference (not in V2 footnotes).
- **Remove**: Christopher Okhravi state pattern video (not in V2 footnotes).
- **Update**: Matthias Noback note — add that DTOs are "now often called data objects" in the book.
- **Update**: Spatie packages list — replace `spatie/data-transfer-object` URL with `spatie/laravel-data`.
- **Add**: Reference to Freek's Laracon Online talk on Laravel Data.
- **Add**: Reference to Freek's Mailcoach domain refactoring video.

### 12. `skills/domain/dtos.md`
**Changes:** SIGNIFICANT UPDATE.
- Rename section headers from "DTO" to "Data Object" where appropriate, noting both terms.
- **Replace** `spatie/data-transfer-object` with `spatie/laravel-data` as the primary recommended package.
- **Add** the `spatie/laravel-data` section: extending `Data`, using as form request, validation via `#[Rule]` attribute, API resource capability, TypeScript generation.
- **Add** the `...$request->validated()` spread pattern as a first option for simple data objects.
- **Remove** the DocBlock alternative section (irrelevant for PHP 8.2 baseline).
- Update "Basic DTO Structure (PHP 7.4)" to "Plain PHP Data Object (PHP 8+)" with constructor promotion.
- Keep the factory approach discussion but note PHP 8 named args make it cleaner.

### 13. `skills/domain/actions.md`
**Changes:** Minor code style updates.
- Update constructor syntax to PHP 8.2 constructor promotion style where applicable.
- No structural/conceptual changes — the actions chapter is essentially unchanged between editions.

### 14. `skills/domain/models.md`
**Changes:** Minor code style updates.
- Update event class to use constructor promotion: `public function __construct(public Invoice $invoice) {}`
- Update subscriber to use constructor promotion.
- No structural changes.

### 15. `skills/domain/states.md`
**Changes:** UPDATE.
- **Replace** the opening "problem" example: V2 uses a **native PHP 8.1 enum** (`enum InvoiceState: string`) for the initial naive approach, not `spatie/enum`.
- Update `PendingInvoiceState::mustBePaid` — V2 uses explicit `if` blocks instead of `&&` chaining with `->equals()`.
- Update abstract state constructor to use PHP 8 constructor promotion.
- Update test example to Pest syntax.
- The core pattern (abstract state → concrete classes → wire to model) is unchanged.

### 16. `skills/domain/enums.md`
**Changes:** SIGNIFICANT UPDATE — largely deprecated by PHP 8.1.
- **Restructure**: Native PHP 8.1 enums are now the **primary and default** approach.
- The `spatie/enum`, `myclabs/php-enum`, and DocBlock approaches become historical context only.
- V2's enums chapter is much shorter — it's essentially "use native enums; graduate to states when needed."
- Remove most of the userland enum discussion since the V2 baseline is PHP 8.1+.

### 17. `skills/application/application-structure.md`
**Changes:** V2 mentions Inertia.js as an alternative to AJAX. Minor wording. No structural change.

### 18. `skills/application/view-models.md`
**Changes:** No significant changes between editions. Content is accurate.

### 19. `skills/application/http-query-builders.md`
**Changes:** V2 mentions Inertia.js alongside AJAX. Simplifies controller example to `$query->paginate()`. Minor.

### 20. `skills/application/jobs.md`
**Changes:** Update code to use PHP 8 constructor promotion. No conceptual changes.

### 21. `skills/testing/test-factories.md`
**Changes:** UPDATE.
- **Replace** "Problems with Laravel's Default Factories (Pre-v8)" with acknowledgment that Laravel 8+ factories are good, and show side-by-side comparison.
- Update code examples to Pest test syntax (`it()`, `expect()`, `test()`).
- Add Laravel 8+ equivalent example for the paid invoice with payment scenario.
- The custom factory pattern remains recommended for DTOs, events, and request objects.

### 22. `skills/testing/testing-domain.md`
**Changes:** UPDATE.
- Update all test examples to Pest syntax.
- Update date strings from `2020-*` to `2022-*` to match V2.
- The testing philosophy and patterns are unchanged.

### 23. `commands/scaffolding.md`
**Changes:** Update templates to PHP 8.2 style (constructor promotion, readonly where appropriate). Add `Commands` to domain scaffold.

---

## New Content in V2 Not Present in V1

| New Content | Target Artifact | Action |
|---|---|---|
| Practical domain examples (Flare, Mailcoach) | `context/managing-domains.md` | Add new section |
| `spatie/laravel-data` package (replaces DTO package) | `skills/domain/dtos.md`, `context/spatie-packages.md` | Major rewrite |
| Native PHP 8.1 enums as default | `skills/domain/enums.md`, `skills/domain/states.md` | Major rewrite |
| Pest test syntax | All testing artifacts | Update examples |
| `Domain/Shared/` pattern | `context/folder-structure.md`, `context/managing-domains.md` | Add section |
| Domain inside `app/` as default (not `src/`) | `context/folder-structure.md`, `rules/architecture.md` | Update structure |
| `Commands` subfolder in domain | `context/folder-structure.md`, `rules/decision-guide.md`, `commands/scaffolding.md` | Add to lists |
| Laravel 8+ factory comparison | `skills/testing/test-factories.md` | Add section |
| 2nd edition note | `README.md` | Update header |
| Freek's Laracon talk on Laravel Data | `context/further-reading.md` | Add reference |
| Freek's Mailcoach refactoring video | `context/further-reading.md`, `context/managing-domains.md` | Add reference |

## Content Removed in V2 (Remove from Artifacts)

| Removed Content | Affected Artifact | Action |
|---|---|---|
| Tim MacDonald blog references | `context/further-reading.md` | Remove entries |
| Martin Fowler anemic domain model reference | `context/further-reading.md` | Remove entry |
| Christopher Okhravi state pattern video | `context/further-reading.md` | Remove entry |
| `spatie/data-transfer-object` as primary package | `skills/domain/dtos.md`, `context/spatie-packages.md` | Replace with `spatie/laravel-data` |
| `spatie/enum` userland approach as primary | `skills/domain/enums.md` | Downgrade to historical |
| `myclabs/php-enum` detailed discussion | `skills/domain/enums.md` | Downgrade to historical |
| DocBlock alternative for DTOs | `skills/domain/dtos.md` | Remove section |
| PHP 7.4 as baseline | All artifacts | Update baseline to PHP 8.2 |
| Named reference to "Ruben" | `context/managing-domains.md` | Anonymise |
