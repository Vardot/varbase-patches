# Varbase Patches

Composer plugin. Curated patch list for Varbase dependencies + filtering on top of `cweagans/composer-patches` v2.

## What it does

1. Ships a curated `extra.patches` list (issue/MR diffs vetted by Vardot) for Drupal core and contrib modules used by Varbase.
2. Wraps `cweagans/composer-patches` v2 to add three features missing from upstream v2:
   - **Wildcard** `ignore-dependency-patches` (e.g. `drupal/*`).
   - **Allowlist** `allowed-dependency-patches` — only listed packages contribute dependency-declared patches. Default: `["vardot/varbase-patches"]`.
   - **`patches-ignore`** restored from cweagans v1 — drop a specific URL declared by a given dependency.
3. Provides Composer commands to convert remote merge-request URLs in your `composer.json` (or `patches-file` JSON) into timestamped local `.patch` files under `./patches/`.

## Why

Drupal contrib modules sometimes ship `extra.patches` entries pointing at stale or third-party patch URLs. With `composer-exit-on-patch-failure: true`, one bad URL aborts the whole install. Upstream cweagans v2 only supports exact-match exclusions and dropped v1's `patches-ignore`, so blocking those patches required enumerating every package by name. This plugin restores wildcard control and adds a default-deny allowlist so only Vardot-curated patches apply.

## Index

- [Installation](installation.md)
- [Configuration](configuration.md)
- [Commands](commands.md)
- [Architecture](architecture.md)
- [Migration from Drush](migration-from-drush.md)
- [Troubleshooting](troubleshooting.md)

## Versions

| Branch       | Drupal core   | Notes                              |
|--------------|---------------|------------------------------------|
| `11.0.x`     | `~11.3.0`     | Composer plugin                    |
| `10.1.x`     | `~11.3.0`     | Composer plugin                    |
| `10.0.x`     | `~10.6.0`     | Composer plugin                    |
| `9.2.x`      | `~10.6.0`     | Composer plugin                    |
| `9.1.x`      | `~10.6.0`     | Composer plugin                    |
| `no-patches` | n/a           | Plugin only, empty `extra.patches` |
| `patches`    | n/a           | Patch files only, do not install   |

Use `"vardot/varbase-patches": "~11.0.0"` with **Varbase `~11.0.0`** and **Drupal 11**.

To run with no Vardot patches and manage your own list, require the `no-patches` branch (`vardot/varbase-patches: dev-no-patches`) — plugin still active, allowlist still enforced, but Vardot's curated list is empty.
