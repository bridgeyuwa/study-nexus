## JSONB Usage Principle

PostgreSQL's `jsonb` is powerful and indexable, but that does not make it a substitute for relational modeling; it is best where the data is genuinely document-like or structurally variable.

For StudyNexus, JSONB should be treated as an exception rather than the default. The implementation/planning agent should evaluate each candidate according to the domain semantics, queryability, validation requirements, relationships, lifecycle, and expected usage.

Distinguish these five outcomes:

| Classification                 | Meaning                                                                                            |
| ------------------------------ | -------------------------------------------------------------------------------------------------- |
| **RELATIONAL — hard no JSONB** | Proper columns, tables, and relationships                                                          |
| **JSONB — recommended**        | Genuinely variable or document-like data where JSONB is the best fit                               |
| **JSONB — tempting but NO**    | Looks flexible, but represents meaningful domain semantics that should be modeled relationally     |
| **SOURCE/RAW JSONB**           | Raw external payload, extraction artifact, or source-specific structure; not canonical domain data |
| **DO NOT MODEL**               | Information that should not be stored at all                                                       |

**Rule:** Do not introduce JSONB merely because a field is optional, varies between records, or is inconvenient to model relationally. Conversely, do not force genuinely document-like or structurally variable data into an unnecessarily rigid relational structure.

The decision should be made based on the actual business/domain behavior of the data rather than a blanket preference for either relational fields or JSONB.
