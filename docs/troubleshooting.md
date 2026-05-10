# Troubleshooting

## `No available patcher was able to apply patch <url> to drupal/<x>`

A dependency has declared a patch in its own `extra.patches` that no longer applies (file path drift, target package version mismatch, etc.). With `composer-exit-on-patch-failure: true`, Composer aborts.

**Fix:** confirm the offending patch comes from a non-Vardot dependency (see `Resolving patches from dependencies` log lines), then make sure your config keeps the default allowlist:

```json
"extra": {
  "composer-patches": {
    "allowed-dependency-patches": ["vardot/varbase-patches"]
  }
}
```

Re-run:

```bash
rm -rf composer.lock patches.lock.json vendor/
composer install
```

If the failing patch is from `vardot/varbase-patches` itself, drop it explicitly via `patches-ignore`:

```json
"extra": {
  "patches-ignore": {
    "vardot/varbase-patches": {
      "drupal/<target>": ["<full url>"]
    }
  }
}
```

## Plugin not loading

Symptoms: install runs, but log does not show

```
varbase-patches: re-resolving patches with filter (allowed: vardot/varbase-patches).
```

Checklist:

1. `vardot/varbase-patches` is in `config.allow-plugins` with value `true`.
2. `cweagans/composer-patches` is `~2.0` (the plugin requires v2 API). Run `composer show cweagans/composer-patches` to verify.
3. Re-run with verbosity: `composer install -vvv 2>&1 | grep -E "Loading plugin (Vardot|cweagans)"`. You should see both. If only cweagans loads, the package itself never installed — check `composer show vardot/varbase-patches`.

## Wildcard in `ignore-dependency-patches` does nothing

Confirm you're on a v2-plugin release of `vardot/varbase-patches` (any current `11.0.x` / `10.x` / `9.x` HEAD or `no-patches`). The metapackage releases do not provide the wildcard support — it requires this plugin code path.

## Cleanup command writes HTML instead of a diff

Some hosts gate `.diff` URLs behind a login/JS check when called with browser-style user agents. The plugin uses `varbase-patches/1.0` + `Accept: text/plain, text/x-diff, */*` which works for `git.drupalcode.org`. If you hit a host that still returns HTML, fetch the raw patch yourself and store it under `./patches/` directly — the cleanup commands are a convenience, not a requirement.

## Patches still apply after I removed an entry from `composer.json`

`patches.lock.json` is the authoritative list at install/update time. Delete it and re-run:

```bash
rm patches.lock.json
composer install
```

`composer.lock` only locks package versions, not the patch list.
