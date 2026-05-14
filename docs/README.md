# Varbase Patches — Documentation (branch `10.1.x`)

Composer plugin and curated patch list for [Varbase](https://www.drupal.org/project/varbase). Built on top of [`cweagans/composer-patches`](https://github.com/cweagans/composer-patches) v2.

- **Branch:** `10.1.x`
- **Drupal core:** `~11.3.0`
- **Use with:** Varbase `~10.1.0`
- **Recommended require:** `"vardot/varbase-patches": "~10.1.0"`
- **External docs:** <https://docs.varbase.vardot.com/10.1.x/developers/varbase-patches>

## What it does

1. Ships a curated `extra.patches` list (issue / MR diffs vetted by Vardot) for Drupal core and contrib modules used by Varbase 10.1.
2. Wraps `cweagans/composer-patches` v2 to add three features missing from upstream v2:
   - **Wildcard** `ignore-dependency-patches` (e.g. `drupal/*`).
   - **Allowlist** `allowed-dependency-patches` — only listed packages contribute dependency-declared patches. Default: `["vardot/varbase-patches"]`.
   - **`patches-ignore`** restored from cweagans v1 — drop a specific URL declared by a given dependency.
3. Provides Composer commands (`var-ccup`, `var-ccupf`) to convert remote merge-request URLs into timestamped local `.patch` files under `./patches/`.

## Why

Drupal contrib modules sometimes ship `extra.patches` entries pointing at stale or third-party patch URLs. With `composer-exit-on-patch-failure: true`, one bad URL aborts the whole install. Upstream cweagans v2 only supports exact-match exclusions and dropped v1's `patches-ignore`, so blocking those patches required enumerating every package by name. This plugin restores wildcard control and adds a default-deny allowlist so only Vardot-curated patches apply.

## Contents

- [Installation](installation.md)
- [Configuration](configuration.md)
- [Commands](commands.md)
- [Architecture](architecture.md)
- [Migration from Drush](migration-from-drush.md)
- [Troubleshooting](troubleshooting.md)

## AI assistant context (in-repo)

This repository ships its own AI-assistant context so contributors get the same project conventions as core maintainers, without needing access to any internal tooling:

- [`../AGENTS.md`](../AGENTS.md) — vendor-neutral entry point. Read this first regardless of which AI coding tool you use (Claude Code, Cursor, Codex, Aider, Continue.dev, Copilot Workspace, …). Captures the non-obvious constraints (late-activation rule, dual v1/v2 support, default-deny allowlist, filename convention).
- [`../CLAUDE.md`](../CLAUDE.md) — Claude Code-specific entry point. Points at the sub-agent and skills below.
- [`../.claude/agents/varbase-patches.md`](../.claude/agents/varbase-patches.md) — Claude sub-agent for installing, configuring, and troubleshooting `vardot/varbase-patches`.
- [`../.claude/skills/composer-patches/SKILL.md`](../.claude/skills/composer-patches/SKILL.md) — `cweagans/composer-patches` v1 / v2 + this plugin's allowlist / wildcard ignore / `patches-ignore` extensions.
- [`../.claude/skills/patch-management/SKILL.md`](../.claude/skills/patch-management/SKILL.md) — authoring, re-rolling, filename convention, and the Composer-native cleanup commands (`var-ccup` / `var-ccupf`).


## Patch filename convention

```
[package name]--[Date]--[issue number]--[MR number].patch
```

Examples:

- `drupal-core--2026-05-10--3539178--mr-12890.patch`
- `ctools--2026-05-10--3572317--mr-85.patch`

Static, timestamped local files give reproducible builds; raw MR URLs change as commits are added and break checksums mid-install.

## All branches at a glance

| Branch       | Drupal core | Use with                          | External docs                                                              |
|--------------|-------------|-----------------------------------|----------------------------------------------------------------------------|
| `11.0.x`     | `~11.3.0`   | Varbase `~11.0.0`, Drupal 11      | <https://docs.varbase.vardot.com/11.0.x/developers/varbase-patches>        |
| `10.1.x`     | `~11.3.0`   | Varbase `~10.1.0`                 | <https://docs.varbase.vardot.com/10.1.x/developers/varbase-patches>        |
| `10.0.x`     | `~10.6.0`   | Varbase `~10.0.0`                 | <https://docs.varbase.vardot.com/10.0.x/developers/varbase-patches>        |
| `9.2.x`      | `~10.6.0`   | Varbase `~9.2.0`                  | <https://docs.varbase.vardot.com/9.2.x/developers/varbase-patches>         |
| `9.1.x`      | `~10.6.0`   | Varbase `~9.1.0`                  | <https://docs.varbase.vardot.com/9.1.x/developers/varbase-patches>         |
| `no-patches` | n/a         | Plugin only, empty `extra.patches`| —                                                                          |
| `patches`    | n/a         | Patch files only, do not require  | —                                                                          |

To run with no Vardot patches and manage your own list, require the `no-patches` branch (`vardot/varbase-patches: dev-no-patches`) — plugin still active, allowlist still enforced, but the curated list is empty.
