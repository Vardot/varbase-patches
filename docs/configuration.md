# Configuration

All keys live under `extra` in your project's root `composer.json`.

## `composer-patches.allowed-dependency-patches`

List of package-name patterns. Only packages matching this list contribute patches via the dependency resolver.

- Type: array of strings
- Pattern: `fnmatch` (so `drupal/*`, `vardot/*`, `*-patches` all work)
- Default: `["vardot/varbase-patches"]`

```json
{
  "extra": {
    "composer-patches": {
      "allowed-dependency-patches": [
        "vardot/varbase-patches",
        "vardot/drupal-core-patches"
      ]
    }
  }
}
```

If you want to also accept patches from another vendor:

```json
{
  "extra": {
    "composer-patches": {
      "allowed-dependency-patches": [
        "vardot/varbase-patches",
        "myorg/myorg-patches"
      ]
    }
  }
}
```

## `composer-patches.ignore-dependency-patches`

List of package-name patterns to exclude **after** the allowlist is applied. Useful when you widen the allowlist with a wildcard and need to carve out exceptions.

- Type: array of strings
- Pattern: `fnmatch`
- Default: `[]`

```json
{
  "extra": {
    "composer-patches": {
      "allowed-dependency-patches": ["drupal/*", "vardot/*"],
      "ignore-dependency-patches": ["drupal/ai_context"]
    }
  }
}
```

When `allowed-dependency-patches` is set to the default `["vardot/varbase-patches"]`, `ignore-dependency-patches` is redundant — nothing else passes the allowlist.

## `patches-ignore`

Drop specific patch URLs declared by a given dependency against a given target package. Restored from `cweagans/composer-patches` v1.

- Type: nested object
- Default: `{}`

Two equivalent schemas are accepted. The v1-style description-keyed map (matches the format used in the upstream Varbase docs):

```json
{
  "extra": {
    "patches-ignore": {
      "vardot/varbase-patches": {
        "drupal/recaptcha": {
          "fix: #3588269 Make Drupal8Post::submit() compatible with parent":
          "https://git.drupalcode.org/project/recaptcha/-/commit/68b0f86d1e930ed78f795a97a2fc207be35b3260.diff"
        }
      }
    }
  }
}
```

Or a flat array of URLs:

```json
{
  "extra": {
    "patches-ignore": {
      "vardot/varbase-patches": {
        "drupal/some_module": [
          "https://www.drupal.org/files/issues/.../some.patch"
        ]
      }
    }
  }
}
```

Matching is done by URL string. The description (if you use the dict form) is informational only — `vardot/varbase-patches` and the consumer can disagree on the description and the URL still matches.

### Ignoring Drupal Core Patches

`vardot/drupal-core-patches` is an ordinary dependency that contributes patches through the dependency resolver, so the same `extra` keys control it — use `vardot/drupal-core-patches` as the **source** package and `drupal/core` as the **target**:

```json
{
  "extra": {
    "patches-ignore": {
      "vardot/drupal-core-patches": {
        "drupal/core": {
          "Issue #3606822: ContainerBuilder synthetic kernel on install": "https://git.drupalcode.org/project/drupal/-/merge_requests/16159.patch"
        }
      }
    }
  }
}
```

Matching is by URL string, the same as for `vardot/varbase-patches`.

## Standard `cweagans/composer-patches` keys (still honored)

```json
{
  "extra": {
    "enable-patching": true,
    "composer-exit-on-patch-failure": true,
    "patches-file": "patches.json",
    "patches": {
      "drupal/some_module": {
        "Issue #1234567: …": "https://www.drupal.org/files/issues/.../patch.patch"
      }
    }
  }
}
```

The `patches-file` JSON has the same shape as the `patches` block at root level (just nested under a `patches` key), and is also walked by the [cleanup commands](commands.md).

## Resolution order

1. **Root** `extra.patches` — always honored (handled by cweagans `RootComposer` resolver, not filtered).
2. **Patches file** — always honored.
3. **Dependencies** `extra.patches` — filtered by this plugin: pass `allowed-dependency-patches`, then drop `ignore-dependency-patches`, then drop URLs listed in `patches-ignore`.
