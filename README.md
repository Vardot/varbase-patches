# Varbase Patches

[![Total Downloads](https://img.shields.io/packagist/dt/vardot/varbase-patches.svg)](https://packagist.org/packages/vardot/varbase-patches)
[![License](https://img.shields.io/packagist/l/vardot/varbase-patches.svg)](LICENSE)

Composer plugin and curated patch list for [Varbase](https://www.drupal.org/project/varbase).

Built on top of [`cweagans/composer-patches`](https://github.com/cweagans/composer-patches) v2 with three additions that v2 dropped or never had:

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

## Commands

| Command                                | Alias       | Description                                                |
|----------------------------------------|-------------|------------------------------------------------------------|
| `composer varbase-patches:cleanup:patches`      | `var-ccup`  | Freeze MR URLs in root `extra.patches` to local files.     |
| `composer varbase-patches:cleanup:patches-file` | `var-ccupf` | Freeze MR URLs in the file referenced by `extra.patches-file`. |

These replace the Drush commands previously shipped in `varbase_core`. See [docs/migration-from-drush.md](docs/migration-from-drush.md).

## Documentation

- [Overview](docs/index.md)
- [Installation](docs/installation.md)
- [Configuration](docs/configuration.md)
- [Commands](docs/commands.md)
- [Architecture](docs/architecture.md)
- [Migration from Drush](docs/migration-from-drush.md)
- [Troubleshooting](docs/troubleshooting.md)

External: <https://docs.varbase.vardot.com/developers/varbase-patches>

## Requirements

- PHP `>=8.1`
- `composer-plugin-api ^2.0`
- `cweagans/composer-patches ~2.0`

## License

GPL-2.0-or-later. See [LICENSE](LICENSE).

## Maintainer

[Vardot](https://www.drupal.org/vardot) — <https://github.com/vardot>
