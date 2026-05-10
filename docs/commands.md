# Composer Commands

The plugin registers two Composer commands. They walk patch URLs, detect GitLab merge-request links, download the `.diff` to a local file under `./patches/`, and rewrite the JSON entry to the local path.

## `varbase-patches:cleanup:patches`

Alias: `var-ccup`

Operates on `extra.patches` in the root `composer.json`.

```bash
composer varbase-patches:cleanup:patches
```

### Options

| Option          | Description                                     |
|-----------------|-------------------------------------------------|
| `--project-dir` | Override the project root. Defaults to `getcwd()`. |

## `varbase-patches:cleanup:patches-file`

Alias: `var-ccupf`

Operates on the JSON file referenced by `extra.patches-file` in the root `composer.json`.

```bash
composer varbase-patches:cleanup:patches-file
```

Same `--project-dir` option as above.

## What gets detected

URLs containing `/-/merge_requests/` (GitLab MR `.diff`/`.patch` links). Plain `.patch` URLs (e.g. `drupal.org/files/issues/...`) and already-local paths (e.g. `./patches/foo.patch`) are left untouched.

## Filename convention

```
<package-slug>--YYYY-MM-DD--<issue-id>--mr-<mr-id>.patch
```

- `<package-slug>` — `drupal-core` for `drupal/core`, otherwise the part after `drupal/` (e.g. `ctools`).
- `YYYY-MM-DD` — date of the cleanup run.
- `<issue-id>` — first `#NNNN` found in the patch description; omitted if absent.
- `<mr-id>` — `mr-<digits>` parsed from the URL; falls back to `mr` if no digits found.

Examples:

```
drupal-core--2026-05-10--3080606--mr-4075.patch
ctools--2026-05-10--3572317--mr-85.patch
redirect--2026-05-10--2879648--mr-109.patch
```

## Behavior

- Creates `./patches/` if missing.
- Skips entries already pointing at local paths or non-MR URLs.
- Re-running with no MR URLs left prints `No merge request patches were found ...` and exits 0 (idempotent).
- On HTTP failure or write failure, logs and skips that entry; other entries continue.

## Exit codes

| Code | Meaning                                              |
|------|------------------------------------------------------|
| `0`  | Success (including the no-op case).                  |
| `1`  | `composer.json` (or referenced `patches-file`) missing or invalid. |

## Example workflow

1. While developing, link a GitLab MR diff in `composer.json`:

   ```json
   "extra": {
     "patches": {
       "drupal/ctools": {
         "fix: #3572317 ctools_views schema alter": "https://git.drupalcode.org/project/ctools/-/merge_requests/85.diff"
       }
     }
   }
   ```

2. When the MR is stable, freeze it locally:

   ```bash
   composer varbase-patches:cleanup:patches
   ```

3. The entry is rewritten to a stable, in-repo file:

   ```json
   "drupal/ctools": {
     "fix: #3572317 ctools_views schema alter": "./patches/ctools--2026-05-10--3572317--mr-85.patch"
   }
   ```

4. Commit `./patches/ctools--…--mr-85.patch` and the updated `composer.json`. Future installs use the frozen file — no dependency on the live MR branch.
