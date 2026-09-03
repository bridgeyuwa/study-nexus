# Further Reading & References

All sources cited in *Laravel Beyond CRUD* (2nd edition) that influenced this architecture.

---

## Talks & Videos

**Gary Bernhardt — Type Systems**
https://www.destroyallsoftware.com/talks/ideology
Explores the philosophical divide between dynamic and static typing communities. Essential for understanding why we care about types.

**Alan Kay — His Vision of OOP**
https://www.youtube.com/watch?v=oKg1hTOQXoY
Kay (who coined "object-oriented") explains his original vision — which emphasises messaging and process over objects as data containers. Influenced the separation of actions from models in this architecture.

**Sandi Metz — Nothing Is Something**
https://www.youtube.com/watch?v=29MAL8pJImQ
Shows how to eliminate all `if` statements using OOP principles. Demonstrates the power of polymorphism (the foundation of the state pattern).

**Freek Van der Herten — Laravel Data at Laracon Online**
A practical demonstration of `spatie/laravel-data` and how it integrates with the data object pattern described in the book.

**Freek Van der Herten — Refactoring Mailcoach to Domains**
A practical video walkthrough of refactoring an existing Laravel codebase into the domain-oriented structure.

---

## Articles & Blog Posts

**Martin Fowler — Transaction Script**
https://martinfowler.com/eaaCatalog/transactionScript.html
Foundational pattern that actions are based on. A transaction script organises business logic as a single procedure per business transaction.

**Freek Van der Herten — Refactoring to Actions**
https://freek.dev/1371-refactoring-to-actions
How to take an existing Laravel application and migrate it toward the domain-oriented structure.

**Freek Van der Herten — Getting Started with Domain-Oriented Laravel**
https://freek.dev/1486-getting-started-with-domain-oriented-laravel
Another practical introduction from the team.

**Tighten — Class-Based Model Factories**
https://tighten.co/blog/tidy-up-your-tests-with-class-based-model-factories
Tighten independently arrived at a similar test factory approach. Good to compare the two implementations.

---

## GitHub Discussions

**Matthias Noback — Value Objects vs. DTOs**
https://github.com/spatie/data-transfer-object/issues/17
Important distinction: Value Objects have equality based on their values; DTOs are just data carriers. The book originally called DTOs "Value Objects" — this thread corrects that. In the 2nd edition, DTOs are often called "data objects."

---

## External Packages

**Symfony Workflow**
https://symfony.com/doc/current/workflow/workflow-and-state-machine.html
For complex state machines. An alternative to `spatie/laravel-model-states` when you need many states, complex transition guards, and transition logging.

---

## Spatie Open Source
https://spatie.be/open-source
All packages from the team behind this architecture. Many were built specifically to support this approach.

**Key packages:**
- `spatie/laravel-data` — https://spatie.be/docs/laravel-data
- `spatie/laravel-query-builder` — https://spatie.be/docs/laravel-query-builder
- `spatie/laravel-view-models` — https://github.com/spatie/laravel-view-models
- `spatie/laravel-model-states` — https://github.com/spatie/laravel-model-states
- `spatie/laravel-queueable-action` — https://github.com/spatie/laravel-queueable-action
