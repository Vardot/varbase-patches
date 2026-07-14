# Worked examples — vardot/varbase-patches issues & PRs

Distilled from the real history of [Vardot/varbase-patches](https://github.com/Vardot/varbase-patches) (issues/PRs up to #424, 2026). Use these conventions when filing new issues and PRs on varbase-patches / drupal-core-patches. The [`vardot-issue-templates`](../SKILL.md) templates still apply — this shows how they're worded in practice for patch work.

## Issue / PR title grammar

**Patch lifecycle titles** — one action verb, the module, the drupal.org change:

```
<Action> a patch for the <Target> on <ref>[ -- <reason>]
```

The **issue and its MR/PR share this exact title.**

- **Action** — `Add` · `Remove` · `Change` · `Update` · `Revert -`. Use **`Remove all patches for …`** when dropping every patch for a target.
  - **Add** — a new patch is needed. `#348 Add a patch for the Drupal Canvas module on feat: #3585221 Fall back to active version when stored component version is not available`
  - **Remove** — upstream released the fix. `#342 Remove a patch for the Dashboards module on fix: #3542888 PHP 8.4 Support`
  - **Change** — re-roll/replace (new upstream version or updated MR). `#376 Change a patch for the Drupal Canvas module on feat: #3584713 Add Allow Edit Global Regions permission`
  - **Update** — refresh an existing patch. `#70 Update patches for the Redirect module after redirect 8.x-1.10 was released`
  - **Remove all** — drop the whole set. `#279 Remove all patches for The Gin Admin theme after Gin 5.0.12 was released`
  - **Revert -** — undo a prior change. `#59 Revert - Add a patch for CKEditor 5 Premium Features module on Issue #3455574: …`
- **Target** — `<Module name> module` · `<Theme name> theme` (`The Gin Admin theme`) · `<machine> recipe` (`Drupal CMS Admin UI recipe`) · `<vendor/lib> library` (`openai-php/client library`, `e0ipso/twig-storybook library`) · `Drupal Core` · `Varbase <x.y.x> profile`.
- **ref** — the drupal.org change, in either form:
  - commit-type (current): `fix: #3607821 <summary>`, `feat: #3567225 <summary>` — the `<type>` (fix/feat/perf/refactor/task/…) echoes the upstream issue's own commit type.
  - legacy: `Issue #3607821: <summary>`.
- **reason** (optional) — why now: `-- after <Module> <version> was released` (`#355 … -- After Trash 3.0.27 was released`), `- for Varbase 11.0.x` (`#283`), `- for Drupal 10.6.2` (`#309`).

**Composer-plugin / infra PRs** use the Drupal commit-type form with the branch in brackets:

```
task: [10.1.x] require vardot/drupal-core-patches: ~11 || ~12          (#388)
fix: [11.0.x] apply vardot/drupal-core-patches by default (...)        (#394)
docs: Drupal Core Patches + ignore guidance (11.0.x)                   (#409)
fix: #423 Reroll redirect #2879648 patch for Drupal 11.4 (...)         (#424)
```

**Patch-file vs composer.json split** — adding a patch is often two PRs:
- *Patch file* → the `patches` branch: `#421 Add a patch file for the Redirect module on Drupal 11.4 compatibility for RedirectPathProcessorManager (#3607821)`
- *Reference it* → the version branch composer.json: `#420 Add a patch for the Redirect module on Drupal 11.4 compatibility ... (#3607821)`

## Issue body — the drupal.org template

Issues use the default summary template. Real example ([#423](https://github.com/Vardot/varbase-patches/issues/423)):

```markdown
### Problem/Motivation
Drupal core 11.4 removed `PathProcessorManager::addInbound()` … every request fatals:
`Error: Call to undefined method … addInbound()` — a global 500 on the Varbase 9.2.x line.

#### Steps to reproduce
1. Build a Drupal 11.4 site that requires `vardot/varbase-patches:~9.2.0`.
2. Install `drupal/redirect`.
3. Open `/user/login` → HTTP 500 `Call to undefined method … addInbound()`.

### Proposed resolution
Reroll so `RedirectPathProcessorManager` stores its own priority-sorted inbound processors
(collected via the existing `service_collector` tag) … Validated on Drupal 11.4: `/user/login` 200 (was 500).

### Remaining tasks
- [x] File an issue about this project
- [x] Addition/Change/Update/Fix to this project
- [ ] Testing to ensure no regression
… (full checklist)
```

## PR body — summary + issue ref + AI disclosure + Checkpoints

Real example ([#424](https://github.com/Vardot/varbase-patches/pull/424)):

```markdown
Closes #423.

Drupal core 11.4 removed `PathProcessorManager::addInbound()`/`getInbound()`, so the bundled
redirect #2879648 (MR !109) patch fataled globally … This rerolls the patch so
`RedirectPathProcessorManager` keeps its own priority-sorted inbound processors …

- Validated on a clean Drupal 11.4 site: `/user/login` 200 (was 500), redirect 301 works.

AI-Generated: Yes (Used Claude Code to diagnose the removed-core-API fatal and reroll the patch; reviewed by the project maintainer.)

### Checkpoints
- [x] File an issue about this project
- [x] Addition/Change/Update/Fix to this project
… (full checklist)
```

A patch-file PR is terser — it just records the materialization ([#421](https://github.com/Vardot/varbase-patches/pull/421)):

```markdown
Adds the materialized `.diff` of redirect MR !199 as a static, timestamped patch file on the
`patches` branch (via `composer var-ccup`), following `[package]--[date]--[issue]--[MR].patch`.
Referenced by composer.json on 11.0.x in PR #420. Supersedes
`redirect--2026-04-26--2879648--mr-109.patch` (MR !199 carries the whole #2879648 rewritten for 11.4).

AI-Generated: Yes (Materialized via composer var-ccup; reviewed by <contributor>.)
```

## Patch filename convention

```
[package]--[YYYY-MM-DD]--[issue]--[mr-N].patch
```

Real files: `redirect--2026-04-26--2879648--mr-109.patch`, `ctools--2026-05-10--3572317--mr-85.patch`,
`drupal-core--2026-05-10--3539178--mr-12890.patch`.

## Immutability — the going-forward rule

**A published `.patch` is immutable.** The correct re-roll is [#421](https://github.com/Vardot/varbase-patches/pull/421): a **new** MR (!199) → a **new** timestamped file → **supersede** the old one and update composer.json. Do NOT follow [#424](https://github.com/Vardot/varbase-patches/pull/424)'s in-place reroll (same filename `…mr-109.patch`) — other projects pin that file and must keep resolving. Materialize every drupal.org MR through `ddev composer var-ccup` (or an equivalent producing a static, timestamped, standard-named file); never reference a raw MR URL. See the `varbase-patches` / `drupal-core-patches` agents and the `patch-management` skill.
