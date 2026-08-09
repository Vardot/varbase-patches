---
name: varbase-patches
description: Apply and manage patches using cweagans/composer-patches (v1 / v2) for Drupal projects, and use the vardot/varbase-patches Composer plugin's allowlist, wildcard ignore, and patches-ignore extensions on top of v2. Use when applying patches to Drupal core or contrib, configuring composer.json patch blocks, handling patch failures, or integrating with Varbase patches.
---

# Composer Patches

Apply and manage patches using `cweagans/composer-patches` for Drupal projects. Covers v1, v2, and the `vardot/varbase-patches` plugin that wraps v2 with extra controls.

## Prerequisites

- Composer 2.x.
- `cweagans/composer-patches: ~1.7.0 || ~2.0`, declared in `require` and allowed in `config.allow-plugins`.

## Enable patching

```json
{
  "config": {
    "allow-plugins": {
      "cweagans/composer-patches": true
    }
  },
  "extra": {
    "enable-patching": true,
    "composer-exit-on-patch-failure": true
  }
}
```

`composer-exit-on-patch-failure: true` is the safer default — silent patch failures hide regressions until production.

## Declare patches

### Inline (`extra.patches`)

```json
{
  "extra": {
    "patches": {
      "drupal/module_name": {
        "Issue #1234567: Description of the fix": "patches/module_name--2026-05-10--1234567--mr-42.patch"
      }
    }
  }
}
```

### External patches-file

```json
{
  "extra": {
    "patches-file": "composer.patches.json"
  }
}
```

`composer.patches.json` follows the same `{ "<pkg>": { "<description>": "<url>" } }` shape as the inline `patches` block.

### Patch sources

- Local files: `patches/module--fix.patch`
- Drupal.org issue files: `https://www.drupal.org/files/issues/<date>/<file>.patch`
- GitLab MR raw: `https://git.drupalcode.org/project/<name>/-/merge_requests/<n>.patch`
- GitHub commit / PR: `https://github.com/<org>/<repo>/commit/<sha>.patch`

Prefer **local, timestamped files** for production. Raw MR URLs change as commits are pushed to the MR and break Composer checksums mid-install.

## Filename convention (Varbase)

```
[package]--[YYYY-MM-DD]--[issue number]--[mr number].patch
```

Examples:

- `drupal-core--2026-05-10--3539178--mr-12890.patch`
- `ctools--2026-05-10--3572317--mr-85.patch`
- `ui_patterns--2023-12-17--3409221-3--mr-21.patch`

## v2-only controls

### `ignore-dependency-patches` — exact match (upstream v2)

```json
{
  "extra": {
    "composer-patches": {
      "ignore-dependency-patches": ["drupal/specific_module"]
    }
  }
}
```

Upstream v2 only matches by exact package name.

### Patch levels

```json
{
  "extra": {
    "patches": {
      "drupal/core": {
        "-p2": true
      }
    }
  }
}
```

## Extra controls from `vardot/varbase-patches`

`vardot/varbase-patches` is a Composer plugin (`type: composer-plugin`) layered on top of v2. It restores v1-style behaviors and adds wildcards.

### `allowed-dependency-patches` (allowlist, default-deny)

```json
{
  "extra": {
    "composer-patches": {
      "allowed-dependency-patches": ["vardot/varbase-patches"]
    }
  }
}
```

Only listed packages may contribute dependency-declared patches. Default: `["vardot/varbase-patches"]`. Net effect: only Vardot-curated patches and your project's own `extra.patches` apply — stale third-party `.patch` URLs in unrelated contrib modules are skipped.

### Wildcard `ignore-dependency-patches`

```json
{
  "extra": {
    "composer-patches": {
      "ignore-dependency-patches": ["drupal/*", "another/specific-package"]
    }
  }
}
```

`fnmatch`-style globbing. Applied after the allowlist.

### `patches-ignore` (v1-style, restored on v2)

Exclude one specific patch URL declared by a given dependency:

```json
{
  "extra": {
    "patches-ignore": {
      "vardot/varbase-patches": {
        "drupal/core": {
          "Issue description": "https://patch-url.patch"
        }
      }
    }
  }
}
```

Schema: `{ "<source-pkg>": { "<target-pkg>": { "<description>": "<url>" } } }`. Matching is done by URL — the description string is informational. A flat array of URLs (`{ "<source-pkg>": { "<target-pkg>": ["<url>", ...] } }`) is also accepted.

## Plugin Composer commands

Provided by `vardot/varbase-patches`. They replace the older Drush commands previously shipped in `varbase_core`.

```bash
# Rewrite remote MR URLs in root composer.json to local timestamped files under ./patches/
composer varbase-patches:cleanup:patches      # alias: composer var-ccup

# Same, but for the JSON file referenced by extra.patches-file
composer varbase-patches:cleanup:patches-file # alias: composer var-ccupf
```

## Examples

### Add a local patch

```json
{
  "extra": {
    "patches": {
      "drupal/paragraphs": {
        "Fix paragraph duplication issue": "patches/paragraphs--2026-05-10--duplication-fix.patch"
      }
    }
  }
}
```

### Apply and update

```bash
composer update drupal/paragraphs --with-dependencies
```

### Create a patch from a modified contrib checkout

```bash
cd web/modules/contrib/<module>
git diff > ../../../../patches/<module>--$(date +%Y-%m-%d)--fix.patch
```

### Verify before committing

```bash
git apply --check patches/<file>.patch
```

## Handling patch failures

- **Already applied** (upstream merged the fix): remove from `extra.patches`, or — for a patch declared by `vardot/varbase-patches` — add to `patches-ignore`.
- **Patch conflicts**: re-roll against the new module version, rename the file with a fresh `YYYY-MM-DD`, update the entry in `extra.patches`.
- **Stale third-party URL aborts install**: rely on the default allowlist (`["vardot/varbase-patches"]`) or add a wildcard `ignore-dependency-patches` (e.g. `drupal/*`).
- **`Failed to open stream` on fresh `composer create-project`**: a downstream plugin set `extra.plugin-modifies-downloads` or `extra.plugin-modifies-install-path` and got promoted to early activation before `drupal/core` was extracted. Drop those flags — `vardot/varbase-patches` uses late activation (POST_PACKAGE_INSTALL of itself) on purpose.

## Patch file integrity

- **Every `.patch` file ends with a trailing newline (`0x0a`).** Without it `git apply` returns
  `error: corrupt patch at line N` (exit 128) and `composer-patches` — which tries `git apply`
  first — fails the install with `Error: Cannot apply patch …!`, even though the diff is correct.
  GNU `patch` only survives it with fuzz, which is why a careless local check passes and CI still
  breaks.
- **Verify the served file, not your local copy**, after every upload:
  `curl -sS -o /tmp/p.patch "<raw url>" && wc -c < /tmp/p.patch && tail -c 1 /tmp/p.patch | xxd && git apply --check /tmp/p.patch`
  (last byte `0a`, `git apply --check` exit 0).
- **Never write repo files through shell/argument interpolation** — that is how a file ends up
  holding a literal local path string instead of its content, and it hits `composer.json` and
  `CHANGELOG.md` as easily as a `.patch`. Base64-encode the bytes into the blob (GitHub
  `POST /git/blobs` `encoding=base64`; GitLab commit actions `"encoding": "base64"`), then
  re-fetch the raw URL and diff it.
- **Re-run CI that predates the fix** (`gh run rerun <id> --failed`). A run started before the
  merge is still testing the broken file and proves nothing.

## Keep the patch minimal

- Carry only the hunks the consuming module actually needs. Measure it:
  `grep -rn "<PatchedClass>" web/modules/contrib/<consumer>/src/`
- A consumer usually depends on one or two extension points, not the whole feature the upstream
  merge request implements. Keep the full merge request upstream, carry the minimum downstream,
  and say so in the patch description — a smaller patch re-rolls cleanly.
- **Skip front-end hunks when the package ships a prebuilt bundle.** Patching front-end sources
  does nothing while `*.libraries.yml` loads a compiled `dist/` asset, and `composer install`
  restores the shipped bundle. Check with
  `grep -c "<symbol>" web/modules/contrib/<pkg>/<shipped bundle>` (0 = inert). Send those changes
  upstream instead.
- **Prove it locally BEFORE it goes into `vardot/varbase-patches`.** Never merge the patch file
  first and test afterwards — once it is on the `patches` branch, every consuming project picks it
  up. Prove on a pristine checkout: `rm -rf web/modules/contrib/<pkg> && ddev composer install`.
  A tree that already has the patch reports `Reversed (or previously applied) patch detected!`,
  which is neither a pass nor a fail. Then verify the behaviour — "applied" is not "works".

## Re-rolling: update the upstream merge request and its issue too

A re-roll is never only a downstream file — the upstream merge request it came from is by
definition out of date. In the same piece of work:

- Update the upstream merge request so its branch applies to the current release. A patch we carry
  that upstream can no longer merge is a patch we carry forever.
- Update the drupal.org issue: what changed, which version it was re-rolled against, what was
  verified; keep the remaining-tasks marks honest.
- If the downstream patch was reduced to a subset of the merge request, say so on both the merge
  request and the issue, and record what was dropped and why.
- Unrelated fixes that fell out of the re-roll need their own issues, not a ride-along.

## See also

- Agent: `varbase-patches` — end-to-end Varbase patches workflows by version.
- [Varbase Patches repo](https://github.com/Vardot/varbase-patches)
- [cweagans/composer-patches](https://github.com/cweagans/composer-patches)
