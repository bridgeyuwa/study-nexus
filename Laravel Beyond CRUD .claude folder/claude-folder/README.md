# .claude — Laravel Beyond CRUD Knowledge Base

Extracted from *Laravel Beyond CRUD* by Brent Roose (Spatie, 2020; 2nd edition revised 2022 by Freek Van der Herten). Code samples target **PHP 8.2 / Laravel 9**.

This folder contains the full architecture, patterns, rules, and skills from the book, organised for use as Claude project context.

> **Terminology note:** The 2nd edition uses "data objects" and "DTOs" interchangeably. Both refer to the same pattern of wrapping unstructured data in typed classes.

---

## Folder Map

```
.claude/
├── rules/                          ← Hard rules and decision guides
│   ├── architecture.md             ← Core principles (start here)
│   ├── naming-conventions.md       ← Suffixes, method names, folder names
│   ├── domain-vs-application.md    ← What belongs where
│   ├── anti-patterns.md            ← What NOT to do
│   └── decision-guide.md           ← Quick cheat sheet
│
├── context/                        ← Background knowledge and reference
│   ├── folder-structure.md         ← Full canonical project layout
│   ├── php-type-system.md          ← Type theory background
│   ├── managing-domains.md         ← Team guidance, identifying domains
│   ├── spatie-packages.md          ← All relevant Spatie packages
│   └── further-reading.md          ← Books, talks, articles from footnotes
│
├── skills/                         ← Deep how-to guides per pattern
│   ├── domain/
│   │   ├── dtos.md                 ← Data Objects / DTOs
│   │   ├── actions.md              ← Actions pattern
│   │   ├── models.md               ← Thin models, query builders, collections
│   │   ├── states.md               ← State pattern and transitions
│   │   └── enums.md                ← Enums vs states, native PHP 8.1 enums
│   ├── application/
│   │   ├── application-structure.md ← Feature modules, multiple apps
│   │   ├── view-models.md          ← View model pattern
│   │   ├── http-query-builders.md  ← URL param to SQL mapping
│   │   └── jobs.md                 ← Jobs as queue infrastructure only
│   └── testing/
│       ├── test-factories.md       ← Custom immutable test factories
│       └── testing-domain.md       ← How to test each pattern
│
└── commands/
    └── scaffolding.md              ← Templates and checklists for new classes
```

---

## Reading Order

If you're new to this architecture:

1. `rules/architecture.md` — understand the core principles
2. `context/folder-structure.md` — see the full picture
3. `rules/domain-vs-application.md` — know where everything goes
4. `skills/domain/dtos.md` → `actions.md` → `models.md` — the core triad
5. `skills/domain/states.md` → `enums.md` — model state management
6. `skills/application/` — the application layer patterns
7. `skills/testing/` — how to test it all
8. `rules/anti-patterns.md` — what to watch out for
9. `rules/decision-guide.md` — quick reference for daily use

---

## The One-Sentence Summary

> Group code by business concept (not technical type), separate domain logic from application infrastructure, make every business operation an explicit action class, and use strong typing throughout.

---

## Key Quotes

> "Has a client ever told you to 'work on the controllers now'? No — they ask you to work on invoicing, customer management or booking features."

> "It's not about writing the smallest number of characters or about the elegance of code. It's about making large codebases easier to navigate."

> "Actions allow the programmer to think in ways that are closer to the real world, instead of the code."

> "You have to take every opportunity you can to reduce cognitive load."

> "Don't be afraid to start using domains because you can always refactor them later."
