# Policy on the use of AI when contributing to Drupal — saved summary

Source: <https://www.drupal.org/docs/develop/issues/issue-procedures-and-etiquette/policy-on-the-use-of-ai-when-contributing-to-drupal> (fetched 2026-07-02). The live page is the source of truth — re-read it before the first contribution of a session.

## Core principle

Contributors bear full responsibility for their submissions: "You are fully responsible for the integrity of your submission." Answering "the AI wrote it" when asked to explain code justifies immediate closure of the contribution.

## Requirements

- **Verification**: thoroughly verify all dependencies, logic, and security implications of AI-generated code before submitting — check for hallucinated packages, security gaps, unnecessary refactors.
- **Copyright & licensing**: AI-generated code must not violate third-party copyrights and must be fully compatible with Drupal's GPL license. Ignorance is not an excuse.

## Disclosure

- **Mandatory** for significant AI usage: generating entire functions, classes, architectural scaffolding, or extensive documentation blocks.
- **Not required** for minor uses: single-line autocomplete, basic syntax corrections.
- **Format**: `AI-Generated: Yes (Used GitHub Copilot to help generate boilerplate for this feature).`
- Disclose on the **commit message AND the MR description**.

## Prohibited

- Dumping unexplained code without reading prior discussion
- Posting failed automated checks without fixing them
- Adding AI code to others' work without consent/disclosure
- Abandoning issues when feedback arrives
- Ignoring architectural decisions
- Proposing major rewrites without maintainer engagement
- Posting unreviewed AI summaries for contribution credit

## Enforcement

Education-first; clear disregard or disrespect toward maintainers escalates to temporary or permanent bans.
