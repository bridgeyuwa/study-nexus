# Timetable / Product Discovery Additions

**Status:** Proposed Product Discovery Addition 02-09-2026
**Scope:** StudyNexus Examination Information & Discovery
**Primary principle:** StudyNexus is an independent education information and discovery platform. It does not represent examination bodies, conduct examinations, process registrations, manage candidate bookings, process results, or issue certificates.

---

## 1. Purpose

StudyNexus should provide students with a reliable, searchable, SEO-friendly source of examination scheduling and important-date information.

The feature should answer:

> **What examination is this, which administration am I looking at, when are the relevant events, who do they apply to, where/when do they occur, what deadlines matter, what has changed, and where can I find the official information or registration channel?**

StudyNexus should **inform and direct**, not operate the examination.

---

# 2. Product Boundary

## StudyNexus owns

StudyNexus may normalize, store, search, display and connect:

* examination identity
* examination product
* administration / series / session / sitting information
* examination schedule events
* examination dates and times
* applicable candidate categories
* relevant location/jurisdiction information
* important registration-related dates
* official registration/application/booking links
* official source documents and source provenance
* schedule revisions and superseded information
* externally sourced availability information where authoritative and useful
* historical examination schedules
* timetable, date, deadline and calendar presentations
* links from examination schedules into syllabus/specification, learning resources and practice

## StudyNexus does not own

StudyNexus does not become:

* an examination authority
* a registration provider
* a payment processor for examination registration
* a booking platform
* a seat/inventory management system
* an examination marking system
* a results-processing system
* a certificate issuer
* a candidate-record management system

StudyNexus may explain and link to these external processes without owning them.

---

# 3. Core Conceptual Model

The core examination scheduling structure should remain intentionally small:

```text
Examination Authority
        ↓
Examination Product
        ↓
Examination Administration
        ↓
Schedule Events
```

### Example

```text
WAEC
  ↓
WASSCE
  ↓
2027 May/June
  ↓
Schedule Events
    ├── English Language
    ├── Mathematics
    ├── Biology
    └── Physics Practical
```

The exact terminology used by the authority should be preserved for presentation.

For example, an administration may officially be described as:

* First Series
* May/June
* Second Series
* Session
* Sitting
* Examination Window

StudyNexus may use a normalized internal concept such as **Examination Administration**, while displaying the authoritative terminology to users.

---

# 4. Examination Product

An Examination Product represents a meaningful examination offering that candidates recognize and/or register for.

Examples may include:

* WASSCE
* WASSCE School Candidates
* WASSCE Private Candidates
* NECO SSCE Internal
* NECO SSCE External
* JAMB UTME
* GRE General Test
* GRE Subject Tests
* IELTS Academic
* IELTS General Training

Candidate category must not automatically become an examination product. It becomes a separate product only where the examination authority actually defines it as such.

---

# 5. Examination Administration

An Examination Administration represents a specific occurrence or operating cycle of an Examination Product.

Examples:

```text
WASSCE
→ May/June
→ 2027
```

or:

```text
NECO SSCE External
→ 2027 Administration
```

or an equivalent official series/session/sitting/window.

Administration is primarily a StudyNexus normalization concept. Official source terminology should remain visible to users.

---

# 6. Schedule Events

A **Schedule Event** is the smallest meaningful scheduled occurrence that StudyNexus needs to publish.

A schedule event may represent:

* an examination paper
* a subject examination
* a practical
* an oral examination
* another assessment component
* an appointment-based examination
* another meaningful externally scheduled examination event

The model must not assume that every examination consists of “papers.”

### Minimum useful event information

Where available:

* examination administration
* assessment component/subject
* event date
* start time
* end time
* duration
* timezone
* applicable candidate category
* jurisdiction/location
* delivery mode where relevant
* event status
* source/provenance

Only information actually provided or supportable from the source should be populated.

---

# 7. Assessment Components

The scheduling model should not hard-code a universal concept of “paper.”

An examination may use terms such as:

* subject
* paper
* component
* module
* section
* practical
* oral
* coursework
* project

StudyNexus should normalize these where useful while preserving the official terminology.

Relationships should permit:

```text
One Assessment Component
        ↓
Multiple Schedule Events
```

For example:

```text
Biology
 ├── Theory
 └── Practical
```

Likewise, a single schedule event may apply to multiple components where the official timetable genuinely defines it that way.

---

# 8. Time Semantics

StudyNexus must preserve the precision of the authoritative source.

A schedule may provide:

* date only
* date + start time
* start and end time
* duration
* date range
* time window
* appointment slot
* session label such as “Morning”
* session label such as “Afternoon”

Do not invent exact times when the authority only provides an approximate/session description.

For example:

```text
Morning Session
```

must not automatically become:

```text
09:00
```

unless the source establishes that time.

Duration should be optional and independent where the source provides it.

---

# 9. Timezone

Where an actual time is provided, StudyNexus should maintain an explicit timezone context where it can be reliably determined.

The system should prioritize:

1. explicitly specified event/test location
2. known examination administrative region
3. authoritative examination timezone
4. user/browser timezone only for optional display conversion

IP-derived location should not silently determine an authoritative examination timezone.

Where relevant, users should see explicit timezone information, for example:

> 10:00 WAT (UTC+1)

---

# 10. Location and Applicability

Location should not be treated as one universal field.

StudyNexus may need to distinguish:

* country/jurisdiction
* administrative region
* testing region
* test centre
* venue
* remote/home testing
* school-based testing

Candidate residence is separate from examination applicability/location.

For example:

```text
Applicable in: Nigeria
Candidate type: Private Candidates
```

is conceptually different from:

```text
Test centre: Abuja
```

---

# 11. Delivery Mode

Where relevant, an examination event may indicate its delivery mode, such as:

* paper-based
* computer-based
* centre-based
* school-based
* home/remote
* online
* hybrid

Delivery mode should not be assumed merely because the examination product commonly uses one mode.

---

# 12. Candidate Applicability

Candidate categories are applicability information rather than automatically separate examinations.

Examples:

* school candidates
* private candidates
* domestic candidates
* international candidates
* special candidates

The schedule should be capable of communicating:

> This event applies to X candidate group.

without changing the identity of the examination unnecessarily.

---

# 13. Variants, Sets and Groups

StudyNexus should **not** create a universal “set” concept that assumes every authority means the same thing.

Terms such as:

* Set A/B/C
* paper variant
* regional variant
* language variant
* time-zone variant
* candidate group
* alternative paper
* replacement paper

must retain their source meaning.

Where such distinctions become necessary, they should be represented through appropriately named relationships/attributes rather than one generic field that becomes a dumping ground.

Candidate groups and paper/question variants should remain conceptually distinct.

---

# 14. Important Dates

StudyNexus should publish important examination-related dates in addition to timetable events.

Examples:

* registration opens
* registration closes
* late-registration deadline
* payment deadline
* document deadline
* accommodation deadline
* change/cancellation deadline
* examination period
* results publication date

These are **information about the examination administration**, not operational workflows StudyNexus owns.

The product should avoid creating a large examination-management lifecycle system merely to represent dates.

---

# 15. Registration and Booking Boundary

StudyNexus does not register candidates and does not book examination appointments on behalf of examination bodies.

StudyNexus may provide:

* registration dates
* registration instructions
* eligibility information
* official registration links
* official booking links
* official application portals
* explanatory guidance

The user should be handed off to the authoritative provider for the actual transaction.

The interface must not imply that StudyNexus has reserved a candidate's examination place unless a future, explicitly authorized integration genuinely performs that transaction.

---

# 16. External Availability

Some examination systems expose appointment or registration availability.

StudyNexus may report externally sourced availability **where it is authoritative, useful and sufficiently fresh**.

Possible normalized statuses include:

* available
* limited
* unavailable
* waitlist
* registration closed
* unknown

StudyNexus should not model generic examination capacity or maintain its own `remaining_seats` inventory.

Where availability is displayed, provenance and freshness should be clear.

Example:

> **Availability:** Available
> According to official provider
> Last checked: …

Availability is informational, not a StudyNexus guarantee.

---

# 17. Test Centres

StudyNexus may maintain examination/test-centre information where it improves discovery.

The centre record should support useful information such as:

* centre name
* location
* jurisdiction
* address
* official identifier where applicable
* examination/product applicability
* official source

StudyNexus should not attempt to model operational centre management or inventory unless a specific future product requirement independently justifies it.

---

# 18. Schedule Changes and Supersession

Schedule information must not simply be overwritten when an authoritative timetable changes.

The system should preserve meaningful revision history.

Example:

```text
Original:
10 June 2027

Revised:
15 June 2027
```

Users should be able to understand that the schedule changed.

Where appropriate, presentation can state:

> **Updated:** Examination moved from 10 June to 15 June.

The underlying canonical system should preserve the relationship between superseded and current information.

---

# 19. Published Date vs Event Date

These concepts must remain distinct.

For example:

```text
Source published:
1 June 2027

Schedule event:
20 June 2027
```

A later revision may be:

```text
Revision published:
5 June 2027

Updated event date:
22 June 2027
```

At minimum, StudyNexus should distinguish:

* source publication date
* event date
* effective date where materially relevant

This prevents publication timing from being confused with examination timing.

---

# 20. Cancellation and Postponement

A cancelled or postponed schedule must not simply disappear.

StudyNexus should be able to represent:

```text
Original event
    ↓
Cancelled / postponed
    ↓
Replacement or revised event
```

This supports trustworthy historical presentation and prevents old information from silently being lost.

---

# 21. Source and Provenance

Every important normalized scheduling fact should be traceable to authoritative source material.

StudyNexus should preserve:

* source authority
* source document/page or relevant source location
* source version
* publication date
* relevant source fragment/anchor where useful
* ingestion/verification information
* supersession state

This follows the existing StudyNexus architecture:

```text
Immutable Source
      ↓
Extraction / Parsing
      ↓
Normalized Domain Data
      ↓
Application / Presentation
```

The timetable UI must never become the primary source of truth.

---

# 22. Source Conflicts

If authoritative sources conflict, StudyNexus should not silently select whichever source happened to be processed last.

The existing reconciliation and evidence/data-quality process should determine the canonical value.

Where conflict remains unresolved, StudyNexus should retain the evidence and avoid presenting false certainty.

This is especially important for changing examination schedules.

---

# 23. Freshness

Timetable information is highly time-sensitive.

StudyNexus should distinguish, where relevant:

* source publication date
* StudyNexus ingestion date
* last verification date
* superseded/current status
* last checked time for external availability

The user should be able to tell whether information is current.

---

# 24. Presentation

“Timetable” should be treated primarily as a **presentation of normalized examination scheduling data**, not as the universal underlying domain object.

The same canonical data may produce:

### Timetable view

A traditional subject/date/time table.

### Dates view

A chronological list of examination dates.

### Calendar view

A calendar-oriented visualization.

### Deadlines view

Registration and other important dates.

### Availability view

Applicable only where an examination provider exposes useful availability information.

All of these should consume the same underlying canonical information.

---

# 25. SEO

Meaningful examination schedule information should be discoverable through dedicated canonical URLs where it satisfies a genuine user search intent.

Potential examples include:

```text
/exams/{exam}/dates
/exams/{exam}/{administration}/timetable
/exams/{exam}/{administration}/deadlines
/exams/{exam}/{administration}/registration
```

Exact URL structure remains an implementation/product decision.

SEO pages should be generated from canonical domain data.

Do not create an indexable page merely because a database row exists.

Examples that may have legitimate search value:

> WAEC 2027 timetable
> WAEC Biology timetable 2027
> NECO SSCE External 2027 timetable

Examples that should not automatically become thousands of thin pages:

> Individual centre/date/appointment combinations with no independent search value.

Historical timetable pages may remain indexable where they provide genuine reference/search value and are clearly identified as historical.

---

# 26. Search and Discovery

Timetable/schedule information should be available through StudyNexus search and discovery.

Search may expose/filter by:

* examination
* examination product
* administration
* year
* subject/component
* date
* location
* candidate applicability
* status

Search infrastructure such as Typesense remains a projection.

PostgreSQL/domain data remains authoritative.

---

# 27. Cross-Domain Connections

Examination scheduling should connect naturally to the rest of StudyNexus.

A user viewing:

> WAEC Biology — 12 June 2027

should be able to move into:

```text
WAEC
  ↓
WASSCE
  ↓
2027 Administration
  ↓
Biology
  ├── Syllabus / Specification
  ├── Knowledge Topics
  ├── Learning Resources
  └── Practice Questions
```

The timetable therefore becomes an entry point into preparation rather than an isolated calendar feature.

---

# 28. Location and Timezone User Experience

Normal discovery should not be blocked by confirmation dialogs.

However, when a user performs a consequential action such as following an external registration/booking process, StudyNexus should make relevant location/timezone assumptions visible where they could cause confusion.

For example:

> Examination date shown for Nigeria / WAT (UTC+1).

User-selected location should take precedence over silent inference.

---

# 29. Historical Data

StudyNexus should preserve historical administrations and schedule revisions when they provide meaningful educational, reference or search value.

Historical information should be clearly labeled so users do not mistake it for the current timetable.

This also supports:

* SEO
* research
* historical comparison
* schedule-change transparency
* data provenance

---

# 30. Data Acquisition Implications

Timetable acquisition should follow the established StudyNexus acquisition boundary.

```text
Official source
      ↓
Raw immutable capture
      ↓
Extraction
      ↓
Normalization
      ↓
Candidate data
      ↓
Validation / reconciliation
      ↓
Approved canonical data
      ↓
Search projection / presentation
```

Acquisition agents or AI may assist with extraction and normalization, but they are not authorities.

Canonical timetable information must be determined through deterministic validation/reconciliation and the established evidence/governance process.

---

# 31. Deliberate Non-Goals

The following are explicitly outside this product addition:

* building an examination registration platform
* booking examination appointments
* managing examination seat inventory
* collecting examination registration payments
* conducting examinations
* marking examinations
* processing candidate results
* issuing certificates
* maintaining candidate examination records
* reproducing an examination body's internal operational model
* creating a universal academic “calendar” domain
* creating a giant generic examination lifecycle framework
* creating separate domains for every timetable terminology variation

These may be discussed in future product work only if a concrete StudyNexus requirement emerges.

---

# 32. Product Principle

> **StudyNexus models the examination information necessary to help users discover, understand, prepare for and reach the authoritative examination service. It does not attempt to become the examination service.**

This principle should govern future examination scheduling discoveries and prevent timetable scope from expanding into examination-management software.

---

# 33. Resulting MVP Scope

For the initial implementation, the timetable capability should be achievable with a comparatively small conceptual surface:

```text
Examination Authority
        ↓
Examination Product
        ↓
Administration
        ↓
Schedule Events
```

with supporting information for:

```text
Important Dates
Candidate Applicability
Location / Timezone
Official Sources
External Registration Links
Schedule Status / Changes
```

Everything else should be introduced only when actual StudyNexus data requires it.

---

# 34. Architecture Principle

The timetable system should follow the broader StudyNexus rule:

> **Normalize meaning without forcing every external examination system into an artificial identical structure.**

Official source structure and terminology should be preserved as evidence and presentation context.

StudyNexus should create a **small stable semantic core**, while allowing examination-specific details to remain source-specific when they do not have meaningful shared behavior.

The goal is not to model every possible examination system.

The goal is to provide a trustworthy, normalized, searchable and useful representation of examination scheduling information.
