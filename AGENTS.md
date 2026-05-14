# AGENTS.md — guide for AI coding assistants

This file is the vendor-neutral entry point for AI coding assistants working on `vardot/varbase-patches`. Read this first, regardless of which tool you are (Claude Code, Cursor, Codex, Aider, Continue.dev, Copilot Workspace, etc.). It captures the constraints that are NOT obvious from the code alone.

## What this repository is

A Composer plugin (`type: composer-plugin`, package name `vardot/varbase-patches`) layered on top of [`cweagans/composer-patches`](https://github.com/cweagans/composer-patches) (v1 or v2). It ships:

1. A curated `extra.patches` list (Drupal core + contrib patches vetted by Vardot for Varbase).
2. Three behaviors that upstream `cweagans/composer-patches` v2 dropped or never had:
   - **Allowlist** `allowed-dependency-patches` — default-deny, defaulting to `["vardot/varbase-patches"]`.
   - **Wildcard** `ignore-dependency-patches` — `fnmatch`-style globs like `drupal/*`.
   - **`patches-ignore`** — per-URL exclusion of a patch declared by a given dependency, restored from cweagans v1 on top of v2.
3. Two Composer commands (`var-ccup`, `var-ccupf`) that materialize remote MR URLs into local timestamped `.patch` files. These replace the old `drush varbase:composer:cleanup:*` commands previously shipped in `varbase_core`.

## Supported branches

| Branch       | Drupal core | Use with                          |
|--------------|-------------|-----------------------------------|
| `11.0.x`     | `~11.3.0`   | Varbase `~11.0.0`, Drupal 11      |
| `10.1.x`     | `~11.3.0`   | Varbase `~10.1.0`                 |
| `10.0.x`     | `~10.6.0`   | Varbase `~10.0.0`                 |
| `9.2.x`      | `~10.6.0`   | Varbase `~9.2.0` (CKEditor 5)     |
| `9.1.x`      | `~10.6.0`   | Varbase `~9.1.0` (CKEditor 4)     |
| `no-patches` | n/a         | Plugin only, empty `extra.patches`|
| `patches`    | n/a         | Patch files only — do not require |

Changes that affect the plugin's behavior must be applied to every supported branch unless the change is genuinely branch-specific (e.g. a Drupal-11-only patch URL).

## Code map

```
src/
├── Capability/             # Composer plugin capability descriptors
├── Command/                # var-ccup, var-ccupf Composer commands
├── Plugin/                 # VarbasePatchesPlugin entry point + activation
├── Resolver/               # Patch resolution (allowlist, wildcard, patches-ignore)
└── Util/                   # Shared helpers
docs/
├── README.md               # Branch-pinned docs landing page
├── installation.md
├── configuration.md
├── commands.md
├── architecture.md
├── migration-from-drush.md
└── troubleshooting.md
.claude/
├── agents/varbase-patches.md
└── skills/
    ├── composer-patches/SKILL.md
    └── patch-management/SKILL.md
composer.json               # extra.patches block + plugin metadata
README.md                   # User-facing entry point
```

## Non-obvious constraints — read before editing

### 1. The plugin uses late activation. Do not promote it to early activation.

The plugin's `composer.json` deliberately omits `extra.plugin-modifies-downloads` and `extra.plugin-modifies-install-path`. Setting either flag would cause Composer to load the plugin BEFORE `drupal/core` has been extracted on a fresh `composer create-project`, producing:

```
Plugin initialization failed ... Failed to open stream ... drupal/core/includes/bootstrap.inc
Install of vardot/varbase-patches failed.
```

The late-activation path (POST_PACKAGE_INSTALL of self, with reflection-driven lock rewrite for v2 and patch-map rebuild for v1) is intentional and already covers the in-flight re-resolve. Do not add those flags as a "fix" for anything.

### 2. `cweagans/composer-patches` v1 AND v2 must both keep working.

The `require` constraint is `cweagans/composer-patches: ~1.7.0 || ~2.0`. Code paths that touch patch resolution must handle both:

- **v2**: Manipulate the lock file via reflection on the v2 patch resolver.
- **v1**: Rebuild the in-memory patch map.

If you remove v1 support, you break legacy Varbase 9.x installs that pin v1.

### 3. Default-deny allowlist is a feature, not a bug.

`allowed-dependency-patches` defaults to `["vardot/varbase-patches"]`. This means a fresh project that adds `vardot/varbase-patches` and then later adds an unrelated contrib module with a stale `.patch` URL in its `extra.patches` will NOT abort the install — the unrelated contrib's patches are filtered out because it is not in the allowlist. Do not "fix" this by widening the default.

### 4. `patches-ignore` matching is by URL.

The schema is:

```json
{ "<source-pkg>": { "<target-pkg>": { "<description>": "<url>" } } }
```

The description string is informational only — matching is done by URL. Both this nested object form and a flat array of URLs (`{ "<source>": { "<target>": ["<url>", ...] } }`) are accepted.

### 5. Patch filename convention is enforced by `var-ccup`.

```
[package name]--[YYYY-MM-DD]--[issue number]--[mr number].patch
```

Examples:
- `drupal-core--2026-05-10--3539178--mr-12890.patch`
- `ctools--2026-05-10--3572317--mr-85.patch`

Do not invent variants. The cleanup commands rely on this format.

### 6. The `patches` branch is data, not a dependency.

The `patches` branch carries `.patch` files only. Never add it to `require`. The plugin's curated list references files on this branch via raw GitHub URLs.

### 7. `composer.json` formatting

Patch entries are written across two indented lines (description on its own line, URL on the next) to match the long-standing layout used in older releases. This is JSON-equivalent; keep the layout when editing `extra.patches` so diffs stay readable.

## Workflow expectations

### Adding a curated patch (in this repo's `composer.json`)

1. Pick the right branch (`11.0.x` for Drupal 11, `10.x.x` / `9.x.x` for Drupal 10).
2. Add the entry under `extra.patches.<target-package>` using the two-line layout.
3. Prefer URLs on this repo's `patches` branch over raw drupalcode.org MR URLs for stable hashes.
4. Commit message: include the upstream Drupal.org issue number and a one-line rationale.

### Adding a downstream feature to the plugin itself

1. Land it on `11.0.x` first.
2. Backport to `10.1.x`, `10.0.x`, `9.2.x`, `9.1.x` if it is not Drupal-11-specific.
3. Update `docs/README.md` on each branch with branch-specific framing if user-visible.

### Commits and PRs

- One concern per commit. Reference the GitHub issue ID in the subject (`Issue #NNN: …`).
- Do not skip pre-commit hooks (`--no-verify`).
- Do not amend published commits.

## AI-tool-specific entry points

- **Claude Code**: `CLAUDE.md` + `.claude/agents/varbase-patches.md` + `.claude/skills/`.
- **Other tools that auto-load `AGENTS.md`**: this file is your authoritative reference.

## Resources

- Repo: <https://github.com/Vardot/varbase-patches>
- External docs: <https://docs.varbase.vardot.com/developers/varbase-patches>
- Branch-pinned docs: [11.0.x](https://docs.varbase.vardot.com/11.0.x/developers/varbase-patches) · [10.1.x](https://docs.varbase.vardot.com/10.1.x/developers/varbase-patches) · [10.0.x](https://docs.varbase.vardot.com/10.0.x/developers/varbase-patches) · [9.2.x](https://docs.varbase.vardot.com/9.2.x/developers/varbase-patches) · [9.1.x](https://docs.varbase.vardot.com/9.1.x/developers/varbase-patches)
- Upstream: [`cweagans/composer-patches`](https://github.com/cweagans/composer-patches)
