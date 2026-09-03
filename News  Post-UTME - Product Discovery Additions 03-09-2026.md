# News / Post-UTME — Product Discovery Additions

**Status:** Approved Product Discovery Addition
**Scope:** Education News, Institutional Updates, Admission/Screening Updates and Post-UTME Information

---

# 1. Purpose

StudyNexus should provide a trusted, searchable, current and SEO-friendly source of education-related news and updates.

The feature should help users understand:

> **What happened? What changed? Who is affected? When does it take effect? What should the student do? What is the authoritative source?**

News should connect users to the canonical StudyNexus information affected by an announcement or change.

StudyNexus should **report, explain, contextualize and distribute information** rather than become the operational system of the institution, examination authority, scholarship provider or regulator.

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
* Post-UTME and institutional screening updates
* application and deadline changes
* official announcements
* warnings and advisories
* analysis
* explainers
* interviews
* other relevant education reporting

The exact taxonomy should remain extensible.

---

# 4. News Content Types

StudyNexus should be able to distinguish useful content types such as:

* News / Report
* Official Announcement
* Notice / Advisory
* Analysis
* Explainer
* Interview
* other deliberately supported editorial formats

These should remain content types within the broader News capability rather than automatically becoming separate domains.

---

# 5. Evergreen Educational Content

Evergreen educational guides should not automatically become News.

For example:

> How Post-UTME works

is more appropriately represented as a Learning Resource / explanatory resource.

News may link to or reference the resource.

This maintains the existing separation between:

> **time-sensitive reporting**

and:

> **educational teaching material**.

---

# 6. Entity-Centric News

News should be strongly connected to StudyNexus's canonical entities.

A story may reference one or more of:

* institution
* campus
* programme
* admission context
* examination
* examination product
* scholarship/funding opportunity
* policy
* regulator
* geography
* discipline
* other relevant entities

For example:

```text
News Story
    ├── Institution
    ├── Admission Context
    ├── Post-UTME Screening
    ├── Programme
    └── Geography
```

This should enable institution pages, examination pages, scholarship pages and programme pages to surface relevant updates automatically.

---

# 7. News Categories

StudyNexus should avoid hard-coding competitor taxonomies as permanent architectural categories.

Do not make:

> JAMB News
> WAEC News
> Post-UTME News

into separate domains.

Instead, use a combination of:

> content type + topic + entity relationships + search/filtering.

For example:

> Topic: Admission

> Examination: JAMB

or:

> Topic: Institutional Screening

> Institution: University X

This is more extensible.

---

# 8. Noticeboard

A separate universal **Noticeboard domain** is not required.

An official notice can be represented as a News/Information content type where appropriate.

Examples:

* revised screening date
* campus closure
* payment warning
* security notice
* resumption announcement
* application extension
* institutional advisory

The underlying canonical fact remains with the appropriate domain.

---

# 9. Official Announcements

StudyNexus may publish or reproduce appropriately licensed/attributed official announcements as an identifiable content type.

The user should be able to understand:

> this is an official announcement

versus:

> this is StudyNexus reporting about the announcement.

Source identity and attribution must remain clear.

---

# 10. Original Reporting vs Aggregation

StudyNexus should distinguish between:

* StudyNexus original reporting
* StudyNexus analysis/explainer
* summarized/aggregated reporting
* official-source publication
* licensed/syndicated content

This distinction matters for:

* attribution
* provenance
* editorial integrity
* copyright/licensing
* user trust

---

# 11. Source Attribution

News should preserve the relevant source information.

Potential source types include:

* official institution
* regulator
* government
* examination authority
* scholarship provider
* press release
* credible secondary source
* other appropriate source

Canonical factual claims should remain traceable to supporting evidence.

---

# 12. Multiple Sources

A news story may be supported by multiple sources.

For example:

```text
News Story
 ├── University Announcement
 ├── Official PDF
 └── Regulator Statement
```

This is useful for:

* corroboration
* context
* conflicting claims
* richer reporting

---

# 13. News and Canonical Facts

News content may contain facts that affect canonical StudyNexus data.

The system should support the relationship:

```text
News Story
     ↓
reports / announces / updates
     ↓
Canonical Domain Fact
```

The canonical domain must then be updated through the normal validation/reconciliation process rather than treating publication of the news story as automatic proof.

---

# 14. News Updates

A news story may be updated when meaningful new information becomes available.

Examples:

> deadline extended

> screening date changed

> university issued clarification

The story may retain its historical narrative while the canonical admission/scheduling data reflects the current authoritative state.

---

# 15. Corrections, Retractions and Clarifications

StudyNexus should support simple, explicit states/actions such as:

* corrected
* updated
* clarified
* retracted
* superseded

These should be handled without creating an unnecessarily elaborate newsroom version-control system.

---

# 16. Source Publication vs StudyNexus Publication

Keep distinct:

* source publication date
* StudyNexus publication date
* StudyNexus updated date

For example:

```text
Official announcement:
5 September

StudyNexus report:
6 September
```

These represent different facts.

---

# 17. Breaking / Developing / Updated

Support simple presentation/status markers such as:

* Breaking
* Developing
* Updated

These are content/presentation states, not separate domains.

---

# 18. Importance

Do not create a permanent universal:

> importance_score = 9

for every story.

Importance is contextual.

For example:

> Post-UTME deadline extension

may be extremely important to affected applicants but irrelevant to someone looking for postgraduate scholarships abroad.

Importance should therefore be contextualized by user/topic/entity where needed.

---

# 19. News Ordering

News discovery may support separate ordering modes:

* latest
* relevance
* popularity/engagement
* personalized importance
* editorial prominence

These are distinct from one another.

Do not create one universal `news_rank` that collapses all meanings.

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

Views, comments, clicks, shares and other engagement signals may influence discovery.

However:

> **popularity ≠ importance**

and:

> **popularity ≠ credibility**

Popularity should not become a hidden quality score.

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
* declared interests

This remains a personalization capability rather than a separate News domain.

---

# 23. Notifications and Alerts

Notifications should be a **cross-cutting application capability**, not owned by News.

StudyNexus may eventually allow users to subscribe to:

* institutions
* programmes
* examinations
* scholarships
* admission processes
* Post-UTME
* topics

and receive relevant updates.

Potential delivery modes include:

* in-app
* email
* push
* other future channels

---

# 24. Newsletters / Digests

StudyNexus may eventually provide:

* daily updates
* weekly education digest
* personalized digest
* deadline alerts
* important-change summaries

These are application projections built from canonical information and News content.

---

# 25. Community Comments

Comments should not automatically become a News-domain requirement.

Community discussion may become a separate application capability.

News may later expose discussion where that capability exists.

---

# 26. Q&A

Questions and answers should remain distinct from News.

StudyNexus may allow a News story to link to relevant questions, but:

> News ≠ Q&A.

This maintains a clear separation between:

> editorial reporting

and:

> community/user knowledge.

---

# 27. Post-UTME

Post-UTME must be represented as a **Nigeria-specific institutional admission screening/assessment concept**, not merely as a News category and not universally as an examination.

The broader semantic capability should support:

> **Institutional Admission Screening / Assessment**

with:

> Post-UTME

as a Nigerian/source-specific terminology/type where applicable.

This preserves international extensibility.

---

# 28. Post-UTME Ownership

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
Screening information
```

---

# 29. Post-UTME Screening Formats

Institutional screening should not be hard-coded as CBT.

It may involve:

* CBT
* online screening
* physical screening
* document verification
* interview
* mixed/hybrid process
* other institution-defined formats

The applicable source determines what actually applies.

---

# 30. Post-UTME Applicability

Screening may apply to:

* all undergraduate applicants
* specific faculties
* specific programmes
* particular admission routes
* candidate categories
* other institution-defined groups

The model should preserve actual applicability rather than assume institution-wide scope.

---

# 31. Post-UTME and Admission Routes

Keep:

> **Admission Route**

distinct from:

> **Screening Activity**.

For example:

```text
UTME route
    ↓
Institutional screening

Direct Entry route
    ↓
Institutional screening
```

A single screening activity may serve multiple admission routes.

---

# 32. Post-UTME Dates

Post-UTME screening dates should reuse the existing StudyNexus scheduling principles.

Where applicable, support:

* date
* start/end time
* duration
* timezone
* location
* applicable candidate group
* status
* source
* revision history

Do not create a completely separate timetable system for Post-UTME.

---

# 33. Post-UTME Application Deadlines

Screening-related dates should be represented canonically within the admission context.

Examples:

* application opens
* application closes
* payment deadline
* screening date
* document deadline
* other meaningful milestones

News may report changes to those dates.

---

# 34. Post-UTME Fees

Where applicable, StudyNexus may represent:

* fee amount
* currency
* applicable candidate category/route
* applicable cycle
* source

The fee is canonical admission information, not merely a News field.

---

# 35. Post-UTME Eligibility

Eligibility should be represented within the relevant admission/screening policy.

Potential conditions may include:

* UTME score
* first-choice requirement
* programme eligibility
* O'Level requirements
* admission route
* candidate category

StudyNexus should preserve the actual institution's requirements rather than infer them from news reporting.

---

# 36. Post-UTME Results

StudyNexus may report:

> screening results released

and provide:

> official result-checking information/link.

StudyNexus does not own or process individual candidate results.

Individual candidate result records are outside the scope of this Product Discovery addition.

---

# 37. Admission Lists

StudyNexus may report:

> admission list released

and link users to the official checking channel.

StudyNexus does not become the authoritative system for individual admission status.

---

# 38. Result and Admission Release Information

Where useful, StudyNexus may publish information such as:

* result release announcement
* admission list release announcement
* checking instructions
* official result portal
* official admission-checking portal

The underlying candidate result/admission record remains external.

---

# 39. News About Changes

News should be able to report changes such as:

* deadline extension
* screening postponement
* date change
* fee change
* new eligibility requirement
* new application route
* portal opening
* supplementary screening
* official correction
* institution disclaimer
* policy change

Where a change affects canonical StudyNexus information, the relevant canonical domain should be updated independently.

---

# 40. Rumours, Warnings and Disputes

StudyNexus may publish:

* official clarification
* institutional denial
* warning
* correction
* contextualization
* evidence-based fact check

The system should not invent a universal numerical “truth score.”

Evidence and source quality should support the determination.

---

# 41. News Trust

News trust should leverage the existing **Evidence & Data Quality Framework**.

Potential signals include:

* official source
* verified source
* corroborated
* source conflict
* updated
* correction issued
* unable to verify
* source publication date

These signals should help users assess the information without pretending that StudyNexus is infallible.

---

# 42. News Search

News should be searchable using:

* text relevance
* date
* topic
* entity
* geography
* source
* content type
* other appropriate dimensions.

Search ranking remains a separate application/search capability.

---

# 43. News SEO

News should be designed for search-engine discovery.

Meaningful stories should have:

* canonical URLs
* publication dates
* updated dates where relevant
* structured metadata
* entity relationships
* clear source attribution
* indexable content

News archives should remain accessible where they provide historical or continuing value.

---

# 44. Programmatic News SEO

Avoid generating pages merely because an event/entity relationship exists.

A canonical URL should represent meaningful user intent and useful content.

For example:

> University X Post-UTME Screening Update

may be useful.

But an automatically generated page for every individual database event is not necessarily useful.

---

# 45. Historical News

Important historical stories should generally remain available.

This is especially useful for:

* admission policy changes
* examination changes
* institutional history
* deadline extensions
* regulatory changes
* scholarship changes.

Historical News and current canonical facts must remain distinguishable.

---

# 46. News Archive vs Canonical Current State

A news story may remain historically correct even after the fact it reported has been superseded.

Example:

> “University X extended Post-UTME deadline to September 10.”

Later:

> deadline is extended again to September 15.

The original News story remains an historical report.

The Admission domain contains the current canonical deadline.

---

# 47. Authors

News should support authorship/bylines where appropriate.

Distinguish between:

* StudyNexus author
* editor/reviewer
* source organization
* quoted/credited person

Do not confuse the source organization with the StudyNexus author.

---

# 48. Editorial Workflow

Initially, a simple workflow is sufficient:

> draft → review → scheduled → published → updated/archived/retracted where required

Do not build a full newsroom-management system before the editorial operation requires it.

---

# 49. Editorial Roles

Initially, support only roles StudyNexus genuinely needs, such as:

* author
* editor/reviewer

Additional newsroom roles can be introduced later if the business requires them.

---

# 50. AI Assistance

AI may assist with:

* source extraction
* entity identification
* classification
* summarization
* change detection
* draft generation
* related-content discovery

However:

> **AI output is not authoritative.**

Factual and high-risk claims must remain subject to the established source, evidence, validation and editorial process.

---

# 51. News and Acquisition

News acquisition should respect the existing external/offline acquisition boundary:

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

Canonical domain data is not established merely because an AI agent extracted it.

---

# 52. Copyright and Source Material

StudyNexus should not become a mirror of other publishers' articles.

Where appropriate, use:

* original reporting
* original summaries
* short quotations within applicable rights
* attribution
* links to source material
* licensed/syndicated content where authorized

Source content must be handled according to applicable copyright/licensing requirements.

---

# 53. JSONB

Canonical News data should remain relational.

Do not create:

```text
news.metadata JSONB
```

as a generic escape hatch.

Potential raw/source structures and extraction payloads may use JSONB in the acquisition/source layer where appropriate.

---

# 54. Deliberate Non-Goals

This addition does not create:

* a generic Noticeboard domain
* a Post-UTME news-only system
* a candidate result database
* a candidate admission-status system
* an examination-authority operational system
* a scholarship-provider application system
* a universal misinformation/truth score
* a complete newsroom-management platform
* a user comments system inside News
* a Q&A system inside News
* a notification system owned by News
* a separate timetable system for Post-UTME

---

# 55. International Extensibility Principle

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

This principle applies to Post-UTME:

> **Institutional Admission Screening / Assessment** = broader semantic capability
> **Post-UTME** = Nigerian/source-specific terminology where applicable.

---

# 56. Resulting Conceptual Direction

The stable News model should remain relatively small:

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

The canonical information remains owned by its respective domain.

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

and News provides the time-sensitive reporting/discovery layer around it.

---

# 57. Core Product Principle

> **StudyNexus should turn education news and institutional updates into useful, trustworthy, connected information—not merely publish articles.**

> **When News reports a change to a canonical StudyNexus fact, the owning domain should contain the current fact while News preserves the historical reporting and context around the change.**

This allows StudyNexus to function simultaneously as an education information source, discovery platform and connected knowledge system without allowing News to duplicate or absorb the rest of the product.
