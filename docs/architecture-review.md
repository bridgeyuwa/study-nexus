# Laravel Architecture Review – studynexus

## High-level architecture snapshot

- **Presentation/UI**: Route definitions in `routes/web.php` map directly to MVC controllers and Livewire components (`app/Livewire`).
- **Application flow**: Controllers contain query-building, filtering, sorting, caching, SEO setup, share-link construction, and view composition.
- **Domain/data**: Eloquent models in `app/Models` primarily expose relationships; there is little domain behavior outside model association methods.
- **Infrastructure concerns mixed into app layer**: cache access, SEO metadata, share links, and sitemap generation logic are embedded in controllers.
- **No explicit domain/application/infrastructure folders** and no dedicated Action, DTO, Repository, Event, Job, or Policy boundaries.

## Principle scoring (0–10)

> **Last scored**: April 8, 2026 — after Phase 1 Beyond CRUD refactor. Previous total: 21/100.

| Principle | Score | Δ | Notes |
|---|---:|---:|---|
| Thin Controllers | 7 | +5 | Four primary controllers refactored: inject Actions/Queries, delegate, return view. `SitemapController` still fat. |
| Action Classes / Use-Case Objects | 6 | +5 | `app/Actions/` introduced: `BuildShareLinksAction`, `ComputeRankingsAction`, `GetSimilarNewsAction`, `ComputeReadTimeAction`, `GetProgramsAtLevelAction`. |
| DTOs | 4 | +3 | `app/DTOs/SearchFiltersData` introduced (plain PHP, readonly). No `spatie/laravel-data` yet; other domains still use primitives. |
| Value Objects & Entities | 2 | 0 | Models remain relational wrappers; no immutable value objects yet. |
| Application Service / Domain Service Layer | 3 | +2 | Action layer in place; no formal Application/Domain split yet. |
| Repository / Query Objects | 5 | +3 | `app/Queries/InstitutionSearchQuery` introduced. Ranking and sitemap queries still inline. |
| Domain Events | 1 | 0 | No domain event/listener structure yet. |
| ViewModels / Resources | 3 | 0 | Response preparation still in controllers; no dedicated view models. |
| SOLID + DIP | 5 | +2 | Actions injected via constructor; `final class` enforced on new classes. Controllers still reference Eloquent directly. |
| Bounded Contexts | 3 | 0 | Functional route groups exist; no Domain/Application/Infrastructure per context yet. |
| Testing & DDD Folder Structure | 6 | +4 | 50 Pest tests / 75 assertions added covering Actions, Queries, DTOs (Unit + Feature). |

**Total: 45/100** *(+24 from Phase 1)*

## Problem inventory

### Critical

1. ~~**Fat controller with orchestration + ranking algorithm + persistence concerns**~~  
   **✅ RESOLVED (Phase 1)** — `ComputeRankingsAction` extracted from `InstitutionController`. 12× share-link duplication replaced with `BuildShareLinksAction`. 6× `CategoryClass::all()` collapsed to `getCategoryClasses()` helper.

2. ~~**Complex search use-case implemented directly in controller**~~  
   **✅ RESOLVED (Phase 1)** — `InstitutionSearchQuery` + `SearchFiltersData` DTO extracted. `SearchController` slimmed from 174 → ~60 lines.

3. **Console command depends on HTTP controller**  
   Evidence (`app/Console/Commands/GenerateSitemap.php`):
   ```php
   $sitemap = new SitemapController();
   $response = $sitemap->index();
   ```
   Pain: violates layer boundaries and prevents clean CLI-oriented orchestration. **(Phase 2 target)**

### High

1. ~~**Repeated similar-news query duplicated in three controller methods**~~  
   **✅ RESOLVED (Phase 1)** — `GetSimilarNewsAction` extracted; all 3 identical 20-line blocks replaced with single `execute()` call.

2. ~~**Presentation concerns (share links / SEO) duplicated across controllers**~~  
   **✅ RESOLVED (Phase 1, share links)** — `BuildShareLinksAction` replaces 12× repeated chain. SEO setup still inline (Phase 2 target for `BuildSeoDataAction`).

3. **No domain/application foldering; flat app structure**  
   Evidence (`app` top-level folders): Controllers, Models, Livewire, Mail, Providers only.
   Pain: difficult to scale team ownership and bounded-context evolution.

### Medium

1. **God-model tendency (many relationships, little domain behavior)**  
   Evidence (`app/Models/Institution.php`):
   ```php
   public function programs() {
       return $this->belongsToMany(Program::class,'institution_program')...
   }
   ```
   Pain: anemic domain model with logic pushed to controllers.

2. **View composers pulling data globally from service provider**  
   Evidence (`app/Providers/AppServiceProvider.php`):
   ```php
   View::composer('partials.side-bar', function ($view) {
       $categoryClasses = Cache::remember('category_classes', 24 * 60 * 60, function () {
   ```
   Pain: hidden data dependencies and difficult test setup.

3. **Livewire component mixes validation/mail/error orchestration inline**  
   Evidence (`app/Livewire/ContactForm.php`):
   ```php
   Mail::to('support@studynexus.ng')->send(new ContactFormSubmitted([
       'name' => $this->name,
   ```
   Pain: hard to reuse contact-submission logic across channels.

### Low

1. **Only default tests present**  
   Evidence (`tests/Feature/ExampleTest.php`, `tests/Unit/ExampleTest.php`).
   Pain: low confidence during refactoring.

2. **No Spatie Beyond CRUD helper packages for actions/data/querys**  
   Evidence (`composer.json`) does not include `spatie/laravel-data`, `spatie/laravel-query-builder`, or `lorisleiva/laravel-actions`.
   Pain: slower path to consistent patterns.

## Prioritized roadmap

### Phase 1 ✅ COMPLETE (April 8, 2026)
1. ✅ Introduced `app/Actions/`, `app/Queries/`, `app/DTOs/`
2. ✅ Extracted `BuildShareLinksAction`, `GetSimilarNewsAction`, `ComputeReadTimeAction`, `ComputeRankingsAction`, `GetProgramsAtLevelAction`
3. ✅ Extracted `InstitutionSearchQuery` + `SearchFiltersData` DTO
4. ✅ Thinned `InstitutionController`, `NewsController`, `SearchController`, `ProgramController`
5. ✅ Added 50 Pest tests / 75 assertions (Unit + Feature) for all new classes
6. **Deferred to Phase 2**: `BuildSeoDataAction`, `GenerateSitemapAction`

### Phase 2 (medium refactor) — **NEXT**
1. Extract sitemap generation:
   - Create `app/Actions/GenerateSitemapAction`
   - Fix `GenerateSitemap` console command to not instantiate `SitemapController`
2. Introduce `BuildSeoDataAction` (or per-domain SEO value objects)
3. Create `app/Application` and `app/Domain` skeletons by context:
   - `Institution`, `Program`, `News`, `Search`, `Sitemap`
4. Introduce remaining query objects:
   - `InstitutionRankingQuery` (extract from `ComputeRankingsAction` — ranking page queries)
5. Migrate plain `SearchFiltersData` DTO to `spatie/laravel-data` for richer validation/casting
6. Add `FormRequest` classes for validated controller input

### Phase 3 (full DDD/Beyond CRUD transformation)
1. Restructure into bounded contexts with layers:
   - `app/Domain/<Context>`
   - `app/Application/<Context>`
   - `app/Infrastructure/<Context>`
   - `app/UI/Http` (controllers/resources/viewmodels)
2. Introduce domain events and listeners for key workflows (e.g., news publication side-effects, sitemap refresh triggers).
3. Add value objects for core concepts (e.g., `InstitutionType`, `TuitionFee`, `RankPosition`) and enforce immutability.
4. Expand test suite to cover actions, queries, and domain behaviors.

## Before/after examples for top 3 issues

### 1) Fat controller search -> Action + Data object

**Before** (`SearchController@index`): inline filter extraction + query composition.

**After (sketch)**
```php
final class SearchInstitutionsAction
{
    public function execute(SearchInstitutionsData $filters): LengthAwarePaginator
    {
        return InstitutionSearchQuery::fromFilters($filters)->paginate();
    }
}
```

### 2) Duplicated similar-news query -> shared Action

**Before** (`NewsController@show*`): same `Cache::remember(... News::whereHas(...))` block repeated.

**After (sketch)**
```php
$similarNews = app(GetSimilarNewsAction::class)->execute($news);
```

### 3) Command calling controller -> Action orchestration

**Before** (`GenerateSitemap::handle`): instantiate controller.

**After (sketch)**
```php
app(GenerateSitemapAction::class)->execute();
$this->info('Sitemap generated successfully');
```

## Recommended packages to align with Beyond CRUD

- `spatie/laravel-data` (DTO/data mapping)
- `spatie/laravel-query-builder` (structured filtering/sorting)
- `lorisleiva/laravel-actions` (single-responsibility actions)
- Optional: `spatie/laravel-event-sourcing` (if event-driven trajectory is desired)

## Final score

**Overall architecture score: 21 / 100**

**Verdict:** This is a classic Laravel CRUD-style app with solid pragmatic caching, but it needs substantial extraction into actions, DTOs, query objects, and bounded contexts to match Beyond CRUD / DDD standards.
