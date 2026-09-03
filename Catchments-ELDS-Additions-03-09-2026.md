# Catchment / ELDS — Product Discovery Additions

**Status:** Approved Product Discovery Addition
**Scope:** Admissions, Geographic Policy & International Extensibility

---

## 1. Purpose

StudyNexus should represent geographic admission-policy information where it helps users understand how an institution or programme's admission policy applies to candidates from different geographic areas.

This includes Nigerian concepts such as:

* Catchment Area
* Educationally Less Developed States (ELDS)

These are **not standalone examination or institution-management systems**. They are information and policy concepts used to explain and support admission discovery.

StudyNexus should model the underlying meaning of these concepts while preserving the terminology used by the relevant authority or policy.

---

# 2. International Extensibility Principle

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

---

# 3. Catchment

## 3.1 Definition

Catchment Area should be understood as:

> **An admission-policy designation identifying geographical areas whose candidates may receive specified consideration under an applicable admission policy.**

The geographical area may be a state, region, district, locality, or another recognized geographic unit depending on the applicable policy.

Catchment must not be interpreted merely as:

> geographic areas physically close to an institution.

---

## 3.2 Catchment is not an Institution Attribute

Catchment should not be represented as a permanent property such as:

```text id="6n8q71"
institution.catchment_states
```

An institution may have different admission policies across programmes, campuses, admission cycles, or other contexts.

Catchment belongs to the **applicable admission-policy context**.

Conceptually:

```text id="2w5g3c"
Institution
    ↓
Programme / Programme Instance
    ↓
Admission Policy
    ↓
Geographic Admission Consideration
    ↓
Geographic Areas
```

---

## 3.3 Catchment Scope

A catchment rule may apply at the level actually established by the authoritative policy, such as:

* institution
* campus
* programme
* programme instance/admission context

The system must not assume that every programme or campus has the same catchment rule.

---

## 3.4 Candidate Geographic Basis

Catchment should not automatically be interpreted against the candidate's current residence.

The applicable policy should determine the geographic attribute being used, such as:

* state of origin
* place of residence
* another defined geographic identity

StudyNexus should preserve which candidate geographic attribute the rule actually uses.

---

## 3.5 Catchment Effect

Catchment identifies policy applicability. It does **not** inherently mean:

* automatic eligibility
* lower cut-off
* guaranteed admission
* admission preference
* reserved admission place

The actual effect must come from the applicable admission policy.

StudyNexus should represent the stated policy rather than infer an effect from the existence of a catchment classification.

---

# 4. ELDS

## 4.1 Definition

ELDS should be represented as a jurisdiction-specific instance of a broader concept:

> **Geographic Admission Classification**

In the Nigerian context, the relevant classification may be:

> **Educationally Less Developed States (ELDS)**

ELDS should therefore not become a universal top-level StudyNexus domain concept.

---

## 4.2 ELDS is not a Permanent Property of a Geographic Area

StudyNexus should not treat:

```text id="p7l8z5"
State X = permanently ELDS
```

as universal truth.

Instead:

> State X is included in an ELDS classification under a specified jurisdiction, policy and applicable period.

This preserves historical and policy context.

---

## 4.3 ELDS and Admission Policy

The ELDS classification and its admission treatment should remain separate.

Conceptually:

```text id="9q5h2j"
Geographic Admission Classification
    ↓
ELDS
    ↓
Geographic Areas
```

while separately:

```text id="s8v3y2"
Admission Policy
    ↓
ELDS Treatment / Rule
```

This prevents the system from confusing:

> **being classified as ELDS**

with:

> **the admission treatment granted to candidates from an ELDS area.**

---

## 4.4 ELDS Does Not Automatically Mean Preference

StudyNexus must not infer an admission benefit solely because a candidate falls within an ELDS classification.

The applicable policy may establish:

* additional consideration
* allocation
* ranking treatment
* threshold treatment
* another admission-policy effect

or a different treatment altogether.

StudyNexus should represent only what the authoritative policy establishes.

---

## 4.5 ELDS Does Not Automatically Change Cut-Offs

An ELDS classification must not trigger an automatic calculation such as:

```text id="nq4zj1"
ELDS candidate
→ lower cutoff
```

If an authoritative admission policy specifies an ELDS-specific cut-off or threshold, that becomes an explicit admission-policy rule and should remain connected to the appropriate versioned cut-off information.

---

## 4.6 ELDS Does Not Automatically Determine Eligibility

The system must not infer:

> ELDS = eligible

or:

> non-ELDS = ineligible.

ELDS is only one possible component of an admission policy.

---

# 5. Geographic Admission Classification

The broader model should support multiple jurisdiction-specific geographic admission classifications.

Conceptually:

```text id="s4uw2m"
Geographic Admission Classification
        ↓
Classification Type
        ↓
Geographic Areas
```

Nigeria may use:

> ELDS

Other jurisdictions may have different classifications or terminology.

The underlying model should therefore not encode Nigerian assumptions such as:

> `elds_state_id`

as a universal concept.

---

# 6. Geographic Admission Consideration

Catchment and similar geographic admission considerations should likewise be represented through an internationally extensible semantic structure.

Conceptually:

```text id="47xmwk"
Admission Policy
      ↓
Geographic Admission Consideration
      ↓
Type / Official Classification
      ↓
Geographic Areas
```

Catchment is one possible Nigerian/source-specific manifestation.

This leaves room for international equivalents such as regional preference, local-area consideration, district allocation, territorial preference, or other jurisdiction-specific policies without redesigning the underlying domain.

---

# 7. Geographic Areas

Catchment and geographic admission classifications should reference StudyNexus's canonical geographic model rather than duplicating names in admission records.

The model should be able to support geographic units appropriate to the jurisdiction, such as:

* country
* region
* state/province
* district
* county
* municipality
* locality
* other recognized administrative or policy areas

The system should not assume that every geographic admission rule is based on Nigerian states.

---

# 8. Overlap Between Classifications

A geographic area may simultaneously belong to:

* a Catchment classification
* an ELDS classification
* another policy classification

No universal exclusivity rule should be imposed.

For example:

```text id="7oepj4"
Geographic Area X
    ├── Catchment classification
    └── ELDS classification
```

The applicable admission policy determines how each classification is treated.

---

# 9. Catchment and ELDS Are Distinct

Catchment and ELDS must remain separate concepts even where they reference the same geographic areas.

They answer different questions:

> **Catchment:** Is this geographic area included in the applicable catchment designation?

> **ELDS:** Is this geographic area included in the applicable ELDS classification?

Their practical admission effects must be modeled separately.

Do not collapse them into a generic user-facing or domain concept such as:

> “special geographic preference.”

---

# 10. Programme-Level Applicability

The system must support geographic admission rules being associated with a particular programme or admission context rather than assuming institution-wide applicability.

This is particularly important because admission criteria may be established at programme level.

The relationship should therefore permit:

```text id="2g40aj"
Programme / Programme Instance
        ↓
Admission Policy
        ↓
Geographic Admission Rule
```

rather than forcing every institution to have a single universal catchment/ELDS record.

---

# 11. Campus Applicability

Where authoritative policy distinguishes campuses, the policy should be able to reflect the applicable scope.

However, the implementation should not introduce additional campus-specific complexity unless real authoritative data requires it.

The guiding principle is:

> **Allow the semantic possibility without building speculative machinery.**

---

# 12. Affiliates and Inheritance

Catchment or ELDS rules should **not automatically inherit** from:

* a parent institution
* an affiliated institution
* another campus
* another programme

unless the authoritative policy establishes that relationship.

This prevents accidental propagation of admission rules.

---

# 13. Institutional Ownership

Institution ownership type such as:

* federal
* state
* private
* other

should remain institution data.

Ownership must not automatically determine:

* whether catchment exists
* whether ELDS applies
* what a geographic admission rule means
* what practical admission treatment is provided

Those are policy facts.

---

# 14. Policy Period and Versioning

Catchment and ELDS classifications and their applicable admission treatment should be associated with the relevant policy period.

Depending on the jurisdiction, this may be:

* admission year
* admission cycle
* academic session
* policy effective period
* another authoritative period

The implementation should not assume that every international jurisdiction uses the same yearly cycle.

Historical classifications and policy changes should remain traceable rather than overwritten.

---

# 15. Source Authority and Evidence

Catchment and ELDS information must be evidence-driven.

The applicable authoritative source should be preserved, including where useful:

* authority
* source document
* source version
* publication date
* applicable policy period
* relevant section/page or source anchor
* source terminology

Third-party lists may be used as discovery/evidence candidates, but should not automatically become canonical StudyNexus data.

---

# 16. Conflicting Sources

If two sources provide conflicting Catchment or ELDS information, StudyNexus should use the existing evidence, reconciliation and data-quality process rather than silently taking the latest scraped value.

Unresolved conflicts should remain identifiable rather than being converted into false certainty.

---

# 17. User Experience

Where sufficient authoritative data exists, StudyNexus may explain whether a user's selected geographic attribute falls within an applicable classification.

For example:

> **Catchment:** Your selected State of Origin is included in this programme's stated catchment area.

or:

> **ELDS:** Your selected State of Origin is included in the applicable ELDS classification.

The system should avoid presenting this as:

> You qualify for admission.

or:

> You will receive preferential admission.

unless the complete applicable policy explicitly supports that conclusion.

---

# 18. Discovery and Filtering

Catchment and ELDS may eventually be exposed as discovery/filter criteria.

Examples:

> Programmes where catchment consideration applies.

> Programmes where ELDS consideration applies.

These should be derived from canonical admission-policy data.

The filters must not imply:

> easier admission

unless that is explicitly supported by the relevant admission policy.

---

# 19. Explanatory and SEO Content

Catchment and ELDS can support explanatory and SEO-friendly educational content.

Potential examples:

> What is a Catchment Area in University Admissions?

> What does ELDS mean for admission?

> Does my State of Origin fall within this university's catchment area?

Such pages should be generated from authoritative policy information where factual policy claims are involved.

A useful explanatory page does not require Catchment or ELDS to become independent top-level domains.

---

# 20. JSONB

Canonical Catchment and ELDS information should be **relational**.

These concepts have meaningful:

* relationships
* geographic references
* policy scope
* temporal applicability
* evidence
* discovery behavior

and therefore should not be hidden inside generic JSONB metadata.

For example, canonical data should not use:

```text id="m6cf02"
institution.catchment_states JSONB
institution.elds_states JSONB
```

Raw external payloads and source-specific acquisition structures may use JSONB where appropriate, under the established source/acquisition boundary.

---

# 21. Deliberate Non-Goals

This addition does not create:

* an admissions decision engine
* an admissions allocation engine
* an institution's internal quota system
* candidate application processing
* candidate registration
* automatic admission guarantees
* a universal Nigerian admission-policy algorithm
* a permanent national ELDS property on geographic entities
* a permanent catchment property on institutions
* a separate standalone ELDS domain
* a separate standalone Catchment domain

StudyNexus provides **trusted information and discovery around these policies**, not the institutional admission operation itself.

---

# 22. Resulting Conceptual Direction

The resulting model should remain small:

```text id="80h0pw"
Institution
    ↓
Programme / Programme Instance
    ↓
Admission Policy
    ├── Geographic Admission Consideration
    │      └── Catchment
    │
    ├── Geographic Admission Classification
    │      └── ELDS
    │
    ├── Cut-off / Threshold Rules
    └── Other Admission Requirements
```

Both Catchment and ELDS ultimately reference canonical geographic areas:

```text id="wjbm0v"
Geographic Admission Rule / Classification
              ↓
       Geographic Area
```

The **classification/designation** is kept separate from the **admission treatment**.

---

# 23. Core Product Principle

> **StudyNexus should tell the user what the applicable admission policy says about geographic classifications and considerations, without pretending to make the admission decision itself.**

This keeps Catchment and ELDS useful, evidence-backed, internationally extensible, and appropriately scoped while avoiding unnecessary admissions-system architecture.
