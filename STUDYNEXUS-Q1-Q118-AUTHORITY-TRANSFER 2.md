# StudyNexus — Q1–Q118 Authority Transfer

## Preservation / Continuation Handoff

**Purpose:** Lossless continuation of the product/domain/architecture decision work without restarting the questionnaire or inferring user approval from assistant recommendations.

**Important limitation:** Q1–Q60 are recovered from the visible session; Q61–Q85 are now explicitly supplied by the user as final choices in this continuation; Q86–Q98 are recovered from the later final-lock artifact; Q99–Q118 remain not recovered. For Q61–Q85, the original question text and detailed qualification text were not supplied in the latest user message, so the package records the exact user choices without inventing semantic meanings for the letter choices.

**Current source corpus:** `STUDYNEXUS-V4.6-REMEDIATED-PACKAGE (1).zip`

**Preserved copy:** `/mnt/data/transfer/STUDYNEXUS-V4.6-SOURCE-CORPUS.zip`

**Source-corpus manifest:** `/mnt/data/transfer/STUDYNEXUS-V4.6-SOURCE-MANIFEST.txt`

**Archive size:** 919,142 bytes

**ZIP entries:** 63 total entries, 57 non-directory files

**Archive SHA-256:** `4d5fd029fdce06e8edfc21922c5571ab090de170b10b44f11876ea43a3636f69`

---

# 1. Authority Rules

1. The **latest explicit user decision wins**.
2. Assistant recommendations are not decisions unless the user explicitly accepted them.
3. A later user answer can supersede an earlier answer.
4. Historical audit reports are evidence, not authority.
5. If a decision cannot be recovered with adequate confidence, mark it **NOT RECOVERED / UNRESOLVED**. Do not infer.
6. The next session must not restart the questionnaire merely because a Q number is marked NOT RECOVERED.
7. The next session should first use any newly available transfer/source artifact to recover missing evidence before asking anything.
8. Archive/historical StudyNexus artifacts must not be silently rewritten as current truth.

---

# 2. Q1–Q60 — Recovered From The Visible Session

All Q1–Q60 were explicitly answered by the user in this session. The “Final answer” below is the user's decision, not the assistant recommendation.

## Q1
**Original question:** What exactly should V1 programme search filter by?

**Final answer:** V1 facets are Discipline, Award level, State/Location, Admission status, Ownership, Delivery mode, and Country; Country is merged into a single hierarchical location facet (Country → State), not a separate unrelated facet.

**Exact semantic meaning:** Instance-scoped facets (State, Delivery mode, Admission status, Country) must evaluate against the same ProgrammeInstance. Programme-scoped facets (Discipline, Award level) and Institution-scoped facets (Ownership) do not.

**Superseded:** No.

**Status:** FROZEN.

**Dependencies:** Q3/Q21/Q24/Q49/Q60; search projection and Typesense contracts.

## Q2
**Original question:** What should “Admission Status” mean/display on a Programme result?

**Final answer:** No bare “Open.” If filter context resolves to one instance, show that instance’s status directly (e.g. “Open at Lagos”). If multiple instances remain unresolved, use per-instance badges or a count such as “Open at 2 of 3 locations.”

**Exact semantic meaning:** Programme-level admission status is contextual/aggregated; it must not conceal the ProgrammeInstance boundary.

**Status:** FROZEN.

## Q3
**Original question:** What should happen when the user filters by State + Admission Status?

**Final answer:** C — the same ProgrammeInstance must satisfy both. The user later refined the presentation: non-matching-but-open-elsewhere programmes must not contaminate primary results.

**Superseded:** Q22 supersedes the UI suggestion of a second “Open elsewhere” result section, but not the same-instance query semantics.

**Status:** FROZEN.

## Q4
**Original question:** What tuition should appear on a search result after filtering?

**Final answer:** Compute over matching instances only. One match → exact value, no “From.” Multiple matches → range only when comparability rules are met; mixed currency defers to the mixed-currency rule.

**Superseded:** Q19 and Q23 refine this. Numeric range requires same currency AND same period; instance-level filtering may hide tuition when a safe context-specific value cannot be computed.

**Status:** FROZEN.

## Q5
**Original question:** What is the V1 tuition time basis?

**Final answer:** Add a period field, store it from source, never normalize/annualize.

**Important supersession:** Q16 later clarified that period must NOT be placed inside MonetaryAmount. It belongs on ProgrammeInstance as `tuition_period`.

**Status:** FROZEN after Q16.

## Q6
**Original question:** Should the V1 Programme model have a Programme-level admission state at all?

**Final answer:** C — both Programme lifecycle and ProgrammeInstance applicant-facing availability exist, but mean different things.

**Later refinement:** Q20 formally separates lifecycle from applicant-facing admission and removes Programme-level `suspendAdmission()` / `resumeAdmission()` semantics.

**Status:** FROZEN after Q20.

## Q7
**Original question:** What is actually V1 for Scholarships?

**Final answer:** B — scholarship entity/admin/related content only; public discovery is Phase 2.

**Dependencies:** Q28/Q29/Q52/Q53.

**Status:** FROZEN.

## Q8
**Original question:** What should the canonical Discipline URL be?

**Final answer:** C — `/programmes/{discipline}` for curated/indexable discipline landing pages; arbitrary facet combinations use query parameters and are noindex.

**Status:** FROZEN.

## Q9
**Original question:** What should “Ownership” mean in V1?

**Final answer:** A — use canonical OwnershipType.

**Meaning:** Federal/State jurisdiction is a separate future concept, not folded into OwnershipType.

**Status:** FROZEN.

## Q10
**Original question:** What is “Study Mode” / Full-time vs Part-time?

**Final answer:** A — remove Full-time/Part-time from V1 and treat it as a future separate concept. V1 DeliveryMode remains OnCampus/Online/Hybrid.

**Status:** FROZEN.

## Q11
**Original question:** How should multiple ProgrammeInstances be presented on Programme Detail?

**Final answer:** E — hybrid selector + detail panel.

**Qualification:** Default selection rule was initially unresolved and later locked in Q44.

**Status:** FROZEN after Q44.

## Q12
**Original question:** What should happen when tuition is known but currencies differ?

**Final answer:** Search card: “Tuition varies by currency.” Detail page: list all currency/amount pairs. No FX conversion.

**Status:** FROZEN; Q19 later adds period comparability.

## Q13
**Original question:** What happens when a Programme is published but has zero published ProgrammeInstances?

**Final answer:** B — it exists internally but is excluded from public search and sitemap.

**Status:** FROZEN.

## Q14
**Original question:** What happens if Typesense is unavailable?

**Final answer:** C — basic text search survives through PostgreSQL; advanced/nested facets degrade. Show a visible degraded-mode/system banner distinct from legitimate zero results.

**Later refinement:** Q33 specifies exactly which non-instance facets may remain functional and that unsupported filters are disabled.

**Status:** FROZEN after Q33.

## Q15
**Original question:** What trust signal should V1 show?

**Final answer:** B — Source + Last verified + Freshness only; no “Verified by StudyNexus” badge.

**Later refinements:** Q32 and Q59 govern conflicts and unresolved fields.

**Status:** FROZEN after Q59.

## Q16
**Original question:** Should period belong inside MonetaryAmount?

**Final answer:** No. MonetaryAmount remains amount + currency only. Add `ProgrammeInstance.tuition_period` separately.

**Supersedes:** Earlier Q5 placement ambiguity.

**Status:** FROZEN.

## Q17
**Original question:** What does “verbatim from source” mean for tuition period?

**Final answer:** C — canonical controlled period classification + raw source wording preserved in provenance.

**Status:** FROZEN.

## Q18
**Original question:** What if source tuition cadence is incoherent?

**Final answer:** C — store tuition only when the source gives a coherent single amount/period; otherwise flag for review.

**Status:** FROZEN.

## Q19
**Original question:** When is a tuition range valid after adding period?

**Final answer:** A — only when currency AND period match and both amounts are valid. NULL period never ranges with a known period.

**Status:** FROZEN.

## Q20
**Original question:** What are the Programme lifecycle states vs ProgrammeInstance admission states, and what happens to suspend/resume methods?

**Final answer:** Programme lifecycle: Prospective / Active / Discontinued, optionally Suspended for editorial reasons. ProgrammeInstance applicant-facing availability: Not yet open / Open / Closed / Suspended. Remove `suspendAdmission()` / `resumeAdmission()` from Programme aggregate; applicant-facing controls belong on ProgrammeInstance.

**Status:** FROZEN.

## Q21
**Original question:** What aggregate admission labels should a Programme show?

**Final answer:** “X/Y currently accepting” / “Not currently accepting” / “No current published offering”. Denominator = published ProgrammeInstances only.

**Status:** FROZEN.

## Q22
**Original question:** How should “Open elsewhere” be presented?

**Final answer:** Do not blend non-matches into primary results. If a programme matches for other reasons, show a contextual hint on its card. If the primary result set is empty, a separate subordinate “related/expand” affordance is acceptable; do not create a second peer-level results section.

**Supersedes:** The UI portion of Q3.

**Status:** FROZEN.

## Q23
**Original question:** Can static Programme `tuition_min/max` safely represent filtered instance tuition?

**Final answer:** B — hide tuition on search cards when instance-level filters are active unless exactly one instance matches; show exact value for one match and use Programme Detail for full context.

**Status:** FROZEN.

## Q24
**Original question:** Does the same context rule apply to admission status?

**Final answer:** Yes. Filtered context states the specific instance; unfiltered context uses the approved aggregate.

**Status:** FROZEN.

## Q25
**Original question:** Which ProgrammeInstance fields are safe to aggregate at Programme level?

**Final answer:** Safe: number of offerings, number currently accepting, available delivery modes, available locations, and academic years (listed, never blended into one value). Conditional: tuition and cut-off. Never silently aggregate: requirements, eligibility, or instance-specific policy.

**Status:** FROZEN.

## Q26
**Original question:** How should Location be modeled globally?

**Final answer:** D — generic semantic hierarchy Country → Administrative Area → City with country-aware UI labels.

**Important qualification:** This is a semantic abstraction; it does NOT require redesigning the V4.6 physical schema for V1.

**Status:** FROZEN.

## Q27
**Original question:** Should Country and State/Administrative Area be hierarchical in the UX?

**Final answer:** Yes — drill-down Country then Administrative Area.

**Status:** FROZEN.

## Q28
**Original question:** What scholarship references can appear on Programme Detail?

**Final answer:** A — contextual references only, gated on the same completeness/conflict-resolution trust bar; omit otherwise.

**Status:** FROZEN.

## Q29
**Original question:** What is the relationship between MVP and FVS?

**Final answer:** FVS ⊂ MVP.

**Meaning:** FVS is the first end-to-end vertical; MVP is the broader release scope.

**Status:** FROZEN.

## Q30
**Original question:** Should location landing pages such as `/programmes/nigeria` exist in V1?

**Final answer:** No. Defer until justified by content/traffic.

**Status:** FROZEN.

## Q31
**Original question:** How should Ownership be displayed and what happens to jurisdiction?

**Final answer:** Show canonical OwnershipType only: Public / Private / PPP / Religious. No Federal/State facet in V1.

**Status:** FROZEN.

## Q32
**Original question:** What should happen when canonical sources conflict?

**Final answer:** D — admin resolves before public display; provenance retains the conflict for audit.

**Status:** FROZEN.

## Q33
**Original question:** What should the filter UI do when Typesense is down?

**Final answer:** B — disable unsupported filters and show “Advanced filters temporarily unavailable”. Never show approximate results for exact filters.

**Status:** FROZEN.

## Q34
**Original question:** What should V1 search relevance prioritize?

**Final answer:** exact programme name → phrase/prefix → discipline → institution name → other fields; typo tolerance after exact/strong matches. No popularity score without real behavior data.

**Status:** FROZEN.

## Q35
**Original question:** Should search relevance determine SEO landing-page ordering?

**Final answer:** No — SEO landing pages use deterministic editorial/content ordering.

**Status:** FROZEN.

## Q36
**Original question:** What performance targets should be frozen?

**Final answer:** LCP ≤ 2.5s, INP ≤ 200ms, CLS ≤ 0.1 as acceptance targets, not architectural invariants; measured on representative mid-range mobile hardware and throttled network.

**Status:** FROZEN.

## Q37
**Original question:** What accessibility standard and test strategy should be used?

**Final answer:** B — WCAG 2.2 AA + automated tests for critical FVS flows now; scheduled manual audit later. Critical flows: search, filter, select instance, read admission information, Programme → Institution navigation. Automated checks include keyboard access, labels, focus, contrast where tooling permits, semantic headings, and form errors.

**Status:** FROZEN.

## Q38
**Original question:** Should active Flux v1 references be replaced?

**Final answer:** Yes. Flux Pro v2 is required. Treat active-tier Flux v1 references as stale; preserve historical v1 references only in archive/audit material.

**Status:** FROZEN.

## Q39
**Original question:** What is the canonical mental model of a Programme page?

**Final answer:** “A Programme page describes the academic programme; the user selects a concrete ProgrammeInstance to see the applicable location, delivery mode, tuition, admission availability, cut-off, and requirements.”

**Status:** FROZEN.

## Q40
**Original question:** What should the FVS allow the user to answer?

**Final answer:** What the programme is; where it can be studied; how it is delivered; whether the relevant offering is currently accepting applicants; what it costs; what the admission requirements and cut-off are; and which institution offers it.

**Qualification:** “Cut-off” is explicitly folded into the admission requirements item rather than left implicit.

**Status:** FROZEN.

## Q41
**Original question:** What should the tuition period enum be called and contain?

**Final answer:** `TuitionPeriod`; year / session / semester / term / one_time / unspecified initially proposed.

**Important supersession:** Q42 removes the separate `unspecified` enum member. Final enum members are year / session / semester / term / one_time; missing period is NULL.

**Status:** FROZEN after Q42.

## Q42
**Original question:** Should missing tuition period be NULL or an `unspecified` enum value?

**Final answer:** NULL = source provided no period. No separate unspecified enum state.

**Status:** FROZEN.

## Q43
**Original question:** Can a tuition range include a NULL period?

**Final answer:** No. No numeric range unless currency and period both match and both amounts are valid. NULL period never ranges.

**Status:** FROZEN.

## Q44
**Original question:** What is the default ProgrammeInstance on direct Programme Detail landing?

**Final answer:** C — preselect from valid published search/referral context when available; otherwise current academic year → primary campus → OnCampus → earliest-created instance. Invalid/unpublished referral context falls through to the deterministic fallback.

**Status:** FROZEN.

## Q45
**Original question:** What should the result card show when exactly one ProgrammeInstance matches?

**Final answer:** Full instance context: admission, tuition, campus/location, and delivery.

**Status:** FROZEN.

## Q46
**Original question:** What if multiple matching instances have identical tuition?

**Final answer:** D — show one value plus the offering count; never show a fake range like ₦200k–₦200k.

**Status:** FROZEN.

## Q47
**Original question:** How should cut-off be aggregated on an unfiltered Programme page?

**Final answer:** C — “Cut-off varies by study option”; exact value after an instance is selected.

**Status:** FROZEN.

## Q48
**Original question:** Should concrete admission requirements be shown before instance selection?

**Final answer:** No. Requirements live under the selected ProgrammeInstance only.

**Status:** FROZEN.

## Q49
**Original question:** What is the formal same-scope search rule?

**Final answer:** Programme-scoped and Institution-scoped predicates filter at their own scope; all ProgrammeInstance-scoped predicates are conjunctive within the same ProgrammeInstance.

**Status:** FROZEN / CANONICAL INVARIANT.

## Q50
**Original question:** Do Institution-scoped Ownership predicates need to share the same instance as Location/Admission predicates?

**Final answer:** No. Institution-scoped predicates are independent of which instance satisfies the instance-scoped predicates.

**Status:** FROZEN.

## Q51
**Original question:** Should the physical schema become a generic global geographic hierarchy now?

**Final answer:** B — keep the V4.6 physical schema for V1 (state/city); treat state as the country-specific administrative-area field and abstract country terminology only in acquisition/normalization.

**Status:** FROZEN.

## Q52
**Original question:** What format should contextual Scholarship references take?

**Final answer:** A — simple contextual references only, gated by completeness/conflict-resolution; omit otherwise.

**Status:** FROZEN.

## Q53
**Original question:** How should the 17-week MVP plan be packaged relative to FVS?

**Final answer:** C — keep the 17-week plan; explicitly label non-FVS capabilities as post-FVS MVP expansion.

**Status:** FROZEN.

## Q54
**Original question:** Which filters remain functional in PostgreSQL fallback?

**Final answer:** Discipline, Award level, Institution type, Ownership remain functional because they are Programme/Institution-scoped. Instance-scoped facets are not guaranteed.

**Status:** FROZEN.

## Q55
**Original question:** Should slug be a search ranking signal?

**Final answer:** No.

**Status:** FROZEN.

## Q56
**Original question:** Should numeric search-ranking weights be frozen now?

**Final answer:** No. Freeze ordering/principle only; tune numeric weights later using real query data.

**Status:** FROZEN.

## Q57
**Original question:** Are LCP/INP/CLS hard invariants?

**Final answer:** No. They are acceptance targets measured on representative mid-range mobile hardware and throttled network.

**Status:** FROZEN.

## Q58
**Original question:** What accessibility critical flows must be tested?

**Final answer:** Search, filter, select instance, read admission information, Programme → Institution navigation. Automated checks cover keyboard access, labels, focus, contrast where tooling permits, semantic headings, and form errors.

**Status:** FROZEN.

## Q59
**Original question:** What happens when a source conflict remains unresolved for a long time?

**Final answer:** Never publish it as canonical. Show “field unavailable / under review” (or equivalent), retain provenance and conflict state. Ownership/SLA for long-lived conflicts is a Phase 2 operational concern.

**Status:** FROZEN.

## Q60
**Original question:** Should the plain-English central FVS invariant be locked alongside the formal Q49 search invariant?

**Final answer:** Yes. Both are authoritative: Q49 is the enforceable scope rule; Q60 is the plain-English product rationale.

**Status:** FROZEN.

---

# 3. Q61–Q85 — USER CHOICES NOW RECOVERED

The user has now explicitly supplied the final choice for every question Q61–Q85. These are **user decisions**, not assistant recommendations. The original question wording and detailed semantic explanations for these numbered questions are not present in the latest supplied material, so this handoff records the exact selected choice and explicitly avoids inventing its meaning.

| Q | Final user answer/choice | Exact recoverable semantic meaning | Superseded? | Status |
|---|---|---|---|---|
| Q61 | **C** | User explicitly selected choice **C**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q62 | **class-specific policy** | User explicitly selected **class-specific policy**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q63 | **A** | User explicitly selected choice **A**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q64 | **C** | User explicitly selected choice **C**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q65 | **A** | User explicitly selected choice **A**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q66 | **C** | User explicitly selected choice **C**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q67 | **monotonic lifecycle** | User explicitly selected **monotonic lifecycle**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q68 | **B** | User explicitly selected choice **B**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q69 | **C** | User explicitly selected choice **C**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q70 | **C** | User explicitly selected choice **C**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q71 | **C** | User explicitly selected choice **C**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q72 | **B** | User explicitly selected choice **B**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q73 | **A** | User explicitly selected choice **A**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q74 | **C** | User explicitly selected choice **C**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q75 | **B + C** | User explicitly selected **B + C**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q76 | **C** | User explicitly selected choice **C**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q77 | **B** | User explicitly selected choice **B**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q78 | **C** | User explicitly selected choice **C**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q79 | **all listed** | User explicitly selected **all listed**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q80 | **C** | User explicitly selected choice **C**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q81 | **C** | User explicitly selected choice **C**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q82 | **C** | User explicitly selected choice **C**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q83 | **defined clean threshold** | User explicitly selected **defined clean threshold**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q84 | **D** | User explicitly selected choice **D**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |
| Q85 | **D** | User explicitly selected choice **D**. The underlying question text/option semantics are not present in the supplied continuation data. | Not recoverable | APPROVED — choice recovered |

**Important:** Do not reinterpret the letters (A/B/C/D), **class-specific policy**, **monotonic lifecycle**, **all listed**, or **defined clean threshold** from this table without the original Q61–Q85 question/option text. They are authoritative user selections, but their full domain semantics require the corresponding question text.

# 4. Q86–Q98 — RECOVERED FROM LATER FINAL-LOCK ARTIFACT

**Recovery source:** `Pasted markdown(20260825-212207).md` from the later StudyNexus decision session. The artifact itself contains a “Final Q86–Q98 lock” table and detailed definitions. The raw user messages for these exact numbered questions are not separately recoverable in the currently available transcript; therefore this section is marked **RECOVERED FINAL-LOCK ARTIFACT**, not “raw user answer recovered”.

## Q86
**Final decision recorded:** C + A.

If a projection worker crashes after Typesense accepts revision N but before PostgreSQL records APPLIED, reconciliation inspects the actual Typesense document. If requested revision is already present and valid, record APPLIED retroactively. If Typesense is behind, retry the exact same immutable revision/candidate. If absent/corrupt, rebuild the same revision from canonical state. Never allocate a new projection revision merely because the worker crashed.

**Status:** APPROVED/LOCKED in later final-lock artifact.

## Q87
**Final decision recorded:** C.

PostgreSQL is authoritative for canonical state and projection lifecycle intent; Typesense is authoritative for the physical existence/content of its search document. Revision discrepancies are reconciled against durable event history, not by blindly trusting one side.

**Status:** APPROVED/LOCKED in later final-lock artifact.

## Q88
**Final decision recorded:** Admission policy precedence = instance-specific > institution-level > none. Source priority resolves only same-scope source conflicts. If same-scope policies cannot be deterministically ordered, this is a blocking reconciliation/data-governance error. No implicit system default.

**Status:** APPROVED/LOCKED in later final-lock artifact.

## Q89
**Final decision recorded:** Explicit lifecycle/public/search/URL/SEO/sitemap matrix.

| Lifecycle | Public | Typesense search | Canonical URL | Google indexable | Sitemap | Structured data |
|---|---|---|---|---|---|---|
| ACTIVE | Yes | Yes | 200 | Yes if SEO-eligible | Yes if indexable | Yes |
| SUSPENDED | No | Yes | 200 | Yes | Yes | Yes, but availability must be accurately represented |
| DISCONTINUED | No | Yes if historical value exists | 200 | Yes when historical page is useful | Yes if indexable | Historical/current semantics only |
| CLOSED | No | Depends | 200 or 404 | Depends | Depends | Depends |
| DRAFT/UNPUBLISHED | No | No | 404 | No | No | No |

**Hard separation:** `is_searchable` ≠ indexable.

**Status:** APPROVED/LOCKED in later final-lock artifact.

## Q90
**Final decision recorded:** 301 redirects; globally unique normalized source URL; query strings retained when semantically part of the legacy route; tracking-only parameters excluded; fragments never part of keys; reject redirect chains and cycles; one source cannot map to multiple active destinations; invalid destinations are operationally flagged; indefinite retention by default.

**Status:** APPROVED/LOCKED in later final-lock artifact.

## Q91
**Final decision recorded:** Explicit curated SEO registry. Only stable, human-curated, explicitly registered discovery routes are indexable. Arbitrary filter/query URLs, free-text results, sort URLs, arbitrary location/ownership/delivery combinations, empty combinations and arbitrary pagination are non-indexable by default.

Registry fields include path/slug, page type, canonical URL, indexable, sitemap, title/meta policy, structured-data policy.

**Status:** APPROVED/LOCKED in later final-lock artifact.

## Q92
**Final decision recorded:** Sitemap inclusion = published + indexable + SEO-contract-approved (+ public eligibility). Pagination is not a V1 sitemap candidate. Scholarships are not automatically included unless their public SEO surface is actually in V1.

**Status:** APPROVED/LOCKED in later final-lock artifact.

## Q93
**Final decision recorded:** Structured data is emitted for canonical public 200 pages that are indexable and have an approved schema contract. No page structured data for 404/410/redirect. No SEO structured data for noindex pages unless the page contract explicitly requires it. Historical pages must not falsely imply current availability.

**Status:** APPROVED/LOCKED in later final-lock artifact.

## Q94
**Final decision recorded:** Exact job policies are frozen in authoritative `QUEUE-001`.

Projection jobs:
- tries 5
- timeout 120s
- backoff 30s, 60s, 120s, 300s
- maxExceptions 3

Reconciliation jobs:
- tries 5
- timeout 120s
- backoff 60s, 120s, 300s, 600s
- maxExceptions 3

Import execution jobs:
- tries 3
- timeout 300s
- backoff 60s, 300s
- maxExceptions 2

Deterministic validation failures are not automatically retried. Queue `retry_after` must exceed maximum worker execution timeout by a safety margin. Jitter is used around exponential schedules.

**Status:** APPROVED/LOCKED in later final-lock artifact; authoritative queue artifact itself was not separately recovered here.

## Q95
**Final decision recorded:** A — hard job timeout 120s and lock expiry 180s. Lock must exceed maximum legitimate job runtime. External calls must have individual timeouts. No lock renewal for V1.

**Status:** APPROVED/LOCKED in later final-lock artifact.

## Q96
**Final decision recorded:** Import lifecycle:

`RECEIVED → VALIDATING → APPROVED → APPLYING → APPLIED`

Failure terminal branches:
- `VALIDATION_FAILED`
- `FAILED`

Approved may be revoked before application. Once APPLYING starts, approval cannot simply be revoked to abort the transaction. APPLIED never transitions backward. FAILED may retry the same execution ID when the canonical transaction did not commit. Replaying an already-consumed artifact uses a new execution ID. Replay states are operational events, not primary artifact lifecycle states.

**Status:** APPROVED/LOCKED in later final-lock artifact.

## Q97
**Final decision recorded:** C — cache invalidation uses the durable canonical event/outbox mechanism. Cache invalidation is at-least-once and has TTL as safety net; it is not transactionally atomic with PostgreSQL.

**Status:** APPROVED/LOCKED in later final-lock artifact.

## Q98
**Final decision recorded:** B + C — preserve the full conceptual model, but implementation eligibility is limited to FVS-required work + foundational platform/security/operations required by FVS. Deferred domains MUST NOT acquire migrations/models/actions/routes/projections until their feature enters implementation scope. Conceptual tables are not an implementation commitment.

**Status:** APPROVED/LOCKED in later final-lock artifact.

---

# 5. Q99–Q118 — NOT RECOVERED WITH SUFFICIENT EVIDENCE

No trustworthy numbered Q99–Q118 source was recovered from the available session/library artifacts.

| Q | Status | Reason |
|---|---|---|
| Q99 | NOT RECOVERED | No trustworthy numbered source recovered |
| Q100 | NOT RECOVERED | No trustworthy numbered source recovered |
| Q101 | NOT RECOVERED | No trustworthy numbered source recovered |
| Q102 | NOT RECOVERED | No trustworthy numbered source recovered |
| Q103 | NOT RECOVERED | No trustworthy numbered source recovered |
| Q104 | NOT RECOVERED | No trustworthy numbered source recovered |
| Q105 | NOT RECOVERED | No trustworthy numbered source recovered |
| Q106 | NOT RECOVERED | No trustworthy numbered source recovered |
| Q107 | NOT RECOVERED | No trustworthy numbered source recovered |
| Q108 | NOT RECOVERED | No trustworthy numbered source recovered |
| Q109 | NOT RECOVERED | No trustworthy numbered source recovered |
| Q110 | NOT RECOVERED | No trustworthy numbered source recovered |
| Q111 | NOT RECOVERED | No trustworthy numbered source recovered |
| Q112 | NOT RECOVERED | No trustworthy numbered source recovered |
| Q113 | NOT RECOVERED | No trustworthy numbered source recovered |
| Q114 | NOT RECOVERED | No trustworthy numbered source recovered |
| Q115 | NOT RECOVERED | No trustworthy numbered source recovered |
| Q116 | NOT RECOVERED | No trustworthy numbered source recovered |
| Q117 | NOT RECOVERED | No trustworthy numbered source recovered |
| Q118 | NOT RECOVERED | No trustworthy numbered source recovered |

Do not infer these from surrounding architecture. The continuation session must recover them from any additional source artifact if one becomes available.

---

# 6. Critical Semantic Separations — MUST NOT BE COLLAPSED

## 6.1 Projection revision concepts

These concepts are distinct:

### `projection_event_revision`
Canonical causal ordering/version of the emitted projection event. It answers:
“What canonical/projection event revision is this candidate/event?”

### Contributor revision
A contributor/user/editor revision or change identity. This is a separate domain/change concept and must not be conflated with projection ordering.

### `last_applied_projection_revision`
Durable application-side record of the last projection revision the projection state considers successfully applied.

### Projection lifecycle state
Application-side durable lifecycle/acceptance state, e.g. pending/applying/applied/failed. It is not itself the same thing as a revision number.

### Typesense document revision
The physical revision stored in the Typesense document (the later-lock artifact calls it `Typesense.projection_revision`). It describes physical search-document state, not canonical truth.

### Projection fingerprint
A deterministic content identity/fingerprint of the rendered projection. It answers “is the rendered content materially identical?” and is distinct from ordering/revision/lifecycle identity.

Hard rule recovered from the later lock artifact:

`projection_states` = durable application-side lifecycle/acceptance state

`projection_event_revision` = canonical causal ordering

`Typesense.projection_revision` = physical search-document revision being compared/applied

Do NOT collapse these into a generic “revision”.

## 6.2 Publication / lifecycle / visibility

Keep separate:

- publication status — editorial/publication control
- Programme lifecycle — business/editorial state of the Programme
- ProgrammeInstance admission state — applicant-facing availability
- searchability — whether it appears in the search projection
- SEO indexability — whether search engines should index it
- canonical URL accessibility — whether a public route may resolve with 200/404/410/redirect

Q89 provides an explicit later-session lifecycle/search/SEO matrix and MUST be preserved as separate concepts.

## 6.3 Artifact and execution identities

These are distinct:

- artifact identity — stable identity of the immutable approved import artifact
- artifact hash — content integrity identity of that artifact
- approval identity — identity of the approval decision
- execution identity — identity of a specific application execution attempt
- replay execution identity — a NEW execution identity when replaying an already-consumed artifact

Q96 explicitly states that replay is a new execution ID and does not rewrite the original execution history.

## 6.4 Canonical vs projection state

Do not collapse:

- canonical truth in PostgreSQL
- projection lifecycle state in the application
- physical Typesense document state

Q87 explicitly separates PostgreSQL’s canonical/lifecycle authority from Typesense’s physical document state authority.

---

# 7. Normalized Decision Register — Recovered Decisions

The full V4.7 section mapping is NOT present in the recovered corpus. Do not invent it. The normalized register below uses the Q number as the stable Decision ID where no project-specific decision ID is known.

| Q | Decision ID | Area | Final authoritative rule | Depends on | Supersedes | Status |
|---|---|---|---|---|---|---|
| Q1 | Q01 | Search scope | Instance facets are same-instance; Programme/Institution facets at own scope | Q3,Q49,Q60 | — | FROZEN |
| Q2 | Q02 | Admission UX | No bare Programme “Open”; instance/context or aggregate count | Q21,Q24 | — | FROZEN |
| Q3 | Q03 | Search | State + Admission must match same instance | Q49,Q60 | Q22 only for presentation | FROZEN |
| Q4 | Q04 | Tuition | Matching-instance semantics; latest restrictions in Q19/Q23/Q46 | Q19,Q23,Q46 | earlier range assumption | FROZEN |
| Q5 | Q05 | Tuition | Period exists separately | Q16 | superseded by Q16 | FROZEN |
| Q6 | Q06 | Admission | Programme lifecycle distinct from instance availability | Q20,Q24 | refined by Q20 | FROZEN |
| Q7 | Q07 | Scope | Scholarship public discovery Phase 2 | Q28,Q29,Q52,Q53 | — | FROZEN |
| Q8 | Q08 | SEO | `/programmes/{discipline}` curated; arbitrary filter URLs noindex | Q30 | — | FROZEN |
| Q9 | Q09 | Ownership | Canonical OwnershipType | Q31 | — | FROZEN |
| Q10 | Q10 | Delivery | No Full-time/Part-time in V1 DeliveryMode | — | — | FROZEN |
| Q11 | Q11 | UX | Selector + detail panel | Q44 | refined by Q44 | FROZEN |
| Q12 | Q12 | Tuition | Mixed currencies display as “varies by currency”; no FX | Q19,Q43 | refined by period rule | FROZEN |
| Q13 | Q13 | Publication | No published instances => not public search/sitemap | — | — | FROZEN |
| Q14 | Q14 | Search fallback | Postgres basic search; advanced instance facets degrade | Q33,Q54 | refined by Q33/Q54 | FROZEN |
| Q15 | Q15 | Trust | Source + verified/freshness metadata, no universal badge | Q32,Q59 | refined by Q32/Q59 | FROZEN |
| Q16 | Q16 | Tuition | `MonetaryAmount` stays amount+currency; `tuition_period` separate | Q5 | supersedes Q5 placement | FROZEN |
| Q17 | Q17 | Tuition provenance | Canonical period + raw source wording | Q18 | — | FROZEN |
| Q18 | Q18 | Tuition ingestion | Incoherent source cadence => review, not fabricated value | — | — | FROZEN |
| Q19 | Q19 | Tuition | Range requires same currency + same period + valid amounts | Q43 | refines Q4 | FROZEN |
| Q20 | Q20 | Domain lifecycle | Programme lifecycle vs ProgrammeInstance admission | Q6,Q24 | supersedes rough Q6 | FROZEN |
| Q21 | Q21 | Admission | X/Y accepting; published-instance denominator only | Q2 | — | FROZEN |
| Q22 | Q22 | UX | No non-match blending; contextual hint / subordinate expand | Q3 | supersedes Q3 UI notion | FROZEN |
| Q23 | Q23 | Search UX | Hide filtered tuition unless exact single match is safely known | Q4,Q19 | refines Q4 | FROZEN |
| Q24 | Q24 | Admission UX | Exact context when instance resolved; aggregate otherwise | Q2,Q20 | — | FROZEN |
| Q25 | Q25 | Aggregation | Safe summaries + academic-year listing; no unsafe requirements aggregation | Q49,Q60 | — | FROZEN |
| Q26 | Q26 | Location | Country→Administrative Area→City semantic model | Q51 | — | FROZEN |
| Q27 | Q27 | Location UX | Hierarchical drill-down | Q26 | — | FROZEN |
| Q28 | Q28 | Scholarship | Contextual references only if trusted/complete | Q7,Q52 | — | FROZEN |
| Q29 | Q29 | Scope | FVS ⊂ MVP | Q53 | — | FROZEN |
| Q30 | Q30 | SEO | No generic location SEO pages V1 | Q26,Q27 | — | FROZEN |
| Q31 | Q31 | Ownership | Canonical OwnershipType only | Q9 | — | FROZEN |
| Q32 | Q32 | Provenance | Admin resolves before publication | Q59 | — | FROZEN |
| Q33 | Q33 | Fallback UX | Disable unsupported filters with degraded-mode message | Q14,Q54 | refines Q14 | FROZEN |
| Q34 | Q34 | Search | Relevance ordering; no popularity without evidence | Q56 | — | FROZEN |
| Q35 | Q35 | SEO | SEO order independent of search relevance | Q8 | — | FROZEN |
| Q36 | Q36 | Performance | LCP/INP/CLS acceptance targets | Q57 | — | FROZEN |
| Q37 | Q37 | Accessibility | WCAG 2.2 AA + critical-flow automation | Q58 | — | FROZEN |
| Q38 | Q38 | UI stack | Flux Pro v2 | — | — | FROZEN |
| Q39 | Q39 | Product model | Programme page vs selected ProgrammeInstance | Q60 | — | FROZEN |
| Q40 | Q40 | FVS | 7 user questions define FVS success | Q39 | — | FROZEN |
| Q41 | Q41 | Tuition | `TuitionPeriod` enum name | Q42 | refined by Q42 | FROZEN |
| Q42 | Q42 | Tuition | NULL means period absent; no unspecified member | Q41 | supersedes “unspecified” member | FROZEN |
| Q43 | Q43 | Tuition | NULL period never ranges | Q19 | — | FROZEN |
| Q44 | Q44 | UX | Default instance: context → current year → primary campus → OnCampus → earliest | Q11 | resolves Q11 | FROZEN |
| Q45 | Q45 | Search UX | Exact instance match shows full instance context | Q23,Q24 | — | FROZEN |
| Q46 | Q46 | Tuition UX | Equal values shown once + offering count | Q4,Q19,Q23 | — | FROZEN |
| Q47 | Q47 | Cut-off | Unfiltered “varies by study option”; exact after selection | Q25 | — | FROZEN |
| Q48 | Q48 | Admission | Requirements only in selected instance context | Q25,Q39 | — | FROZEN |
| Q49 | Q49 | Search | Formal same-instance predicate rule | Q1,Q50,Q60 | — | FROZEN |
| Q50 | Q50 | Search scope | Institution and instance scopes remain independent | Q9,Q49 | — | FROZEN |
| Q51 | Q51 | Location | Physical schema remains V4.6 state/city | Q26 | — | FROZEN |
| Q52 | Q52 | Scholarship | Contextual refs only, trusted/complete | Q7,Q28 | — | FROZEN |
| Q53 | Q53 | Scope | Keep 17-week plan; mark post-FVS expansions | Q29 | — | FROZEN |
| Q54 | Q54 | Fallback | Programme/Institution facets can remain; instance facets not guaranteed | Q14,Q33 | — | FROZEN |
| Q55 | Q55 | Search | Slug not ranking signal | Q34 | — | FROZEN |
| Q56 | Q56 | Search | Freeze ranking principle, not numeric weights | Q34 | — | FROZEN |
| Q57 | Q57 | Performance | Targets are acceptance criteria | Q36 | — | FROZEN |
| Q58 | Q58 | Accessibility | Critical flows enumerated | Q37 | — | FROZEN |
| Q59 | Q59 | Provenance | Unresolved conflict never published; field unavailable/under review | Q32 | — | FROZEN |
| Q60 | Q60 | Search/product | Plain-English central invariant | Q49 | — | FROZEN |
| Q61–85 | Q61–Q85 | Not recoverable from supplied material | Exact user choices recorded above; question/option semantics not supplied | — | — | APPROVED — choices recovered |
| Q86 | Q86 | Projections | APPLYING reconciliation checks Typesense; retry same immutable revision | Q87 | — | APPROVED/LOCKED (later artifact) |
| Q87 | Q87 | Projections | Reconcile revision discrepancy against durable event history | Q86 | — | APPROVED/LOCKED (later artifact) |
| Q88 | Q88 | Admissions | Instance > institution > none; source priority only same-scope | — | — | APPROVED/LOCKED (later artifact) |
| Q89 | Q89 | Publication/SEO | Explicit lifecycle/search/indexability matrix | — | — | APPROVED/LOCKED (later artifact) |
| Q90 | Q90 | SEO | 301 redirect contract; no chains/loops; indefinite retention | — | — | APPROVED/LOCKED (later artifact) |
| Q91 | Q91 | SEO | Curated allowlisted SEO registry | Q8,Q30,Q35 | — | APPROVED/LOCKED (later artifact) |
| Q92 | Q92 | SEO | Sitemap = published + indexable + SEO-approved | Q91 | — | APPROVED/LOCKED (later artifact) |
| Q93 | Q93 | SEO | Structured data only on appropriate canonical pages | Q89,Q91,Q92 | — | APPROVED/LOCKED (later artifact) |
| Q94 | Q94 | Queues | Exact class-specific queue policy in QUEUE-001 | — | — | APPROVED/LOCKED (later artifact) |
| Q95 | Q95 | Queues | Hard job bound + longer overlap lock | Q94 | — | APPROVED/LOCKED (later artifact) |
| Q96 | Q96 | Imports | Separate artifact lifecycle vs execution lifecycle; replay = new execution | Q87 | — | APPROVED/LOCKED (later artifact) |
| Q97 | Q97 | Cache | Durable event-driven invalidation + TTL safety net | Q87 | — | APPROVED/LOCKED (later artifact) |
| Q98 | Q98 | Scope | Only FVS/foundational implementation; deferred conceptual domains do not become code | Q29,Q53 | — | APPROVED/LOCKED (later artifact) |
| Q99–118 | — | — | NOT RECOVERED | — | — | UNRESOLVED |

---

# 8. Source Corpus Transfer

## 8.1 Actual source archive

**Current V4.6 source corpus preserved:**

`/mnt/data/transfer/STUDYNEXUS-V4.6-SOURCE-CORPUS.zip`

This is a byte-for-byte copy of the currently available StudyNexus V4.6 remediated ZIP used for the preservation operation.

**Original available source filename:**
`StudyNexus-V4.6-REMEDIATED-PACKAGE (1).zip`

**Observed archive structure:**
`PRE-IMPLEMENTATION-BASELINE-V2/`

**ZIP entries:** 63 total (including directory entries)

**Actual files:** 57 non-directory entries

**Archive size:** 919,142 bytes

**Archive SHA-256:** `4d5fd029fdce06e8edfc21922c5571ab090de170b10b44f11876ea43a3636f69`

## 8.2 Manifest

`/mnt/data/transfer/STUDYNEXUS-V4.6-SOURCE-MANIFEST.txt`

The manifest contains per-file:

- relative path
- byte size
- SHA-256

The manifest also records the archive SHA-256 and file count.

## 8.3 Important preservation note

Earlier StudyNexus reports cited a 57-file package. The current ZIP actually contains 57 non-directory files and 63 ZIP entries including directories. The preservation package intentionally does not alter this source corpus merely to reconcile old count language.

---

# 9. Later Evidence / Remediation Artifacts

A separately named “V4.7 remediation/evidence ZIP” was **not** recovered by exact-name search in the available library/session artifacts.

The later evidence recovered for continuation includes:

### `Pasted markdown(20260825-212207).md`

This artifact contains the final Q86–Q98 lock and detailed projection/import/SEO decisions, including the explicit three-layer projection distinction.

### `StudyNexus-V4.6-Developer-Handoff.zip`

A library artifact from the later StudyNexus workstream, created 2026-08-24. It is a V4.6 developer handoff artifact, not proven to be a V4.7 evidence package.

### `StudyNexus-Independent-Audit-Package-v4.zip`

A separate earlier independent-audit package. It is not the authoritative current source corpus.

**Do not relabel any of these as V4.7 without evidence.**

---

# 10. Known Unresolved / Not Recovered Decisions

1. Q61–Q85 final user choices are recovered explicitly, but the original question/option wording is not present in the supplied continuation data; therefore only the exact choices are authoritative and no semantic interpretation is added.
2. Q99–Q118 exact numbered question/answer records are not recovered with sufficient confidence.
3. The later transfer requirement mentions `contributor revision`, `last_applied_projection_revision`, and `projection fingerprint`; the recovered Q86–Q98 artifact explicitly defines `projection_event_revision`, `projection_states`, and `Typesense.projection_revision`, but does not provide a complete Q-numbered final lock for every other named concept. Do not infer missing semantics.
4. The authoritative `QUEUE-001` artifact named by Q94 was not separately recovered in this preservation operation.
5. No separately named V4.7 evidence ZIP was recovered.

These are recovery limitations, NOT approvals to invent missing decisions.

---

# 11. Known Deferred Features / Boundaries Recovered From Explicit Decisions

- Differentiated tuition fee categories are deferred post-V1.
- Public scholarship discovery is Phase 2; scholarship entity/admin/contextual references may exist in V1.
- Location SEO landing pages are deferred from V1.
- Full-time/Part-time study-load concept is deferred.
- Federal/State jurisdiction is deferred as a separate concept.
- Numeric search-weight tuning is deferred until real behavioral data.
- City-level location refinements may be introduced later.
- Manual accessibility audit is a scheduled follow-up operational milestone.
- Executable implementation is not yet executed.
- Deferred conceptual domains must not silently become implementation artifacts (Q98).

---

# 12. Final Continuation Rules

The next execution session must:

1. Treat the latest explicit user decision as authoritative.
2. Treat this transfer artifact as the authoritative recovered record for Q1–Q98 only where explicitly labeled recovered.
3. Treat Q61–Q85 as explicit user choices whose underlying question semantics are not currently recovered; do not reinterpret the supplied choices. Treat Q99–Q118 as NOT RECOVERED.
4. Not restart the questionnaire merely because this transfer has incomplete ranges.
5. Not infer user approval from assistant recommendations.
6. Not silently promote historical PRD discussion into the current StudyNexus V4.6/V4.7 authority chain.
7. Operate directly on the actual V4.6 source corpus.
8. Preserve all semantic separations in Section 6.
9. Distinguish documentation state from executable implementation state.
10. Treat any newly recovered raw Q61–Q85/Q99–Q118 question/option evidence as higher-quality evidence than inference. It may enrich the Q61–Q85 entries, but must not overwrite the explicit choices supplied by the user unless the user later supersedes them.

> **The next execution session must treat this transfer artifact as the authoritative record of the user's Q1–Q118 decisions. It must not restart the questionnaire, must not infer approval from recommendations, and must operate directly on the actual V4.6 source corpus.**

---

# Appendix A — Recovery Sources Used

1. Current conversation — visible Q1–Q60 interview and explicit user answers.
2. Later library artifact: `Pasted markdown(20260825-212207).md` — explicit “Final Q86–Q98 lock”.
3. Current V4.6 remediated package preserved as `STUDYNEXUS-V4.6-SOURCE-CORPUS.zip`.

No unsupported Q61–Q85 semantic mapping has been synthesized from unrelated documents. The explicit Q61–Q85 choices supplied by the user are recorded above exactly as given.
