# Managing Domains — Philosophy & Team Guidance

How to start, evolve, and maintain domain-oriented Laravel projects over time.

---

## The Core Mindset Shift

Stop thinking like this:
> "I'm a programmer who writes code."

Start thinking like this:
> "I'm a translator between real-world problems and technical solutions."

Code is a means to an end. The primary goal is always to understand the business problem — the code is just how you express the solution.

---

## Identifying Domains

Domains come from the business, not from technical categories.

**Process:**
1. Talk to the client (face-to-face if possible)
2. Listen for the nouns and verbs they use naturally
3. Identify subsystems that have clear boundaries
4. Start coding — the right domains will emerge

**Common domain identification methods:**
- Event storming sessions with the client
- User story mapping
- Direct conversation — ask clients to describe their business processes
- Looking at what business reports they need

**The language test:** If the client says "work on invoicing this week" — that's a domain candidate.

---

## Practical Examples from Spatie

### Flare (exception tracker)

After creating a Flare account, you define a project with an API key. Errors from your application are sent to the project. Flare sends notifications on errors, and you can subscribe after a trial.

```
Domain/
├── Account/
├── Error/
├── Flare/
├── Notification/
├── Project/
├── Shared/
└── Subscription/
```

### Mailcoach (email marketing platform)

Build email lists, send campaigns, automate email flows, and send transactional mails. Has hosted and self-hosted versions sharing a common codebase.

```
Domain/
├── Audience/
├── Automation/
├── Campaign/
├── Shared/
└── TransactionalMail/
```

**Notice:** Domain names reflect high-level business concepts. Each domain has essentially the same internal structure as a Laravel app (Actions, Models, Events, etc.).

### The `Domain/Shared/` Pattern

For code that isn't easily identifiable to a single domain. In Flare, there's a custom Activity model providing an audit log used by all other domains. Most of the time, `Shared/` should be very small. A large `Shared/` domain is a sign that you need to restructure. Alternatively, put common code in `Support/` instead.

---

## Domains Will Change — That's Expected

Don't try to get the domain structure perfect upfront. It's impossible.

```
Year 1:  Domain/Invoices/
         → everything invoice-related

Year 2:  Domain/Invoices/     → invoice management
         Domain/Payments/     → payment processing (split out)
         Domain/Collections/  → collections/reminders (split out)
```

**This is healthy.** As your understanding of the business deepens, the domain structure becomes more accurate.

Why it's cheap to refactor:
- Domain code has minimal dependencies (by design)
- Moving files doesn't break application code (as long as namespaces update)
- Modern IDEs like PhpStorm handle refactoring well

**Rule: Don't be afraid to start. You can always refactor.**

When starting a project at Spatie, domains are often not used initially. It's only when certain directories grow too large that the refactoring to domains begins.

---

## Onboarding New Developers

Common concern: "Won't this architecture confuse new developers?"

**The real difficulty in large projects is not the architecture — it's the business knowledge.**

A new developer joining a project with 100 models and 300 actions cannot be expected to understand all the business rules instantly. That takes weeks. The architecture shouldn't be the bottleneck.

**Real experience from Spatie:**
> A new colleague joined as a backend developer to work on a project with a team of three existing developers. The architecture was new to him, even with prior Laravel experience. After a few hours of briefing and pair programming, he was able to work independently. It took weeks to fully understand the business, but the architecture helped him focus on the logic rather than getting lost in the codebase.

**Less magic = less confusion.** Every design decision in this architecture reduces hidden state and implicit behaviour. That makes it faster to learn, not harder.

---

## Teamwork Guidelines

1. **Agree on conventions as a team.** Write them down. This document is a starting point — adapt it.

2. **Revisit agreements.** Don't follow rules dogmatically. New experience should update agreements.

3. **Prioritise consistency over personal preference.** A codebase where 5 developers all have different styles is harder to maintain than one where everyone uses the "wrong" approach consistently.

4. **Document why, not just what.** When you make an architectural decision, write down the reason. Future developers (including yourself) need the context.

---

## Pragmatism vs. Strictness Scale

This architecture sits toward the pragmatic end:

```
Pragmatic ←————————————————→ Strict

Simple CRUD    This approach    Full DDD    Hexagonal
               (recommended)              Architecture
```

Adjust left or right based on:
- Team size and experience
- Project lifespan (2 months vs. 5 years)
- Business complexity
- Client budget and timeline

Not every project needs this. A blog or a simple CRUD admin doesn't benefit from domains and actions.

---

## Signs You Need This Architecture

- The project will last more than a year
- More than 2-3 developers will work on it
- The business logic is genuinely complex
- Controllers/models are already becoming hard to navigate
- You're finding bugs because logic is duplicated in multiple places

---

## Signs You've Over-Applied It

- You have domains with only 1-2 classes
- Every action is a single line delegating to another class
- You're writing more boilerplate than business logic
- The team feels like they're fighting the architecture

**Simplify when this happens.** The architecture serves the project, not the other way around.

---

## The Support Namespace

Everything that doesn't belong in a domain or application but needs to be shared:

```
Support/
├── Http/
│   └── BaseRequest.php
├── Testing/
│   └── Factory.php
├── ValueObjects/
│   └── Money.php
└── Helpers/
    └── DateHelper.php
```

Think of Support as "code that could have been in the framework or a package." If it has a clear home elsewhere, put it there. If not, it goes here.
