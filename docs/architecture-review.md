# Laravel Architecture Review – studynexus

## High-level architecture snapshot

- **Presentation/UI**: Route definitions in `routes/web.php` map directly to MVC controllers and Livewire components (`app/Livewire`).
- **Application flow**: Controllers contain query-building, filtering, sorting, caching, SEO setup, share-link construction, and view composition.
- **Domain/data**: Eloquent models in `app/Models` primarily expose relationships; there is little domain behavior outside model association methods.
- **Infrastructure concerns mixed into app layer**: cache access, SEO metadata, share links, and sitemap generation logic are embedded in controllers.
- **No explicit domain/application/infrastructure folders** and no dedicated Action, DTO, Repository, Event, Job, or Policy boundaries.

## Principle scoring (0–10)

| Principle | Score | Notes |
|---|---:|---|
| Thin Controllers | 2 | Controllers hold substantial business/query logic, branching, caching, ranking algorithms, and response shaping. |
| Action Classes / Use-Case Objects | 1 | No dedicated `Actions` / use-case classes are present; behavior is concentrated in controllers and Livewire. |
| DTOs | 1 | No `spatie/laravel-data` or custom DTO layer observed; request primitives and arrays are passed around. |
| Value Objects & Entities | 2 | Eloquent models are relational wrappers with no immutable value objects for money/status/email/etc. |
| Application Service / Domain Service Layer | 1 | No service layer; orchestration is mostly in controllers. |
| Repository / Query Objects | 2 | Query logic appears inline in controllers; no repository/query object abstractions. |
| Domain Events | 1 | No domain event/listener structure observed. |
| ViewModels / Resources | 3 | Blade views are used, but response preparation is inside controllers rather than dedicated view models/resources. |
| SOLID + DIP | 3 | Some framework conventions respected, but high-level modules depend on concrete Eloquent and facades. |
| Bounded Contexts | 3 | Functional route groups exist, but no module boundaries (e.g., Domain/Application/Infrastructure per context). |
| Testing & DDD Folder Structure | 2 | Only default example tests are present; no architecture-level test coverage. |

## Problem inventory

### Critical

1. **Fat controller with orchestration + ranking algorithm + persistence concerns**  
   Evidence (`app/Http/Controllers/InstitutionController.php`):
   ```php
   $institutions = Cache::remember('institutions_page_' . request('page', 1), 60 * 60, function() {
       return Institution::with(['state', 'institutionType', 'category'])
   ```
   ```php
   private function computeRank($institution, $allInstitutions) {
       $rank = ['institution' => 0, 'region' => 0, 'state' => 0];
   ```
   Pain: hard-to-test behavior, duplicate logic growth, and fragile performance tuning.

2. **Complex search use-case implemented directly in controller**  
   Evidence (`app/Http/Controllers/SearchController.php`):
   ```php
   $query = Institution::query();
   if ($typeSlug) {
       if ($typeSlug == "public") {
   ```
   ```php
   return $query->paginate(30)->appends($request->except('page'));
   ```
   Pain: no reusable search specification/query object; high risk when adding new filters.

3. **Console command depends on HTTP controller**  
   Evidence (`app/Console/Commands/GenerateSitemap.php`):
   ```php
   $sitemap = new SitemapController();
   $response = $sitemap->index();
   ```
   Pain: violates layer boundaries and prevents clean CLI-oriented orchestration.

### High

1. **Repeated similar-news query duplicated in three controller methods**  
   Evidence (`app/Http/Controllers/NewsController.php`):
   ```php
   $similarNews = Cache::remember($cacheKey, 60 * 60, function () use ($news, $newsCategoryIds) {
       return News::whereHas('newsCategories', function($query) use ($newsCategoryIds) {
   ```
   Pain: fixes must be repeated and can diverge.

2. **Presentation concerns (share links / SEO) duplicated across controllers**  
   Evidence (`app/Http/Controllers/ProgramController.php`):
   ```php
   $shareLinks = \Share::currentPage()
       ->facebook()
       ->twitter()
   ```
   Pain: repeated setup blocks inflate methods and hinder consistency.

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

### Phase 1 (1–2 days, quick wins)
1. Introduce `app/Actions` and extract top duplicate blocks first:
   - `BuildShareLinksAction`
   - `GetSimilarNewsAction`
   - `BuildSeoDataAction` (or context-specific variants)
2. Replace duplicated similar-news code in:
   - `NewsController@show`
   - `NewsController@showByInstitution`
   - `NewsController@showByNewsCategory`
3. Extract sitemap generation into service/action:
   - create `app/Actions/GenerateSitemapAction`
   - call from `GenerateSitemap` command and `SitemapController`.
4. Add focused feature tests around extracted actions.

### Phase 2 (medium refactor)
1. Create `app/Application` and `app/Domain` skeletons by context:
   - `Institution`, `Program`, `News`, `Search`, `Sitemap`.
2. Introduce query objects/repositories for largest queries:
   - `InstitutionSearchQuery`
   - `InstitutionRankingQuery`
   - `SimilarNewsQuery`
3. Migrate `SearchController` and ranking logic in `InstitutionController` to actions + query objects.
4. Add request objects and DTOs (`spatie/laravel-data`) for search filters and result payload shaping.

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
