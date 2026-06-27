# CLAUDE.md — Claude Code entry point for `vardot/varbase-patches`

Project-specific guidance for Claude Code (and any Anthropic-API agent reading this file) when working in this repository. For a vendor-neutral overview that applies to every AI tool, read [`AGENTS.md`](AGENTS.md) first.

## Sub-agent and skills shipped in this repo

Local to this repository (loaded automatically by Claude Code when invoked from the repo root):

- **Sub-agent:** [`.claude/agents/varbase-patches.md`](.claude/agents/varbase-patches.md) — full-coverage agent for installing, configuring, and troubleshooting `vardot/varbase-patches`.
- **Skill:** [`.claude/skills/composer-patches/SKILL.md`](.claude/skills/composer-patches/SKILL.md) — `cweagans/composer-patches` v1/v2 + this plugin's allowlist, wildcard ignore, and `patches-ignore` extensions.
- **Skill:** [`.claude/skills/patch-management/SKILL.md`](.claude/skills/patch-management/SKILL.md) — authoring, re-rolling, filename convention, and the Composer-native cleanup commands (`var-ccup` / `var-ccupf`).

When the task is about anything in this repo, prefer invoking the local sub-agent rather than answering from scratch. The agent file encodes the version matrix, plugin knobs, and the late-activation rule.

## How to read this codebase efficiently

1. Start with [`AGENTS.md`](AGENTS.md) — the "non-obvious constraints" section is the highest-signal context.
2. Then [`docs/README.md`](docs/README.md) for the branch-specific framing.
3. Code map: `src/Plugin/VarbasePatchesPlugin.php` (entry point + activation), `src/Resolver/` (allowlist + wildcard + `patches-ignore`), `src/Command/` (`var-ccup`, `var-ccupf`).
4. Curated patch list: `composer.json` → `extra.patches`.

## Hard rules

- **Do not skip pre-commit hooks** (`--no-verify` is off-limits unless the user explicitly asks).
- **Do not amend published commits.** Create a new commit.
- **Do not link to private Vardot repositories** from in-repo documentation. Only public artifacts: this repo, `docs.varbase.vardot.com`, `cweagans/composer-patches`, Drupal.org.
- **Do not set `extra.plugin-modifies-downloads` or `extra.plugin-modifies-install-path` on this plugin.** Late activation is required — see [`AGENTS.md`](AGENTS.md) section 1.
- **Do not drop `cweagans/composer-patches` v1 compatibility.** The require constraint is `~1.7.0 || ~2.0`; both code paths must keep working.

## Branching

Work happens on the per-version branches:

- `11.0.x` — Drupal 11 / Varbase 11.
- `10.1.x` — Drupal 11 / Varbase 10.1.
- `10.0.x` — Drupal 10 / Varbase 10.
- `9.2.x` — Drupal 10 / Varbase 9.2 (CKEditor 5).
- `9.1.x` — Drupal 10 / Varbase 9.1 (CKEditor 4).

`main` does not exist as a development branch. The default PR target is `10.0.x`. Plugin-behavior fixes should typically land on `11.0.x` first, then be backported.

## Commit / PR style

- Subject: `Issue #<NNN>: <imperative summary>` when there is a tracking issue.
- Body: explain the *why* (constraint, incident, motivation), not just the *what*. Long-form commit bodies are normal in this repo (see recent history).
- Reference the Drupal.org issue number in curated-patch commits.

## When you're unsure

Read [`AGENTS.md`](AGENTS.md) first, then the sub-agent. If the question is about plugin behavior that is not documented, run `git log -p src/Plugin/ src/Resolver/` to see how the maintainers solved similar problems before.

## Smart Drupal-core patching workflow (varbase-patches + drupal-core-patches)

**Goal:** keep Varbase upgradable to the latest Drupal core by isolating the **Drupal core** patches
from the Varbase line, one set per Drupal core version.

### Packages
- **`vardot/drupal-core-patches`** — Composer `metapackage`, **one git branch per Drupal core
  MAJOR.MINOR** (`10.4.x`, `10.5.x`, `10.6.x`, `11.1.x`, `11.2.x`, `11.3.x`, `11.4.x`, `12.0.x`, …).
  Each branch:
  - `require: { "drupal/core": "~<minor>.0", "cweagans/composer-patches": "~1.7.0 || ~2.0" }`
    — the `require drupal/core ~<minor>.0` binds the release to that core minor (composer selects the
    matching release for the installed core).
  - `extra.patches."drupal/core"` — the curated core patches for that minor (two-line format), URLs
    pointing at the **`patches`** branch raw files.
  - The **`patches`** branch is a flat `.patch` file store (no per-core composer), referenced by
    `https://raw.githubusercontent.com/Vardot/drupal-core-patches/refs/heads/patches/<file>`.
- **`vardot/varbase-patches`** — the Composer plugin. **Requires** `vardot/drupal-core-patches`
  (`~10 || ~11 || ~12` on 9.1.x/9.2.x/10.0.x; `~11 || ~12` on 10.1.x/11.0.x). It no longer carries or
  restricts `drupal/core` patches. Its plugin allowlists `vardot/drupal-core-patches` so the core
  patches are applied — in **both** code paths (constant `VarbasePatchesPlugin::DEFAULT_ALLOWED_DEPENDENCY_PATCHES`
  used by the v1 `buildV1PatchesMap` and the v2 `FilteredDependencies` resolver).

### Per-Drupal-version patch switch (how the right set is chosen)
Consumer requires the broad range (`~10 || ~11 || ~12`). Each drupal-core-patches release `require`s
`drupal/core ~<minor>.0`, so Composer can only pick the release whose minor matches the installed
core → the site automatically gets the patch set for ITS Drupal core.

### Building/maintaining a core-minor set (from varbase-patches history)
1. Group varbase-patches tags by their `drupal/core` constraint
   (`git show <tag>:composer.json` → `require.drupal/core` + `extra.patches."drupal/core"`).
2. For a target core minor, take the **latest** varbase-patches tag whose constraint includes
   `~<minor>.0` and use its `drupal/core` patch set.
3. Download those patch files into the `patches` branch; point the new branch's composer URLs at them.
4. Create `<minor>.x` (off the nearest branch), set `require drupal/core ~<minor>.0` + the set, two-line
   format; copy docs/LICENSE/PR-template.
5. Tag `<minor>.0`.

### Releasing (CRITICAL)
- Tag semver **within the minor** (`11.3.0`, then `11.3.0.1`, `11.3.0.2` …).
- **Never move a tag** — Packagist rejects moved tags ("The last update failed"). For a re-release of
  an already-tagged commit, cut a **new** 4-segment tag (`11.3.0.1`), don't `git tag -f`.
- Packagist needs the GitHub webhook (`https://packagist.org/api/github` + the maintainer's API token)
  or a manual **Update** click; a metapackage's `patches` branch needs no composer/version.
- Future cores (`11.4.x`, `12.0.x`) are forward-compat placeholders: `require drupal/core ~<minor>.0`,
  **empty** `extra.patches."drupal/core"` until patches are re-rolled for that core.
