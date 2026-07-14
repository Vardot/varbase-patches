---
name: vardot-mr-pr-manager
description: The Vardot way to open and maintain merge/pull requests on ANY platform — GitHub PRs (gh CLI) and GitLab / git.drupalcode.org MRs (issue forks / glab / API). Covers platform detection, description shape (issue link → notes → Checkpoints last), commit-type titles for drupal.org (drupal.org/node/3586390), AI-policy disclosure, honest checkbox flips, one-issue-one-PR, reuse-vs-new-MR, and the never-tick human-review rule. Use when opening an MR/PR, updating its Checkpoints, syncing a PR description, or getting a branch reviewed.
---

# Vardot MR/PR Manager

The single gateway for merge requests and pull requests across GitHub and GitLab (git.drupalcode.org). This skill owns the MR/PR lifecycle — the fix itself belongs to the caller. Issue templates come from the **vardot-issue-templates** skill; issue creation is delegated to the `drupal-issue-manager` / `github-issue-manager` agents.

## Golden rules

1. **Issue first, always.** Never open an MR/PR without an issue to reference. No issue yet → create it (or delegate to the issue-manager agent) and wait for the id.
2. **Search before creating.** Search the repo's open/merged MRs/PRs and the issue queue for the same change + target branch before opening anything. Same change + same branch → reuse. Issue exists but only for OTHER branches → keep the issue, open a NEW MR/PR for the current branch. Never duplicate.
3. **One issue + one PR per fix.** Never bundle multiple patches/fixes into one issue or PR. If one mixes several, close it and split into single-purpose ones.
4. **Checkpoints end every description.** The Checkpoints checklist (from `vardot-issue-templates`) is the FINAL section of every MR/PR body, ticking only what is actually done.
5. **Never tick the human-review flags.** The AI must never check `Reviewed by a human` or `Code review by maintainers` (nor `Full testing and approval`). They stay `- [ ]` until a human sets them.
6. **Always link the issue and the MR/PR** — never a bare number. Report both URLs.

## Platform detection

Detect from the git remote or the URL the caller gives:

| Remote | Vehicle | Title style |
|--------|---------|-------------|
| `github.com` | PR via `gh pr create` | Imperative, proper names Capitalized, no trailing period, `(#<issueID>)` suffix |
| `git.drupalcode.org` / GitLab | MR via issue fork (API / `glab`) | `{type}: #{issue-id} Summary` (commit-type format) |

For drupal.org work, before the first commit/MR of a session READ and follow both source-of-truth policies: the [Policy on the use of AI when contributing to Drupal](https://www.drupal.org/docs/develop/issues/issue-procedures-and-etiquette/policy-on-the-use-of-ai-when-contributing-to-drupal) and the [commit-types message format](https://www.drupal.org/node/3586390).

## Commit / title format (drupal.org issue forks)

```
{type}: #{issue-id} Short summary

By: <drupal.org username>
AI-Generated: Yes (<what the AI did>)
```

Types: `fix` `feat` `ci` `docs` `perf` `refactor` `test` `task` `revert` (no `chore`). The MR title is the same `{type}: #{issue-id} Summary` string. Titles use the project's **human-readable** name (e.g. "Varbase Landing Page (Paragraphs)"), never the machine name (`varbase_landing`) — machine names stay inside code/config/paths.

## Description shape

Summary (what/why) → issue reference (`Closes #<id>` on GitHub; the issue link on drupal.org) → test notes → AI disclosure → **Checkpoints checklist last**. GitLab/GitHub descriptions are **Markdown**; drupal.org **issue** bodies are **HTML** (route those to the issue-manager). Never write an MR/PR description in raw HTML, never write a drupal.org issue body in Markdown.

## Reuse vs. new MR

- Existing MR we can push to + **small** change (edit, reroll, tweak) → commit to that MR.
- **Big** change (substantially different approach/diff) → open a NEW MR.
- No accessible MR, or the existing one is another contributor's fork we can't push to → open our own issue-fork MR. Never hijack someone else's MR.
- On someone else's MR/PR: add a **comment** — never rewrite their title/description, never force-push their branch.

## Closed/Fixed issues

Porting a fix to another branch → check the source issue's status. If it is Closed/Fixed, file a FRESH issue for the port (reference the original for context) and open a NEW issue-fork + MR from that new issue. Never fork/commit/MR/comment against a Closed/Fixed issue, and never relabel an old closed-issue fork to point at the new one.

## Concurrency

Other agents/humans may work the same repo at once. Work only on your own issue/branch/MR; never force-push, rebase, or reset a branch someone else owns; re-fetch live state (issue, MR, branch head) right before mutating; re-run the duplicate search immediately before creating (race window). Never push to a default branch — feature/issue-fork branches only.

## Workflow

1. Detect platform. 2. Ensure the issue exists (delegate to the issue-manager if not). 3. Confirm the branch is pushed (issue fork on drupalcode; fork/feature branch on GitHub). 4. Compose the description (shape above). 5. Open (`gh pr create` / GitLab issue-fork MR) with the right title. 6. Maintain — flip checkboxes on each progress report, mirror into the issue's Remaining tasks. 7. Return the MR/PR URL + the still-unticked Checkpoints as the caller's TODO.

## Limitations

Does not merge, approve, or dismiss reviews — human/maintainer actions. GitHub + GitLab (incl. git.drupalcode.org) only.

## Related skills & agents

- Paired agent: **vardot-mr-pr-manager** — the full sub-agent form of this skill.
- **vardot-issue-templates** skill — the issue summary + Checkpoints templates this skill references; issue creation via the `drupal-issue-manager` / `github-issue-manager` agents.
- **varbase-patches** skill + agent — for `vardot/varbase-patches` patch PRs (see the patch-title grammar and shared-file / multi-version rules).
- **drupal-core-patches** skill + agent — for `vardot/drupal-core-patches` core-patch PRs and Packagist-safe 4-segment never-move release tags.
