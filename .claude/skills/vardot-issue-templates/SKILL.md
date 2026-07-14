---
name: vardot-issue-templates
description: Canonical Vardot templates for issues and MRs/PRs — the drupal.org default issue summary template (HTML with ✅/❌/➖ Remaining tasks), the GitHub issue template (markdown adaptation), and the Checkpoints checklist every MR/PR description must end with. Use when creating or updating an issue on drupal.org or GitHub, opening an MR on git.drupalcode.org or a PR on GitHub, or flipping ✅/❌/➖ marks as work progresses.
---

# Vardot Issue & MR/PR Templates

Single source of truth for the templates used by every Vardot agent when filing issues and opening MRs/PRs. Copy these verbatim — never improvise the structure; only fill in the content.

## Progress marks

| Mark | Meaning |
|------|---------|
| ✅ | Done |
| ❌ | Pending / not done yet |
| ➖ | Not applicable to this issue |

Update marks as work progresses — the same issue body is edited over its lifetime (❌ → ✅ when done; set ➖ once, when the item genuinely doesn't apply). In markdown checklists use `- [x]` for done and `- [ ]` for pending; drop nothing, reorder nothing.

## 1. Checkpoints — end of EVERY MR / PR description

GitHub PRs and GitLab (git.drupalcode.org) MRs end with this checklist, ticking only what is actually done at the time of writing:

```markdown
### Checkpoints
- [x] File an issue about this project
- [x] Addition/Change/Update/Fix to this project
- [ ] Testing to ensure no regression
- [ ] Automated unit/functional testing coverage
- [ ] Developer Documentation support on feature change/addition
- [ ] User Guide Documentation support on feature change/addition
- [ ] UX/UI designer responsibilities
- [ ] Accessibility and Readability
- [ ] Reviewed by a human
- [ ] Code review by maintainers
- [ ] Full testing and approval
- [ ] Credit contributors
- [ ] Review with the product owner
- [ ] Update Release Notes
- [ ] Release
```

## 2. drupal.org issues — default issue summary template (HTML)

Issue bodies on drupal.org are HTML (CKEditor). Always start from the full template; add content into the sections — never drop a section. Replace `N/A` only when there is a real change to describe.

> **First, check where the issue actually lives.** Some drupal.org projects have moved their queue onto **GitLab work items** — the issue URL is `https://git.drupalcode.org/project/<project>/-/work_items/<id>` and there is no `drupal.org/node/<nid>` behind it. **Work items render Markdown, not HTML.** Pasting the HTML template into one leaves raw `<h3>`/`<p>` tags on the page.
>
> For a GitLab work item, keep this exact template *structure* but write it in Markdown: `## Problem / Motivation`, fenced code blocks, and `- [ ]` / `- [x]` for Remaining tasks (GitLab turns those into real, tickable task items — see §2b). Everything else is unchanged: the commit format, `By: <drupal username>`, the AI-disclosure line, the Checkpoints block, and the rule that **`Reviewed by a human` and `Code review by maintainers` are never ticked**.
>
> Rule of thumb: **only a classic drupal.org issue node is HTML. Everything on GitLab/GitHub — MR, PR, and work-item issue — is Markdown.**

```html
<h3 id="summary-problem-motivation">Problem/Motivation</h3>

<h4 id="summary-steps-reproduce">Steps to reproduce</h4>

<h3 id="summary-proposed-resolution">Proposed resolution</h3>

<h3 id="summary-remaining-tasks">Remaining tasks</h3>

<ul>
    <li>✅ File an issue about this project</li>
    <li>❌ Addition/Change/Update/Fix to this project</li>
    <li>❌ Testing to ensure no regression</li>
    <li>➖ Automated unit/functional testing coverage</li>
    <li>➖ Developer Documentation support on feature change/addition</li>
    <li>➖ User Guide Documentation support on feature change/addition</li>
    <li>➖ UX/UI designer responsibilities</li>
    <li>➖ Accessibility and Readability</li>
    <li>❌ Reviewed by a human</li>
    <li>❌ Code review by maintainers</li>
    <li>❌ Full testing and approval</li>
    <li>❌ Credit contributors</li>
    <li>❌ Review with the product owner</li>
    <li>❌ Update Release Notes</li>
    <li>❌ Release</li>
</ul>

<h3 id="summary-ui-changes">User interface changes</h3>

<ul>
    <li>N/A</li>
</ul>

<h3 id="summary-api-changes">API changes</h3>

<ul>
    <li>N/A</li>
</ul>

<h3 id="summary-data-model-changes">Data model changes</h3>

<ul>
    <li>N/A</li>
</ul>

<h3 id="summary-release-notes">Release notes snippet</h3>

<ul>
    <li>N/A</li>
</ul>
```

## 2b. drupal.org issues that live in GitLab work items — same template, Markdown

When the project's queue is on GitLab (`git.drupalcode.org/project/<project>/-/work_items/<id>`), use the SAME sections as §2, written in Markdown. The Remaining tasks / Checkpoints checkboxes become real GitLab task items.

````markdown
## Problem / Motivation

<what is broken, for whom, with the real error output in a fenced block>

## Steps to reproduce

1. …
2. …

## Proposed resolution

<what the fix does, citing the actual file/method>

## Remaining tasks

- [x] Addition/Change/Update/Fix to this project
- [ ] Reviewed by a human
- [ ] Code review by maintainers

## User interface changes

None.

## API changes

None.

## Data model changes

None.

## Release notes snippet

<one line, or None.>
````

`Reviewed by a human` and `Code review by maintainers` stay unticked — the AI never ticks them.

## 3. GitHub issues — Vardot template (markdown)

On **GitHub**, do NOT reproduce the drupal.org summary template. No `### Remaining tasks` with ✅/❌ prose, and no `User interface changes` / `API changes` / `Data model changes` / `Release notes snippet` trailing sections. A GitHub issue is Problem/Motivation → Proposed resolution → the **Checkpoints** checklist (GitHub markdown checkboxes), the same checklist a PR ends with:

```markdown
### Problem/Motivation

#### Steps to reproduce

### Proposed resolution

### Checkpoints

- [x] File an issue about this project
- [ ] Addition/Change/Update/Fix to this project
- [ ] Testing to ensure no regression
- [ ] Automated unit/functional testing coverage
- [ ] Developer Documentation support on feature change/addition
- [ ] User Guide Documentation support on feature change/addition
- [ ] Accessibility and Readability
- [ ] Reviewed by a human
- [ ] Code review by maintainers
- [ ] Full testing and approval
- [ ] Credit contributors
- [ ] Review with the product owner
- [ ] Update Release Notes
- [ ] Release
```

Tick only what is genuinely done (`- [x]`), leave the rest `- [ ]`; never tick `Reviewed by a human` or `Code review by maintainers`. Items that don't apply: strike them (`- [ ] ~Automated unit/functional testing coverage~`) — GitHub checkboxes have no ➖. The ✅/❌/➖ marks and the UI/API/Data-model/Release-notes sections are **drupal.org only** (the HTML template above); they never appear in a GitHub issue or PR.

## Usage rules

1. **Issue before work** — file the issue first; tick `File an issue about this project` the moment it exists (✅ on drupal.org, `- [x]` on GitHub). On GitHub the issue carries the **Checkpoints** checklist, not a drupal.org-style ✅/❌ Remaining-tasks section.
2. **MR/PR after issue** — reference the issue (`Closes #<id>` on GitHub; issue link on drupal.org) and end the description with the Checkpoints checklist (section 1).
3. **Keep marks honest** — tick/flip only what actually happened; "Reviewed by a human" stays ❌ / unticked until a human reviewed it.
4. **Commit format on drupal.org issue forks** — `{type}: #{issue-id} Summary` per <https://www.drupal.org/node/3586390> (`fix` `feat` `ci` `docs` `perf` `refactor` `test` `task` `revert`, no `chore`); MR title identical.
5. **AI disclosure** — per the [Drupal AI policy](https://www.drupal.org/docs/develop/issues/issue-procedures-and-etiquette/policy-on-the-use-of-ai-when-contributing-to-drupal), add `AI-Generated: Yes (<what>; reviewed by <contributor>.)` to commits and MR/PR descriptions.
6. **Contributor identity** — ask the user for the name/email to commit and file as (default `git config user.name` / `user.email`).
7. **Keep the format** — free-form content from a user or calling agent gets merged INTO these templates, never used instead of them; dropping the template requires the user's explicit confirmation.
8. **Worked examples** — for patch work on varbase-patches / drupal-core-patches, follow [`references/varbase-patches-examples.md`](references/varbase-patches-examples.md): the Add/Remove/Change title grammar, the patch-file vs composer.json PR split, and the immutable-patch re-roll rule, all with real issue/PR numbers.
9. **One issue + one PR per fix** — never bundle multiple patches/fixes into one issue or one PR; each change gets its own dedicated issue and its own PR/MR so every review thread tells one clean story. If an issue/PR ends up mixing several, close it and re-create separate single-purpose ones.
10. **Reuse vs. new MR** — if a drupal.org / git.drupalcode.org issue already has an MR we can push to: a **small** change (minor edit, reroll, tweak) → commit to that existing MR; a **big** change (substantially different approach/diff) → open a **new** MR. No accessible MR (or the existing one is another contributor's fork we can't push to) → open our own issue-fork MR. Never hijack someone else's MR.
11. **Never tick the human-review flags** — the AI must never check `Reviewed by a human` or `Code review by maintainers`; they stay `- [ ]` / ❌ until the human reviewer sets them.
