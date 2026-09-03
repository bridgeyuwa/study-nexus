# Laravel Beyond CRUD — Architecture Rules

These are the non-negotiable principles for building larger-than-average Laravel applications.

---

## 1. Group Code by Business Concept, Not Technical Type

**WRONG:** Group all controllers together, all models together, all jobs together.

**RIGHT:** Group all invoice-related code together — its controllers, models, actions, data objects, states, jobs.

> "Has a client ever told you to 'work on the controllers now'? No — they ask you to work on invoicing, customer management or booking features."

Apply this in both the Domain layer and the Application layer. The same grouping principle governs both.

---

## 2. Separate Domain from Application

Every project has two distinct layers:

**Domain** — pure business logic. Has no knowledge of HTTP, requests, or framework infrastructure.
- Data Objects (DTOs)
- Actions
- Commands (domain commands, not Artisan)
- Models (data-oriented only)
- States & Transitions
- Enums
- Query Builders (Eloquent)
- Collections
- Events & Listeners
- Domain Exceptions
- Validation Rules

**Application** — consumes the domain and exposes it to users.
- Controllers
- Requests
- Middleware
- Resources (API)
- View Models
- HTTP Query Builders
- Jobs
- Commands (Artisan)

Applications do NOT talk to each other directly. They each consume the shared domain independently.

---

## 3. One Project, Multiple Applications

A single Laravel project may have several application surfaces:

```
app/Http/     — HTTP controllers, middleware, requests, resources, view models
app/Console/  — Artisan commands
```

Or, if extracting further:

```
src/App/Admin/     — HTTP admin panel
src/App/Api/       — REST API
src/App/Console/   — Artisan commands
```

Each is a standalone entry point into the domain. They share domain code but are otherwise isolated.

---

## 4. Namespace Root Structure

**Default approach (recommended for most projects):** Keep the Domain namespace inside `app/`:

```
app/
├── Domain/          ← All business logic, grouped by concept
├── Http/            ← Controllers, middleware, requests, etc.
├── Console/         ← Artisan commands
└── ...
```

No composer.json changes needed. This provides a good balance between domain-oriented structure and staying close to Laravel conventions.

**Extracted approach (optional, for larger projects):**

```json
{
  "autoload": {
    "psr-4": {
      "App\\": "src/App/",
      "Domain\\": "src/Domain/",
      "Support\\": "src/Support/"
    }
  }
}
```

`Support\` is the dumping ground for global helpers, base classes, and utilities that belong nowhere specific — things that could have been part of the framework itself.

---

## 5. Reduce Cognitive Load Above All Else

Every architectural decision should be evaluated against one primary question:

> Does this make the codebase easier to understand and navigate for a team working on it for years?

Metrics that indicate success:
- A new developer can work independently after a few hours of onboarding
- You know exactly where to go when a business requirement changes
- No magic, no hidden global state, no implicit coupling

---

## 6. Embrace the Framework, Don't Fight It

Use Laravel's extension points rather than introducing alien patterns:

- Use `newEloquentBuilder()` instead of repositories
- Use `newCollection()` for custom collection classes
- Use `$dispatchesEvents` for model event remapping
- Use `spatie/laravel-model-states` for the state pattern

---

## 7. Pragmatism Over Purity

These are guidelines, not laws. When two approaches have the same outcome but one is significantly simpler — choose simpler. Revisit the decision when complexity grows.

> "Don't think of this book as giving a fixed set of rules. Think of it as handing you a collection of ideas."

When starting a new project, you don't have to use domains from day one. Start with the standard Laravel structure, and refactor into domains when directories grow too large. Using a good IDE like PhpStorm, moving namespaces around can be done very fast.
