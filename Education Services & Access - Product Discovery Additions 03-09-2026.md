# Education Services & Access — Product Discovery Additions

**Status:** Approved Product Discovery Addition
**Scope:** Education-Related Service Discovery, Service Locations, Access Points, Study Mobility, Testing, Credential Services and Directions

---

# 1. Purpose

StudyNexus should help users discover **where and how they can complete education-related tasks**.

The capability should answer:

> **What do I need to do? Who provides the service? Where can I access it? What are the requirements? What does it cost? Do I need an appointment? Is the location authorized? What is the official source? How do I get there?**

StudyNexus should provide:

> **information + discovery + guidance + authoritative handoff**

It should not become the operational system of the organization providing the service.

---

# 2. Product Boundary

StudyNexus may provide information about:

* education-related service providers
* offices
* centres
* testing locations
* registration locations
* admissions/support offices
* credential services
* document authentication/evaluation services
* study-mobility services
* visa-related service locations
* biometric locations
* other relevant education-journey access points

StudyNexus does not own or operate those external services.

It does not:

* process government applications
* process examination registrations
* book appointments on behalf of providers
* manage service-provider inventory
* issue visas
* conduct credential evaluation
* authenticate documents on behalf of authorities
* make immigration decisions
* make examination decisions
* operate third-party service centres

---

# 3. Core Principle

> **Model the education-related service a learner needs to access, rather than building directories around the names of organizations or locations.**

A user generally cares about:

> **“I need to do X. Where can I do it?”**

not:

> “Which category of government office is this?”

This leads to a service-oriented discovery model.

---

# 4. Education Service Point

A broad conceptual **Education Service Point** may represent a physical or other access location through which an education-related service is provided.

Examples include:

* examination registration centre
* examination/test centre
* CBT centre
* university admissions office
* credential evaluation office
* document authentication office
* visa application centre
* biometric collection centre
* education authority office
* consular location
* international student office
* testing location

A service point is defined by its:

> **location + provider/operator + services/capabilities + authorization/applicability**

rather than merely its name.

---

# 5. Organization vs Location vs Service

These should remain distinct.

Conceptually:

```text id="s6s1e2"
Organization
      ↓
Location
      ↓
Service / Capability
      ↓
Applicability / Authorization
```

An organization may have many locations.

A location may provide multiple services.

A service may be available at many locations.

A location may provide different services at different times or under different authorizations.

---

# 6. Service

A **Service** represents an education-related task or assistance capability that a learner may need to access.

Examples may include:

* examination registration
* examination screening
* credential evaluation
* credential recognition
* document authentication
* transcript submission
* biometrics
* language testing
* admissions support
* international student support
* other legitimate education-related services

The service vocabulary should remain extensible and internationally applicable.

---

# 7. Nigerian vs International Terminology

Nigeria-specific terminology should not become universal domain assumptions.

Examples:

> JAMB CBT Centre

> Post-UTME Screening Centre

> State JAMB Office

are Nigerian/source-specific manifestations of broader concepts such as:

> Examination Registration Service Point

> Institutional Admission Screening

> Education Authority Office

International jurisdictions should be representable without redesigning the underlying model.

---

# 8. JAMB CBT Centres

JAMB CBT centres are an example of an Education Service Point.

The system should be able to represent information such as:

* centre identity
* operator
* physical location
* services offered
* examination/product applicability
* authorization/approval status
* applicable period
* contact information
* official source
* current status

Do not assume every CBT centre provides identical services.

One location may support:

> registration

while another may support:

> registration + other authorized services.

---

# 9. CBT Training / Practice Centres

A CBT training/practice centre is not automatically equivalent to an officially authorized examination/registration centre.

The distinction should remain explicit:

> **official examination/service centre**

vs.

> **training/practice facility**

A location may be one, the other, or both.

Do not infer official authorization from the presence of a CBT-related service.

---

# 10. Education Authority Offices

StudyNexus may represent relevant education authority offices and their locations.

Examples may include:

* headquarters
* regional offices
* state offices
* zonal offices
* liaison offices
* specialized service offices

However, StudyNexus should not duplicate an authority's entire internal organizational hierarchy merely to list locations.

Only organizational distinctions that matter to user discovery should be modeled.

---

# 11. Embassies and Consulates

Embassies and consulates may be relevant to education journeys, but they should not become an “education embassy” domain.

They should be represented as broader diplomatic/consular organizations and locations, with education-related services or information attached where actually applicable.

Examples may include:

* student-visa information
* consular services relevant to students
* document legalization
* education/exchange information

The service must be supported by authoritative evidence.

---

# 12. Visa Application Centres

A visa application centre should be distinguishable from the immigration authority.

Conceptually:

```text id="x1woa8"
Immigration Authority
        ↓
Authoritative immigration process

Visa Service Operator / Application Centre
        ↓
Applicant-facing physical services
```

A service centre may provide:

* biometrics
* document submission
* passport handling
* appointment services

without making the immigration decision.

StudyNexus should preserve this distinction.

---

# 13. Visa / Study Mobility

StudyNexus may support education-related mobility information under a broader concept such as:

> **Study Mobility Process**

rather than attempting to model immigration generally.

Jurisdiction-specific terminology may include:

* student visa
* study permit
* residence permit for study
* entry clearance
* other local terminology.

The underlying StudyNexus concept should remain internationally extensible.

---

# 14. Visa Requirements

Visa/study-mobility requirements vary significantly by:

* country
* applicant nationality/residence
* destination
* programme
* study duration
* age/status
* application type
* individual circumstances
* current immigration policy

Therefore, StudyNexus must **not** rely on a fixed universal schema such as:

```text
passport_required
medical_required
proof_of_funds_required
biometrics_required
```

as the complete model.

Those are examples of possible requirements, not universal requirements.

---

# 15. Structured Study-Mobility Requirements

The system should model the **meaning of a requirement** rather than the specific checklist of one country.

Conceptually:

```text id="7zq4p1"
Study Mobility Process
        ↓
Requirement
        ↓
Requirement Type
        ↓
Applicability / Conditions
        ↓
Requirement Details
```

Potential requirement types may include:

* identity document
* financial evidence
* admission evidence
* health requirement
* insurance
* biometrics
* language evidence
* criminal-record document
* accommodation evidence
* other authority-defined requirements

The controlled vocabulary should evolve from actual requirements rather than attempting to enumerate every conceivable immigration document in advance.

---

# 16. Why Requirements Must Not Be Hard-Coded

A requirement may be conditional.

Examples:

> medical examination required only for certain applicants

> additional document required for applicants from certain countries

> language evidence waived under specified circumstances

> financial evidence varies according to destination/programme/duration

> biometrics required after application submission

Therefore, the domain should support **conditional applicability** rather than a collection of universal yes/no fields.

---

# 17. Public Process Steps

StudyNexus should represent the **publicly documented steps that a learner needs to understand**.

For example:

```text id="7yej2f"
Admission
    ↓
Submit study-mobility application
    ↓
Pay required fee
    ↓
Complete biometrics
    ↓
Provide additional documents if requested
    ↓
Receive decision
```

This is sufficient for student guidance.

StudyNexus does not need to model the immigration authority's internal processing machinery.

---

# 18. Study-Mobility Process vs Government Workflow

This distinction is deliberate.

### Model:

> What the applicant needs to do.

### Do not model:

> How the government internally routes, assesses, queues, reviews and processes the case.

The external authority remains responsible for the actual process and decision.

---

# 19. External Handoff

Where an official application or appointment system exists, StudyNexus should provide a clear handoff.

Examples:

> Apply through official immigration portal

> Book biometrics through official provider

> Submit credentials through official authority

StudyNexus should not imply that completing the StudyNexus page constitutes completing the external application.

---

# 20. Appointment Requirements

StudyNexus may represent whether a service location/process is:

* appointment required
* walk-in available
* appointment recommended
* online only
* other source-defined process

This is useful for planning.

StudyNexus does not book the appointment.

---

# 21. Service Eligibility

Where useful, StudyNexus may explain who can access a service.

Examples:

* applicants in a particular jurisdiction
* applicants using a specific visa category
* candidates registered for a specific examination
* students with an admission letter
* applicants from a specific country/residence category

Service eligibility is informational.

StudyNexus does not make the provider's final eligibility decision.

---

# 22. Service Requirements

A service may require:

* passport
* admission letter
* transcript
* identification
* appointment confirmation
* photograph
* proof of funds
* other documents.

Requirements should reuse broader StudyNexus requirement/document concepts where appropriate rather than creating service-specific duplicate structures.

---

# 23. Service Fees

Where a service has an authoritative fee, StudyNexus may represent:

* amount
* currency
* fee type
* applicable service/category
* applicable period
* source

Currency must not default to NGN.

The fee shown should be attributed to the appropriate provider/authority and period.

---

# 24. Processing Times

Where an authority publishes a standard or expected processing time, StudyNexus may report it.

Distinguish:

> **published/standard processing time**

from:

> **actual user processing time**

StudyNexus must not promise an outcome or guarantee a processing duration.

---

# 25. Service Location Information

A physical service point may contain:

* name
* organization/operator
* country
* region
* city
* address
* building/location details where useful
* service capabilities
* applicable jurisdiction
* opening hours
* appointment requirement
* accessibility information where available
* official website
* contact channels
* authorization/status
* source
* verification/freshness information.

Not every location requires every attribute.

---

# 26. Opening Hours

Opening hours may be represented where reliably available.

Because hours can change, they must be treated as time-sensitive information with appropriate source and freshness context.

StudyNexus should avoid presenting stale opening hours as authoritative.

---

# 27. Authorization and Approval

Some service locations depend on formal authorization.

Examples:

> approved examination centre

> authorized testing centre

> approved biometric location

> accredited/authorized service provider.

Authorization should be represented where relevant.

Do not infer authorization merely because a location is listed by a third party.

---

# 28. Authorization History

Where the service depends on current approval, historical authorization should be preserved where authoritative information supports it.

For example:

```text id="t28s4x"
Authorized:
2026-01-01 → 2026-12-31
```

This prevents an old centre from appearing perpetually authorized.

---

# 29. Service Availability

StudyNexus may represent whether a service is currently:

* available
* unavailable
* temporarily suspended
* closed
* seasonal
* registration-required
* otherwise source-defined.

Availability must be distinguished from provider inventory.

StudyNexus does not own the underlying capacity.

---

# 30. Capacity

Do not create generic:

> `capacity`

or:

> `remaining_slots`

fields for all education service points.

Capacity belongs to the external operator where it actually exists.

StudyNexus may report authoritative availability information where appropriate without becoming the inventory system.

---

# 31. Directions and Maps

Directions are a legitimate StudyNexus capability for physical education service locations.

Users should be able to:

* view a location
* see it on a map
* obtain directions
* understand nearby landmarks/transit information where available.

The route calculation itself may be provided by external mapping infrastructure.

StudyNexus is providing **location discovery**, not becoming a general-purpose mapping platform.

---

# 32. Location-Aware Discovery

Users should eventually be able to ask:

> JAMB registration centres near me

> IELTS test centres in Lagos

> biometric collection locations near Abuja

> credential evaluation offices near me.

Location-aware discovery must follow StudyNexus's existing location principles.

Explicitly selected user location should take precedence over silent IP-derived assumptions for consequential results.

---

# 33. “Nearest” Is a Derived Result

Nearest location should be calculated from current/selected location information.

It should not be stored as a permanent property of a service location.

---

# 34. Contact Channels

StudyNexus should use a generalized **Contact / Communication Channel** concept rather than treating all contact information as equivalent.

Potential channel types include:

* website
* phone
* email
* Facebook
* X
* Instagram
* WhatsApp
* other official or relevant communication channels.

---

# 35. Official vs Third-Party Contact

This distinction is mandatory.

A contact channel must be capable of identifying its relationship to the organization.

For example:

```text id="b6ng97"
Facebook
Authority: Official
Source: Organization's official website
Verified: Yes
```

versus:

```text id="ym7r25"
Facebook
Authority: Third-party
Source: Directory / community listing
Verified: No
```

Both may point to real pages, but they must not be presented as equivalent.

---

# 36. Contact Purpose

Where useful, a contact channel should indicate its purpose.

Examples:

> general enquiries

> admissions

> international students

> visa applications

> examination registration

> technical support.

This is more useful than an undifferentiated list of phone numbers and social links.

---

# 37. Contact Freshness

Contact details can become stale.

StudyNexus should preserve appropriate source and verification/freshness information.

An old phone number should not remain visually equivalent to a recently confirmed official contact without context.

---

# 38. Organization vs Service Operator

The organization responsible for a service may differ from the organization operating the physical location.

StudyNexus should support the distinction where useful.

For example:

```text id="ahf1fr"
Authority
    ↓
owns/controls process

Service Operator
    ↓
provides applicant-facing service
```

This is especially important for:

* visa application centres
* outsourced testing centres
* third-party education services.

---

# 39. International Study Services

The capability should be able to connect multiple organizations and locations around a student's international study journey.

For example:

```text id="ukq3ml"
University
    ↓
Admission
    ↓
Immigration / Study Mobility Authority
    ↓
Visa Application Centre
    ↓
Biometrics
    ↓
Travel
```

StudyNexus provides information and navigation between these points.

It does not become the transaction operator.

---

# 40. Credential and Document Services

StudyNexus may eventually support information about:

* credential evaluation
* qualification recognition
* document authentication
* legalization
* apostille
* transcript verification
* equivalence services
* other education-related document services.

These should remain distinct service concepts rather than being collapsed into “visa services.”

---

# 41. Credential Evaluation vs Authentication

These should remain conceptually distinct.

> **Evaluation/recognition:** determines or describes the academic comparability/recognition of a qualification.

> **Authentication:** establishes that a document/signature/origin is valid according to the applicable process.

A student may need one, the other, or both.

---

# 42. Search by Task

One of the strongest potential StudyNexus experiences is task-oriented discovery.

Users should eventually be able to search:

> register for UTME

> take IELTS

> submit biometrics

> authenticate my degree

> evaluate my qualification

> apply for student visa

StudyNexus can return:

> service → provider → location → requirements → dates → official source → directions/handoff.

This is more useful than requiring users to know the name of the organization first.

---

# 43. Service Search by Location

Service discovery should support:

> location + service

rather than only:

> location + organization.

For example:

> IELTS centres in Lagos

> biometric services in Abuja

> JAMB registration centres in Kaduna

> credential evaluation services for Canada.

---

# 44. SEO

Meaningful service/location information should be indexable where there is genuine user intent.

Examples:

> JAMB CBT Centres in Abuja

> IELTS Test Centres in Lagos

> UK Student Visa Application Centres in Nigeria

> Credential Evaluation Services for Nigerian Students

Do not create thin SEO pages for every appointment slot, room, or incidental database relationship.

---

# 45. SEO vs Directory Rows

The existence of a database record does not automatically justify an indexable page.

SEO pages should represent:

> meaningful user intent + useful information.

This protects the platform from large amounts of thin programmatic content.

---

# 46. Source and Evidence

Service information should follow the StudyNexus source/evidence architecture.

Important facts such as:

* authorization
* opening hours
* service availability
* contact information
* fees
* requirements
* official URLs

should be traceable to appropriate sources.

---

# 47. Third-Party Directories

Third-party directories can be valuable discovery sources.

They should not automatically establish:

> official status

> current authorization

> official contact

> current opening hours.

They enter the normal acquisition/evidence process.

---

# 48. Official Source Priority

The authoritative source depends on the type of fact.

Examples:

> examination authority for centre authorization

> immigration authority for visa requirements

> university for admissions-office information

> testing provider for test-centre rules

> credential authority for recognition requirements.

There is no universal source hierarchy that applies identically to every service.

---

# 49. Changes and Freshness

Service information may change.

StudyNexus should be able to preserve revisions such as:

> centre moved

> centre no longer authorized

> opening hours changed

> service suspended

> visa application centre changed operator

> application procedure changed.

Current state and historical state should remain distinguishable.

---

# 50. Education Service Alerts

A service-related change can generate a News/Update item.

For example:

> “JAMB removes Centre X from approved CBT list.”

The canonical service/location information should be updated independently, while News records the announcement/report.

This follows the core News principle:

> **News reports changes; the owning domain maintains the current fact.**

---

# 51. Notifications

Education Service information may eventually trigger notifications where users follow:

* a service
* a location
* an institution
* an examination
* an international-study destination.

Notifications remain a cross-cutting application capability rather than part of Education Services itself.

---

# 52. JSONB

Canonical Education Service data should be predominantly relational.

Do not create a generic:

```text id="lqa8z2"
service_location.metadata JSONB
```

as an escape hatch.

Core concepts such as:

* organization
* location
* service
* authorization
* contacts
* requirements
* fees
* applicability

have meaningful semantics and should be modeled explicitly.

Raw provider/source payloads may use JSONB within the acquisition/source layer.

---

# 53. Deliberate Non-Goals

This addition does not create:

* a government-service processing platform
* an examination registration system
* an appointment-booking platform
* a visa application system
* an immigration case-management system
* a credential evaluation service
* a document authentication authority
* a general-purpose mapping platform
* a generic business directory
* a Nigeria-only office/centre directory
* a universal visa rules engine
* a provider inventory-management system.

---

# 54. International Extensibility Principle

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

This principle applies directly to Education Services & Access:

> **Education Service Point** is the broader semantic capability.

> **JAMB CBT Centre**, **JAMB Office**, **Visa Application Centre**, **Embassy/Consulate**, **Biometric Centre**, **Credential Evaluation Office**, and similar terms are jurisdiction/provider-specific manifestations of broader organization, location and service concepts.

Likewise:

> **Student Visa**, **Study Permit**, **Residence Permit for Study**, or other local terminology may represent jurisdiction-specific forms of a broader **Study Mobility Process**.

---

# 55. Resulting Conceptual Direction

The stable conceptual surface should remain small:

```text id="8umzro"
Organization
      ↓
Location
      ↓
Service / Capability
      ↓
Applicability / Authorization
```

with supporting information:

```text id="1u7m2m"
Service
 ├── Requirements
 ├── Fees
 ├── Process Information
 ├── Important Dates
 ├── Contact Channels
 └── Official Sources / Evidence
```

And for study mobility:

```text id="9b4x5r"
Study Mobility Process
      ↓
Public Process Steps
      ↓
Requirements
      ↓
Service Points
      ↓
Official Handoff
```

The system deliberately stops at the point where the external provider takes over.

---

# 56. Core Product Principle

> **StudyNexus should help learners discover and navigate the education-related services they need—who provides them, where they are available, what they require, when they are available, and where to continue through the official channel—without becoming the operator of those services.**
