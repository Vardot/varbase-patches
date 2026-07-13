# Tests — `vardot/varbase-patches` (11.0.x)

Two checks, run by [`.github/workflows/test-patches.yml`](../.github/workflows/test-patches.yml) on every push and pull request to this branch, and weekly on a schedule.

## 1. The patch files still physically exist

```bash
git fetch --depth=1 https://github.com/Vardot/varbase-patches.git patches:refs/remotes/upstream/patches
php tests/verify-patch-files.php upstream/patches
```

For every URL in this branch's `composer.json` → `extra.patches`:

- the URL must return HTTP 200 with a non-empty body,
- the body must be a unified diff, and
- if it is served from this repository's `patches` branch, the file must also exist in that branch of the canonical repository — the CDN happily serves a cached copy of a file that was deleted.

This is what catches a patch file that vanished from Drupal.org or was removed from the `patches` branch.

## 2. Composer Patches applies every Varbase patch

```bash
mkdir -p tests/build
cp tests/test.composer.json tests/build/composer.json
composer --working-dir=tests/build install 2>&1 | tee tests/build/install.log
php tests/verify-applied-patches.php tests/build tests/build/install.log
```

[`test.composer.json`](test.composer.json) is an ordinary Drupal project: it requires `drupal/core-recommended`, the modules this branch declares patches for (at the constraints Varbase uses), and `vardot/varbase-patches` itself from the checkout through a `path` repository. `composer install` therefore exercises the real plugin — allowlist, late activation, `cweagans/composer-patches` — against real packages.

The install runs with `exit-on-patch-failure`, so a patch that no longer applies already fails the build. On top of that, `verify-applied-patches.php` asserts that **every** patch declared for an installed package was actually applied (evidence: `patches.lock.json` for Composer Patches v2, the patch URL in the install log for v1), so a patch that is silently skipped — filtered out by the allowlist, dropped by a resolver bug — fails too.

Every package this branch patches is installed by the test project.

CI runs the install twice, once against `cweagans/composer-patches` `~2.0` and once against `~1.7.0`, because the plugin must keep working with both.
