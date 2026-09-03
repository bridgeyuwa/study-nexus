# News / Post-UTME — Product Discovery Additions

**Status:** Approved Product Discovery Addition
**Scope:** Education News, Institutional Updates, Admission & Screening Updates, Post-UTME and Related Information

---

## 1. Purpose

StudyNexus should provide a trusted, searchable, current and SEO-friendly source of education-related news and updates.

The purpose of News is to help users understand:

> **What happened? What changed? Who is affected? When does it matter? What should the learner do? What is the authoritative source?**

News should connect users to the canonical StudyNexus information affected by an announcement or change.

StudyNexus should **report, explain, contextualize and distribute information** rather than become the operational system of an institution, examination authority, regulator, scholarship provider or other external organization.

---

# 2. Core News Principle

> **The domain that owns a fact remains the canonical owner of that fact; News may report, explain or contextualize the fact.**

Examples:

```text
WAEC changes timetable
        ↓
Examination Scheduling owns the canonical schedule
        +
News reports the change
```

```text
University extends Post-UTME deadline
        ↓
Admissions / Institutional Screening owns the deadline
        +
News reports the announcement
```

```text
Scholarship deadline changes
        ↓
Scholarship Cycle owns the canonical deadline
        +
News reports the change
```

News should therefore not become a second database of canonical education facts.

---

# 3. News Scope

News may cover:

* education-sector developments
* institutional updates
* admission updates
* examination updates
* scholarship/funding updates
* policy/regulatory updates
* institutional screening/Post-UTME updates
* application and deadline changes
* official announcements
* warnings and advisories
* analysis
* explainers
* interviews
* other relevant education reporting

The taxonomy should remain extensible.

---

# 4. Content Types

StudyNexus should be capable of distinguishing useful content types such as:

* News / Report
* Official Announcement
* Notice / Advisory
* Analysis
* Explainer
* Interview
* other deliberately supported editorial formats

These remain content types within the broader News capability rather than automatically becoming separate domains.

---

# 5. News vs Evergreen Educational Content

Evergreen educational material should not automatically become News.

For example:

> How Post-UTME works

is more appropriately represented as a Learning Resource or explanatory educational resource.

News can reference or link to the relevant Learning Resource.

This maintains the distinction between:

> **time-sensitive reporting**

and:

> **educational teaching material**.

---

# 6. Entity-Centric News

News should be strongly connected to canonical StudyNexus entities.

A story may reference multiple:

* institutions
* campuses
* programmes
* admission contexts
* institutional screening activities
* examinations
* examination products
* scholarships/funding opportunities
* policies
* regulators
* geographic areas
* disciplines
* other relevant entities

This allows relevant stories to appear naturally on:

* institution pages
* programme pages
* examination pages
* scholarship pages
* admission pages
* geographic pages

without duplicating canonical information.

---

# 7. Categories and Taxonomy

StudyNexus should not permanently replicate competitor taxonomy such as:

> JAMB News
> WAEC News
> Post-UTME News
> School News

as architectural domains.

Instead, discovery should combine:

> content type + topic + entity relationships + search/filtering.

For example:

> Topic: Admission

> Examination: JAMB

or:

> Topic: Institutional Screening

> Institution: University X

This is more extensible and avoids category proliferation.

---

# 8. Noticeboard

A universal standalone **Noticeboard** domain is not required.

An official notice can be represented as a News/Information content type when appropriate.

Examples:

* revised screening date
* application extension
* institutional advisory
* payment warning
* security notice
* resumption announcement
* campus closure

The underlying canonical fact remains owned by the relevant domain.

---

# 9. Official Announcements

StudyNexus may publish appropriately attributed official announcements as identifiable content.

The interface should distinguish:

> **official announcement**

from:

> **StudyNexus reporting about the announcement**.

Source identity and attribution must remain clear.

---

# 10. Original Reporting vs Aggregation

StudyNexus should distinguish between:

* StudyNexus original reporting
* StudyNexus analysis/explainer
* summarized/aggregated reporting
* official-source publication
* licensed/syndicated content

This distinction supports:

* attribution
* provenance
* editorial integrity
* copyright/licensing
* user trust.

---

# 11. Source Attribution

News should preserve relevant source information.

Potential source types include:

* official institution
* regulator
* government
* examination authority
* scholarship provider
* press release
* credible secondary source
* other appropriate source

Factual claims should remain traceable to supporting evidence.

---

# 12. Multiple Supporting Sources

One news story may be supported by multiple sources.

For example:

```text
News Story
 ├── University announcement
 ├── Official PDF
 └── Regulator statement
```

This supports:

* corroboration
* contextual reporting
* conflict resolution
* stronger evidence.

---

# 13. News and Canonical Facts

News content may contain information that changes canonical StudyNexus data.

The relationship should be:

```text
News Story
     ↓
reports / announces / updates
     ↓
Canonical Domain Fact
```

Publication of the story must not automatically make the reported fact canonical.

Canonical data continues through the normal StudyNexus validation, reconciliation and evidence process.

---

# 14. News Updates

A story may be updated when meaningful new information becomes available.

For example:

> deadline extended

> screening date changed

> institution issued clarification.

The news story can preserve its historical narrative while the canonical domain contains the current verified state.

---

# 15. Corrections, Retractions and Clarifications

StudyNexus should support simple editorial states/actions such as:

* corrected
* updated
* clarified
* retracted
* superseded

without creating an unnecessarily complicated newsroom version-control system.

---

# 16. Publication Dates

Keep distinct:

* source publication date
* StudyNexus publication date
* StudyNexus updated date

These represent different facts.

For example:

```text
Official announcement:
5 September

StudyNexus report:
6 September
```

---

# 17. Breaking / Developing / Updated

Support useful presentation/status markers such as:

* Breaking
* Developing
* Updated

These are content/presentation states, not separate domains.

---

# 18. Importance

Do not establish a permanent universal:

> importance_score = 9

for every story.

Importance is contextual.

For example:

> Post-UTME deadline extension

can be extremely important to applicants for the affected institution while having little relevance to another user.

Importance should therefore be considered relative to:

* topic
* entity
* user context
* timing
* affected audience.

---

# 19. News Ordering

News discovery may support distinct ordering modes:

* latest
* relevance
* popularity/engagement
* personalized importance
* editorial prominence

These should remain conceptually distinct.

Do not create one universal `news_rank`.

---

# 20. Trending

“Trending” should generally be derived from signals such as:

* recency
* engagement
* velocity

rather than being a permanent content attribute.

Trending does not imply:

> most important

or:

> most accurate.

---

# 21. Popularity

Engagement such as:

* views
* clicks
* comments
* shares

may influence discovery.

However:

> **Popularity ≠ Importance**

and:

> **Popularity ≠ Credibility**.

---

# 22. Personalized News

StudyNexus may eventually provide:

> **For You**

or:

> **Important for You**

based on legitimate user context such as:

* followed institutions
* followed programmes
* examinations
* scholarships
* geography
* education level
* declared interests.

This should remain a personalization capability, not a separate News domain.

---

# 23. Notifications and Alerts

Notifications should remain a **cross-cutting application capability**.

StudyNexus may allow users to subscribe to:

* institutions
* programmes
* examinations
* scholarships
* admission processes
* screening activities
* Post-UTME
* topics.

Notifications may eventually be delivered through:

* in-app notifications
* email
* push notifications
* other future channels.

News should not own the notification system.

---

# 24. Newsletters and Digests

StudyNexus may eventually provide:

* daily updates
* weekly education digest
* personalized digest
* deadline alerts
* important-change summaries

These are application-level projections using News and canonical domain information.

---

# 25. Community Comments

Comments should not automatically become a News-domain feature.

Community discussion can become a separate application capability and may later be surfaced in relevant News contexts.

---

# 26. Questions and Answers

Q&A should remain distinct from News.

A News story may link to relevant questions, but:

> **News ≠ Q&A**.

---

# 27. Post-UTME

Post-UTME should be represented as a **Nigeria-specific institutional admission screening/assessment concept**, not merely as a News category and not universally as an examination.

The broader semantic concept should support:

> **Institutional Admission Screening / Assessment**

with:

> **Post-UTME**

as the relevant Nigerian/source terminology where applicable.

---

# 28. Post-UTME Canonical Ownership

Post-UTME information belongs canonically within the **Admissions / Institutional Screening** capability.

News reports announcements and changes associated with that screening.

Conceptually:

```text
Institution
    ↓
Admission Context
    ↓
Institutional Screening / Assessment
    ↓
Post-UTME
```

and:

```text
News Story
    ↓
reports / updates
    ↓
Screening Information
```

---

# 29. Post-UTME Screening Formats

Post-UTME should not be hard-coded as CBT.

The screening capability should support formats such as:

* CBT
* online screening
* physical screening
* document verification
* interview
* mixed/hybrid
* other institution-defined formats.

The authoritative source determines the actual format.

---

# 30. Post-UTME Applicability

A screening activity may apply to:

* all relevant applicants
* selected faculties
* selected programmes
* specific admission routes
* candidate categories
* other institution-defined groups.

Applicability must be represented explicitly where the source provides it.

---

# 31. Post-UTME and Admission Routes

Keep:

> **Admission Route**

distinct from:

> **Screening Activity**.

For example:

```text
UTME Route
    ↓
Institutional Screening

Direct Entry Route
    ↓
Institutional Screening
```

A single screening activity may serve multiple admission routes.

---

# 32. Post-UTME Dates and Scheduling

Post-UTME screening should reuse the existing StudyNexus scheduling principles.

Where applicable, support:

* date
* start/end time
* duration
* timezone
* location
* applicable candidate group
* status
* source
* revision history.

Do not create a separate Post-UTME timetable system.

---

# 33. Post-UTME Application Deadlines

Screening-related dates belong to the relevant admission context.

Examples:

* application opening
* application closing
* payment deadline
* screening date
* document deadline
* other meaningful milestones

News may report changes to these dates.

---

# 34. Post-UTME Fees

Where applicable, StudyNexus may represent:

* amount
* currency
* applicable candidate/route
* applicable cycle
* source.

The fee is canonical admission information, not merely News metadata.

---

# 35. Post-UTME Eligibility

Screening eligibility should be represented within the relevant admission/screening policy.

Potential conditions may include:

* UTME score
* first-choice requirement
* programme eligibility
* O'Level requirements
* candidate category
* admission route.

StudyNexus should preserve the institution's published requirements rather than infer them from a News article.

---

# 36. Post-UTME Results

StudyNexus may report:

> Post-UTME results released

and provide:

> official result-checking information/link.

StudyNexus does not own or process individual candidate results.

---

# 37. Admission Lists

StudyNexus may report:

> admission list released

and provide the official checking channel.

StudyNexus does not become the authoritative system for individual admission status.

---

# 38. Changes and Updates

News should be capable of reporting:

* deadline extension
* screening postponement
* date change
* fee change
* new eligibility requirement
* new application route
* portal opening
* supplementary screening
* official correction
* institutional clarification.

Where a change affects canonical StudyNexus information, the relevant domain should be updated independently.

---

# 39. Rumours, Warnings and Disputes

StudyNexus may publish:

* official clarification
* institutional denial
* warning
* correction
* evidence-based fact check
* contextual explanation.

Do not create an unsupported universal numerical “truth score.”

Evidence and source quality should support the determination.

---

# 40. News Trust

News trust should leverage the existing **Evidence & Data Quality Framework**.

Potential signals include:

* official source
* verified source
* corroborated
* source conflict
* updated
* correction issued
* unable to verify
* source publication date.

This addition does not yet define the complete verification/seal system; that is a separate cross-cutting Product Discovery area.

---

# 41. News Search

News should be searchable using relevant dimensions such as:

* text
* date
* topic
* entity
* geography
* source
* content type.

Search ranking remains a separate search/discovery capability.

---

# 42. News SEO

News should support search-engine discovery through:

* canonical URLs
* publication dates
* updated dates where relevant
* structured metadata
* entity relationships
* clear attribution
* indexable content.

Historical stories should remain accessible where they provide continuing value.

---

# 43. Programmatic News SEO

Do not create pages merely because a database event/entity relationship exists.

A page should represent meaningful user intent and contain useful content.

For example:

> University X Post-UTME Screening Update

may justify an indexable page.

An individual event row should not automatically become an SEO page.

---

# 44. Historical News

Important historical stories should generally remain available.

This is particularly valuable for:

* admission policy changes
* examination changes
* institutional history
* deadline extensions
* regulatory developments
* scholarship changes.

Historical reporting and current canonical facts must remain distinguishable.

---

# 45. News Archive vs Current State

A News story may remain historically correct after the fact it reported has been superseded.

Example:

> “University X extended Post-UTME deadline to September 10.”

Later:

> The deadline is extended again to September 15.

The original article remains a historical report.

The Admission domain contains the current canonical deadline.

---

# 46. Authors and Attribution

News should support authorship/bylines where appropriate.

Distinguish:

* StudyNexus author
* StudyNexus editor/reviewer
* source organization
* quoted/credited individual.

The source organization must not be confused with the StudyNexus author.

---

# 47. Editorial Workflow

Initially, a simple workflow is sufficient:

> draft → review → scheduled → published → updated/archived/retracted where appropriate

Do not build a full newsroom management system before the operational need exists.

---

# 48. Editorial Roles

Initially support only roles StudyNexus actually needs, such as:

* author
* editor/reviewer

Additional newsroom roles can be introduced later if required.

---

# 49. AI Assistance

AI may assist with:

* source extraction
* entity identification
* classification
* summarization
* change detection
* related-content discovery
* draft generation.

However:

> **AI output is not authoritative.**

Factual and high-risk claims remain subject to the established source, evidence, validation and editorial process.

---

# 50. Acquisition

News acquisition must respect the established StudyNexus external/offline acquisition boundary:

```text
Source
   ↓
Immutable Raw Capture
   ↓
Extraction
   ↓
Candidate Information
   ↓
Validation / Reconciliation
   ↓
Approved Canonical Data
   ↓
News / Search / Presentation
```

AI agents may assist outside production credentials.

Extraction does not itself establish canonical truth.

---

# 51. Copyright and Source Material

StudyNexus should not become a mirror of external news publishers.

Depending on rights and licensing, StudyNexus may use:

* original reporting
* original summaries
* short quotations where legally appropriate
* attribution
* source links
* licensed/syndicated content

Source material must be handled according to applicable rights and licensing.

---

# 52. International Extensibility Principle

StudyNexus is Nigeria-first but must not be Nigeria-hard-coded.

Domain concepts should be modeled according to their underlying business meaning rather than being limited to terminology, structures, policies, geographic units, or institutions specific to Nigeria.

Nigeria-specific terminology may be represented as a type, classification, source term, policy rule, or localized presentation of a broader concept.

For example:

* **Catchment Area** should not be modeled as an immutable Nigerian institution property.
* **ELDS (Educationally Less Developed States)** should not be treated as a universal global concept; it is a jurisdiction-specific admission classification.
* **State**, **LGA**, and other Nigerian geographic units should not become assumptions embedded throughout the domain.
* International equivalents should be representable without redesigning the underlying domain.

The system should therefore distinguish:

> **underlying semantic concept → jurisdiction/policy-specific type or classification → official terminology → user-facing presentation**

Nigeria-specific concepts should be first-class where necessary for the Nigerian product, but their implementation should leave room for equivalent concepts in other countries and education systems.

This principle applies directly to Post-UTME:

> **Institutional Admission Screening / Assessment** = broader semantic capability
> **Post-UTME** = Nigerian/source-specific terminology where applicable.

---

# 53. JSONB

Canonical News data should remain relational.

Do not create:

```text
news.metadata JSONB
```

as a generic escape hatch.

Raw/source extraction payloads and source-specific structures may use JSONB within acquisition/source storage where appropriate.

---

# 54. Deliberate Non-Goals

This addition does not create:

* a standalone Noticeboard domain
* a Post-UTME News domain
* a candidate result database
* a candidate admission-status system
* an examination-authority operational system
* a scholarship-provider application system
* a universal misinformation/truth score
* a complete newsroom-management platform
* a News-owned comments/Q&A system
* a News-owned notification system
* a separate Post-UTME timetable system
* a Nigeria-only Post-UTME architecture.

---

# 55. Resulting Conceptual Direction

The stable News capability remains relatively small:

```text
News Content
    ↓
Content Type
    ↓
Published / Updated Story
```

with relationships to canonical StudyNexus information:

```text
News Story
 ├── Institution
 ├── Programme
 ├── Admission Context
 ├── Screening
 ├── Examination
 ├── Scholarship
 ├── Policy
 └── Geography
```

For Post-UTME:

```text
Institution
    ↓
Admission Context
    ↓
Institutional Screening / Assessment
    ↓
Post-UTME
```

News provides the time-sensitive reporting and contextual layer around that canonical information.

---

# 56. Core Product Principle

> **StudyNexus should turn education news and institutional updates into useful, trustworthy, connected information—not merely publish articles.**

> **When News reports a change to a canonical StudyNexus fact, the owning domain should contain the current fact while News preserves the historical reporting and context around the change.**
