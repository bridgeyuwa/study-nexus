# Scholarships — Product Discovery Additions

**Status:** Approved Product Discovery Addition
**Scope:** Scholarship & Funding Opportunity Discovery, Eligibility Understanding, Matching, Trust & Application Handoff

---

## 1. Purpose

StudyNexus should provide a trusted, searchable, educational and SEO-friendly platform for discovering scholarships and related educational funding opportunities.

The product should help users understand:

> **What is this opportunity? Who is it for? What does it provide? What are the requirements? Where can I study? When do I need to apply? How do I apply? How trustworthy/current is the information?**

StudyNexus should **inform, explain, match and hand off**.

It should not become the scholarship provider's application, selection, award-management or disbursement system.

---

# 2. Scope Boundary

StudyNexus owns and may normalize:

* funding opportunity information
* scholarship information
* opportunity cycles/calls
* optional tracks/offerings
* providers and relevant organizations
* eligibility criteria
* selection information
* funding/benefit information
* application requirements
* application routes
* important dates
* destinations
* institution/programme restrictions
* geographical eligibility
* award counts where officially stated
* source/provenance
* verification/freshness
* historical opportunity information
* search/discovery
* scholarship matching
* explanatory and SEO content

StudyNexus does **not** own:

* scholarship applications
* provider applicant accounts
* application payments
* provider-side screening
* provider selection decisions
* interviews conducted by providers
* award decisions
* scholarship disbursement
* recipient management
* provider-side application status

StudyNexus may link users to official application systems and explain those processes.

---

# 3. Research Basis

Scholarship discovery research indicates that real-world scholarship platforms expose significantly more information than a simple title, sponsor, amount and deadline model.

Examples include:

* degree/education level
* study destination
* funding type
* scholarship type
* subjects
* nationalities
* deadlines
* institutions
* application documents
* selection process
* academic requirements
* geographic eligibility
* special categories
* application routes

Global Scholarships currently exposes degree, location, funding type, scholarship type, deadline, subjects and nationalities as major search dimensions.

ScholarshipAir listings commonly distinguish overview, benefits, courses, requirements, application documents, selection process, deadline and application instructions. Its current listings also demonstrate category-specific funding, programme and geographic requirements.

Opportunities Corners demonstrates further variation in host country, degree, university, funding, programme, duration and application structure.

Scholarship.com-style discovery systems demonstrate that matching can involve much wider candidate attributes, including academic, geographic, personal, financial and participation-related criteria. These attributes should inform StudyNexus discovery without being copied blindly into the canonical domain model.

**Important principle:** aggregator taxonomies are evidence of real-world user needs, not StudyNexus's canonical ontology.

---

# 4. International Extensibility Principle

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

This principle applies directly to scholarships.

For example, a Nigerian scholarship may use:

> State of Origin

while another jurisdiction may use:

> province of residence

or:

> county of citizenship.

The underlying eligibility capability should not need redesign.

---

# 5. Funding Opportunity

The broader conceptual object should be:

> **Funding Opportunity**

with scholarship as a type.

Potential future types may include:

* scholarship
* bursary
* fellowship
* grant
* sponsorship
* tuition waiver
* stipend
* other education funding opportunity

This does not require StudyNexus to support every type immediately.

The broader concept prevents `Scholarship` from becoming a Nigeria-specific or globally restrictive ontology.

---

# 6. Opportunity vs Award

StudyNexus models the **public opportunity**, not an individual student's award.

For example:

> “2027 Foundation Scholarship”

is StudyNexus information.

But:

> “Student X received ₦500,000”

is outside the current product scope.

Individual recipient and award records do not belong in the Scholarship discovery domain.

---

# 7. Funding Opportunity vs Cycle / Call

Recurring opportunities should be distinguishable from their individual application cycles/calls.

Conceptually:

```text
Funding Opportunity
    ├── 2026 Cycle
    ├── 2027 Cycle
    └── 2028 Cycle
```

Each cycle may have different:

* eligibility
* benefits
* deadlines
* participating institutions
* application route
* documents
* selection rules

Historical cycles should not be overwritten when a new cycle is published.

---

# 8. Opportunity Offerings / Tracks

A named opportunity may contain different tracks, categories, streams or pathways.

These should be representable when the differences have meaningful behavior.

For example:

```text
Scholarship Opportunity
    ├── Undergraduate Track
    └── Postgraduate Track
```

or:

```text
Scholarship Opportunity
    ├── Local Track
    └── Overseas Track
```

A track should only become a distinct modeled object when it has meaningful differences such as:

* eligibility
* funding
* destination
* institutions
* deadlines
* application process
* selection rules

A heading in a provider document alone is not enough to justify a separate entity.

---

# 9. Providers and Organizations

A funding opportunity should reference its relevant organization(s).

Possible roles include:

* provider
* sponsor/funder
* administrator
* awarding organization
* partner

One opportunity may involve multiple organizations.

StudyNexus should not assume that a scholarship necessarily has one organization with one universal role.

---

# 10. Scholarship Benefits / Funding Components

A scholarship should not be reduced to:

```text
amount
fully_funded
```

Benefits should be represented as individual components.

Examples:

* tuition
* accommodation
* stipend
* airfare
* travel
* health insurance
* books
* research expenses
* visa costs
* living allowance
* equipment
* mentorship or other non-monetary support

For example:

```text
Funding Opportunity
    ↓
Benefits
    ├── Tuition
    ├── Accommodation
    ├── Monthly Stipend
    └── Return Airfare
```

This reflects the diversity of actual scholarship awards; current ScholarshipAir examples, for instance, describe multiple funding components including tuition, books, field trips, accommodation, living expenses and travel.

---

# 11. Funding Amounts

Where a monetary amount is provided, the benefit should support appropriate attributes such as:

* amount
* currency
* frequency
* duration
* unit/coverage context

The model should distinguish:

> ₦600,000 one-time

from:

> ₦100,000 monthly for six months.

International funding must not assume NGN.

---

# 12. Full / Partial Funding

“Fully funded” and “partially funded” should be treated as useful classifications or summaries, not as the underlying source of truth.

The underlying benefits determine what the scholarship actually covers.

A scholarship should not be considered fully funded merely because an aggregator labels it that way.

---

# 13. Funding Duration vs Study Duration

Scholarship funding duration and programme/study duration are distinct.

For example:

> two-year Master's programme

may have:

> one-year scholarship funding.

These should not be conflated.

---

# 14. Renewal

A funding opportunity may be:

* one-time
* renewable
* renewable subject to conditions
* available for a defined programme duration

Renewal conditions should be preserved where the provider states them.

StudyNexus should not invent renewal rules.

---

# 15. Eligibility

Eligibility is a core structured capability.

The canonical model should **not** rely on a large set of fixed scholarship columns such as:

```text
minimum_age
maximum_age
minimum_gpa
nationality
gender
religion
major
school_year
...
```

Real scholarship opportunities use much broader and more variable criteria. Current scholarship listings demonstrate requirements spanning nationality, academic status, admission status, programme, institution, geography, documents and special categories.

---

# 16. Structured Eligibility Criteria

Eligibility should support controlled criterion types such as:

* nationality/citizenship
* residence
* geographic origin
* age
* education level
* programme
* discipline
* institution
* academic performance
* academic standing
* admission status
* current student status
* employment
* work experience
* language
* financial need
* special status
* other legitimate provider-defined criteria

The vocabulary should grow from real requirements rather than becoming an unrestricted universal schema.

---

# 17. Eligibility Logic

Eligibility must support logical composition.

Examples:

> Nigerian **AND** undergraduate

> Engineering **OR** Computer Science

> Master's **AND** (three years' experience **OR** qualifying employment)

This requires structured composition rather than a collection of independent tags.

---

# 18. Inclusion and Exclusion

Eligibility rules should support both:

> eligible for X

and:

> not eligible for X

This applies to:

* nationalities
* geographies
* institutions
* programmes
* academic states
* other applicable criteria.

---

# 19. Thresholds

Structured criteria should support comparisons such as:

> GPA ≥ 3.5

> age < 30

> minimum three years' experience

> percentage ≥ 70%

The threshold should carry the appropriate measurement/context rather than assuming everything is GPA.

---

# 20. Academic Performance

Academic performance should be represented generically enough to support:

* GPA
* CGPA
* percentage
* degree classification
* grade
* rank
* other standardized measures

The system should not assume one grading system internationally.

---

# 21. Education Level

Scholarships should connect to StudyNexus's broader education-level model.

Do not create a scholarship-only taxonomy such as:

```text
Undergraduate
Postgraduate
PhD
```

as the entire canonical model.

These are examples of education levels/usage, not the complete semantic system.

---

# 22. Discipline / Field of Study

Scholarship requirements should reuse the broader StudyNexus discipline and academic taxonomy.

A scholarship may target:

> STEM

> Engineering

> Petroleum Engineering

> a specific programme

> all fields.

Do not create a second scholarship-only field taxonomy.

---

# 23. Programme and Institution Eligibility

A scholarship may be:

> open to all qualifying institutions

> restricted to named institutions

> available only at participating institutions

> restricted to particular programmes.

These should be represented through canonical relationships and eligibility rules.

---

# 24. Admission Status

Scholarship requirements may depend on whether an applicant:

* has admission
* has applied for admission
* has received an offer
* is currently enrolled
* is a continuing student
* does not need admission yet

These conditions should be represented structurally.

Do not reduce them to a single boolean such as:

```text
admission_required = true
```

because timing and state matter.

---

# 25. Nationality, Citizenship, Residence and Origin

These must remain distinct.

For example:

> citizen of Nigeria

is not automatically equivalent to:

> resident in Nigeria

or:

> from Rivers State

or:

> currently studying in Nigeria.

StudyNexus should preserve the criterion actually stated by the provider.

---

# 26. Geographic Eligibility

Geographic eligibility should reuse the canonical StudyNexus geography model.

It should be capable of supporting:

* country
* region
* state/province
* district
* county
* locality
* other policy-relevant geographic units

without assuming Nigeria.

---

# 27. Personal Characteristics

Scholarships can contain eligibility requirements involving personal characteristics.

However, the existence of such criteria does **not** mean every characteristic exposed by an aggregator should become a universal StudyNexus field.

StudyNexus should introduce structured attributes where they are legitimate, recurring, useful, and appropriate to the product.

This avoids copying every filter from a particular market's scholarship database.

---

# 28. Financial Need

Financial need may be an eligibility criterion.

StudyNexus may represent the provider's stated financial-need requirement.

StudyNexus does not become a financial-assessment authority.

---

# 29. Professional and Work Criteria

Where required, scholarships may specify:

* years of experience
* employment status
* profession
* sector
* career stage

These should be represented as structured criteria.

---

# 30. Language Requirements

Language requirements must be modeled generically.

A requirement may include:

* language
* proficiency
* accepted test
* minimum score
* exemption
* prior-study language

Do not hard-code:

```text
requires_ielts
```

as a universal scholarship property.

International scholarships may use many different tests and proficiency systems.

---

# 31. Eligibility vs Selection

These are separate concepts.

### Eligibility

> **Can this person apply / be considered?**

### Selection

> **How does the provider choose among eligible applicants?**

Selection may involve:

* academic merit
* leadership
* community service
* motivation
* research proposal
* essay
* interview
* assessment/test

Actual scholarship listings distinguish requirements from selection processes.

---

# 32. Selection Process

StudyNexus may describe a publicly documented selection process.

Possible stages include:

> application → screening → shortlist → interview → assessment → final selection

However, StudyNexus does not operate those stages.

---

# 33. Selection Criteria

Selection criteria should remain distinguishable from minimum eligibility.

For example:

> GPA ≥ 3.0

may be an eligibility requirement.

While:

> academic excellence

may be a selection consideration.

The two must not be merged simply because both mention academic performance.

---

# 34. Application Boundary

StudyNexus provides:

> information → guidance → official application handoff.

It does not process scholarship applications.

The actual application belongs to the provider unless a separate future product decision explicitly introduces an authorized integration.

---

# 35. Application Routes

The model should support different application paths, including:

* official scholarship portal
* university application
* embassy/government application
* email submission
* participating institution
* automatic consideration through admission
* other provider-defined routes

A scholarship should not be forced into one `application_url`.

---

# 36. Scholarship ↔ Admission Relationship

Scholarship and university admission are related but distinct processes.

StudyNexus should be able to represent relationships such as:

> admission required before scholarship application

> admission application and scholarship application are separate

> apply for admission and automatically receive scholarship consideration

> admission required by a later deadline

This is particularly important because real opportunities can contain separate admission and scholarship timelines. Scholarship listings provide concrete examples of this distinction.

---

# 37. Application Requirements

Distinguish:

> **Application Requirement**

from:

> **Document Requirement**

An application can require:

* document
* essay
* personal statement
* research proposal
* assessment
* interview
* declaration
* other action

This is more expressive than a document-only checklist.

---

# 38. Conditional Requirements

Requirements may vary by:

* track
* programme
* applicant category
* destination
* other eligibility conditions

For example:

> passport required for overseas applicants only.

Current scholarship listings demonstrate conditional document requirements of this kind.

The model should support conditionality without forcing every scholarship into a rigid universal checklist.

---

# 39. Application Milestones

Do not assume there is one universal `deadline`.

Where relevant, StudyNexus should be able to represent:

* application opens
* application closes
* document deadline
* recommendation deadline
* interview period
* selection announcement
* other meaningful milestones

Only populate milestones supported by the source.

---

# 40. Timezone

Important scholarship dates should preserve the authoritative date/time context where available.

For example:

> 16:00 BST

should not silently become a Nigerian local time.

StudyNexus may provide localized conversions while retaining the authoritative time context.

---

# 41. Study Destination

Study destination is distinct from applicant eligibility.

A scholarship may support:

* study in Nigeria
* study in another country
* multiple countries
* online study
* specific universities
* no particular destination

Do not force a single `country_to_study` field.

---

# 42. Provider Location vs Study Destination

These remain distinct:

> provider location

> eligible applicant geography

> study destination

> eligible institution location

They should not be conflated.

---

# 43. Number of Awards

Where an authoritative source provides the announced number of awards, StudyNexus may represent it.

Examples:

> 100 awards

> 50 undergraduate awards

This is scholarship information, not live inventory.

StudyNexus should not infer:

> remaining awards

unless a future authoritative data source genuinely supports that information.

---

# 44. Award Categories

If award counts differ by track/category:

```text
Opportunity
 ├── Undergraduate → 50 awards
 └── Postgraduate → 20 awards
```

the count should be associated with the relevant offering rather than only the parent opportunity.

---

# 45. Historical Opportunities

Closed or expired scholarship cycles should generally not be deleted.

They may remain useful for:

* historical reference
* recurring opportunity research
* SEO
* understanding previous requirements
* comparing changes between cycles.

They must be clearly presented as historical.

---

# 46. Opportunity Status

StudyNexus may derive or present public opportunity states such as:

* upcoming
* open
* closing soon
* closed
* expired
* ongoing
* recurring
* announced

These are states of the **public opportunity/cycle**, not an individual applicant's status.

---

# 47. Trust, Verification and Freshness

Scholarship information becomes significantly more useful when users can judge how trustworthy and current it is.

Potential signals include:

* official provider
* official source
* application link verified
* deadline verified
* last checked
* source updated
* information changed
* source conflict
* unable to verify

Global Scholarships, for example, explicitly emphasizes checking and updating deadlines, awards and links, reinforcing the importance of freshness as a scholarship-discovery capability.

These signals should build on StudyNexus's broader **Evidence & Data Quality Framework** rather than create a separate scholarship trust subsystem.

---

# 48. Third-Party Scholarship Aggregators

ScholarshipAir, Opportunities Corners, Scholars4Dev, Global Scholarships, Scholarships.com and similar services are valuable **discovery and secondary evidence sources**.

They should not automatically become canonical authority.

Where available, StudyNexus should prefer the appropriate authoritative source for:

* eligibility
* award
* deadline
* application procedure
* official application destination.

Third-party data can enter the acquisition pipeline as candidate evidence.

---

# 49. Provider Authority

The scholarship provider or appropriate official administrator remains authoritative for the final interpretation of its scholarship.

StudyNexus may normalize and explain the published requirements but must distinguish:

> **StudyNexus interpretation/match**

from:

> **official provider eligibility decision**

---

# 50. Scholarship Trust and Risk Signals

Scholarship discovery should support useful evidence signals without claiming to certify that an opportunity is completely fraud-free.

Examples:

> Official provider identified

> Official application domain

> Source verified

> Application fee stated

> Source conflict

> Unable to verify

This uses evidence rather than creating an unsupported “safe scholarship” guarantee.

---

# 51. Scholarship Matching

A future StudyNexus capability should compare a user's profile against structured scholarship criteria.

For example:

> **You may match this opportunity**

The match may consider:

* education level
* programme/discipline
* geography
* nationality
* academic performance
* age
* admission status
* language
* other relevant criteria.

The system must distinguish:

> **StudyNexus match assessment**

from:

> **official scholarship eligibility decision**.

---

# 52. Match Confidence

A binary:

> Eligible / Not eligible

is often too strong.

The matching experience should eventually be capable of communicating:

* strong match
* possible match
* missing information
* appears not to match

especially when source requirements are incomplete, conditional or ambiguous.

---

# 53. Scholarship Search

Scholarship discovery should be search-first and filterable.

Potential filters include:

* opportunity type
* education level
* discipline
* destination
* applicant geography
* provider
* funding/benefit type
* deadline
* institution
* programme
* other legitimate eligibility dimensions.

These filters should be derived from canonical structured data.

Current scholarship discovery platforms demonstrate the importance of this search/filter experience.

---

# 54. SEO

Individual scholarship opportunities should have indexable pages when they represent meaningful search intent.

For example:

> MTN Foundation Scholarship 2027

The platform may also support useful aggregate/discovery pages such as:

> Scholarships for Nigerian undergraduate students

> Fully funded engineering scholarships

> Scholarships to study in the UK

However, programmatic SEO should not create thin pages for every possible combination of filters.

SEO pages are projections of canonical scholarship data.

---

# 55. Cross-Domain Relationships

Scholarships should connect naturally to the existing StudyNexus educational graph.

For example:

```text
Scholarship
    ↓
Eligible Discipline
    ↓
Programme
    ↓
Institution
```

and:

```text
Scholarship
    ↓
Study Destination
    ↓
Institution
    ↓
Programme
```

This allows scholarship discovery to connect naturally with:

* institutions
* programmes
* admissions
* geography
* examinations where relevant
* knowledge disciplines
* learning resources

---

# 56. JSONB

Canonical scholarship data should be **predominantly relational**.

The following should not be hidden inside a generic scholarship JSONB blob:

* eligibility
* benefits
* providers
* cycles
* tracks
* deadlines
* geography
* institutions
* programmes
* application requirements
* selection information

These have real semantics, relationships, validation requirements and discovery behavior.

Avoid:

```text
scholarships.metadata JSONB
```

as an escape hatch for unresolved domain decisions.

---

# 57. Source / Raw JSONB

JSONB remains appropriate in the **source/acquisition layer** for:

* raw external payloads
* provider-specific structured data
* extracted source representations
* source-specific fields not yet normalized
* replayable acquisition artifacts

This is distinct from canonical StudyNexus scholarship data.

The established boundary remains:

```text
External Source
      ↓
Immutable Raw Capture
      ↓
Extraction / Parsing
      ↓
Candidate Data
      ↓
Validation / Reconciliation
      ↓
Canonical StudyNexus Data
      ↓
Search / Presentation
```

---

# 58. Deliberate Non-Goals

This product addition does not create:

* scholarship application processing
* provider-side applicant accounts
* application payment processing
* scholarship selection management
* award decision management
* scholarship disbursement
* recipient management
* provider-side application status
* scholarship fraud certification
* an unrestricted eligibility programming language
* a giant scholarship-specific ontology
* a scholarship-only geography taxonomy
* a generic metadata JSONB escape hatch

---

# 59. Resulting Conceptual Model

The stable core should remain relatively small:

```text
Funding Opportunity
        ↓
Opportunity Cycle / Call
        ↓
Optional Offering / Track
```

with supporting concepts/relationships:

```text
Funding Opportunity
 ├── Organizations
 ├── Eligibility
 ├── Benefits
 ├── Selection Information
 ├── Application Information
 ├── Important Dates
 ├── Geography
 ├── Institutions / Programmes / Disciplines
 └── Sources / Evidence
```

Not every opportunity needs every component.

The model should represent only what the actual opportunity provides.

---

# 60. Core Scholarship Product Principle

> **StudyNexus should make scholarship and funding opportunities easier to discover, understand, compare and reach—not become the organization that awards or administers them.**

The scholarship domain should therefore optimize for:

> **trusted information + structured eligibility + useful matching + clear benefits + current deadlines + authoritative application handoff**

while keeping provider operations outside StudyNexus's ownership boundary.
