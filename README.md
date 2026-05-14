# Varbase Patches

[![Total Downloads](https://img.shields.io/packagist/dt/vardot/varbase-patches.svg)](https://packagist.org/packages/vardot/varbase-patches)
[![License](https://img.shields.io/packagist/l/vardot/varbase-patches.svg)](LICENSE)

List of needed patches for Varbase used packages with Composer Patches.

Composer plugin and curated patch list for [Varbase](https://www.drupal.org/project/varbase). Built on top of [`cweagans/composer-patches`](https://github.com/cweagans/composer-patches) v2 with three additions that v2 dropped or never had:

- **Wildcard** `ignore-dependency-patches` (e.g. `drupal/*`).
- **Allowlist** `allowed-dependency-patches` — only listed packages contribute dependency-declared patches. Defaults to `["vardot/varbase-patches"]`.
- **`patches-ignore`** restored from cweagans v1 — drop a specific URL declared by a given dependency.

Plus two Composer commands to convert remote merge-request URLs into local timestamped patch files (`./patches/<package>--YYYY-MM-DD--<issue>--mr-<n>.patch`).

## Quick start

```bash
composer require vardot/varbase-patches:~11.0.0
```

```json
{
  "config": {
    "allow-plugins": {
      "cweagans/composer-patches": true,
      "vardot/varbase-patches": true
    }
  },
  "extra": {
    "enable-patching": true,
    "composer-exit-on-patch-failure": true,
    "composer-patches": {
      "allowed-dependency-patches": ["vardot/varbase-patches"]
    },
    "patches": {}
  }
}
```

```bash
composer install
```

Result: only patches declared by `vardot/varbase-patches` (and your project's own `extra.patches`) apply. Patches declared by other dependencies are skipped — no more aborted installs from stale third-party `.patch` URLs.

## Versions

| Branch       | Drupal core | Use with                     |
|--------------|-------------|------------------------------|
| `11.0.x`     | `~11.3.0`   | Varbase `~11.0.0`, Drupal 11 |
| `10.1.x`     | `~11.3.0`   | Varbase `~10.1.0`            |
| `10.0.x`     | `~10.6.0`   | Varbase `~10.0.0`            |
| `9.2.x`      | `~10.6.0`   | Varbase `~9.2.0`             |
| `9.1.x`      | `~10.6.0`   | Varbase `~9.1.0`             |
| `no-patches` | n/a         | Plugin only, manage your own list |

The `patches` branch carries patch files only — do not require it.

## Composer commands

The plugin registers two Composer commands to convert remote GitLab merge-request URLs in your patch lists into local timestamped `.patch` files under `./patches/`. They replace the Drush commands previously shipped in `varbase_core` (see [docs/migration-from-drush.md](docs/migration-from-drush.md)).

### Clean up the root `composer.json` file

- **Name:** `varbase-patches:cleanup:patches`
- **Aliases:** `var-ccup`
- **Description:** Detects any merge request patches in the root `composer.json` `extra.patches` block, downloads them to the local `./patches/` folder with a timestamped filename, and updates the root `composer.json` to use the local patch file.

```bash
composer varbase-patches:cleanup:patches
```

or

```bash
composer var-ccup
```

### Clean up the external `patches-file` JSON file

- **Name:** `varbase-patches:cleanup:patches-file`
- **Aliases:** `var-ccupf`
- **Description:** Detects any merge request patches in the JSON file referenced by `extra.patches-file`, downloads them to the local `./patches/` folder with a timestamped filename, and rewrites the patches-file JSON to use the local patch file.

```bash
composer varbase-patches:cleanup:patches-file
```

or

```bash
composer var-ccupf
```

## Handling Varbase Patches Ignoring

To exclude a specific patch declared by `vardot/varbase-patches` (e.g. when you want to replace it with an improved version, or skip it entirely), add a `patches-ignore` block to your root `composer.json`:

```json
{
  "extra": {
    "patches-ignore": {
      "vardot/varbase-patches": {
        "drupal/core": {
          "Issue #2869592: Disabled update module shouldn't produce a status report warning":
          "https://www.drupal.org/files/issues/2869592-remove-update-warning-7.patch"
        }
      }
    }
  }
}
```

Schema: `{ "<source-pkg>": { "<target-pkg>": { "<description>": "<url>" } } }`. Matching is done by URL — the description string is informational. A flat array of URLs (`{ "<source-pkg>": { "<target-pkg>": ["<url>", ...] } }`) is also accepted.

This is the v1-style `patches-ignore` from `cweagans/composer-patches`, restored by this plugin on top of v2.

### Filename convention

```
[package name]--[Date]--[issue number]--[MR number].patch
```

Examples:

- `drupal-core--2026-05-10--3539178--mr-12890.patch`
- `ctools--2026-05-10--3572317--mr-85.patch`
- `redirect--2026-05-10--2879648--mr-109.patch`

## Documentation

- [Overview](docs/README.md)
- [Installation](docs/installation.md)
- [Configuration](docs/configuration.md)
- [Commands](docs/commands.md)
- [Architecture](docs/architecture.md)
- [Migration from Drush](docs/migration-from-drush.md)
- [Troubleshooting](docs/troubleshooting.md)

External: <https://docs.varbase.vardot.com/developers/varbase-patches>

## AI assistant context

This repository ships its own AI-assistant context so contributors get the same project conventions as core maintainers:

- [`AGENTS.md`](AGENTS.md) — vendor-neutral entry point. Works with any AI coding assistant (Claude Code, Cursor, Codex, Aider, Continue.dev, Copilot Workspace, …).
- [`CLAUDE.md`](CLAUDE.md) — Claude Code-specific entry point.
- [`.claude/agents/varbase-patches.md`](.claude/agents/varbase-patches.md) — Claude sub-agent.
- [`.claude/skills/composer-patches/SKILL.md`](.claude/skills/composer-patches/SKILL.md), [`.claude/skills/patch-management/SKILL.md`](.claude/skills/patch-management/SKILL.md) — Claude skills.

## Requirements

- PHP `>=8.1`
- `composer-plugin-api ^2.0`
- `cweagans/composer-patches ~2.0`

## License

GPL-2.0-or-later. See [LICENSE](LICENSE).

## Maintainer

[Vardot](https://www.drupal.org/vardot) — <https://github.com/vardot>
