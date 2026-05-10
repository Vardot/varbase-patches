# Migration from Drush commands

Earlier Varbase releases shipped two Drush commands inside `varbase_core` for cleaning up merge-request patches. They have been moved into `vardot/varbase-patches` as Composer commands.

## Mapping

| Old Drush command                          | Old alias    | New Composer command                       | New alias    |
|--------------------------------------------|--------------|--------------------------------------------|--------------|
| `varbase:composer:cleanup:patches`         | `var-ccup`   | `composer varbase-patches:cleanup:patches` | `var-ccup`   |
| `varbase:composer:cleanup:patches-file`    | `var-ccupf`  | `composer varbase-patches:cleanup:patches-file` | `var-ccupf` |

The Composer aliases are the same as the Drush ones, so existing scripts that called e.g. `drush var-ccup` only need to change to `composer var-ccup`.

## Behavior changes

- **No Drupal bootstrap required.** Old commands needed a working site (`drush` had to bootstrap Drupal). New commands run from any directory with a `composer.json`, including in CI before any DB exists.
- **Project root detection.** Old code used `$this->getConfig()->get('runtime.project')` (Drush). New code uses `getcwd()` by default and accepts `--project-dir=<path>` to override.
- **HTTP user-agent.** Old code used a 2008-era Firefox UA which GitLab now answers with HTML instead of the diff. New code uses `varbase-patches/1.0` and `Accept: text/plain, text/x-diff, */*`, which returns the raw diff.
- **Output.** Same human-readable lines (`Processed the patch …`, `From: …`, `To: …`, separator), but emitted via Composer's `OutputInterface` instead of Drush's logger.

## Removing the old commands

If you still ship `varbase_core` with the old Drush command file, you can remove the `mergeRequestPatchesCleanup()` and `mergeRequestPatchesFileCleanup()` methods from `src/Drush/Commands/VarbaseCoreCommands.php` once you have upgraded to a `vardot/varbase-patches` release that includes the plugin commands. The other commands in that file (`varbase:remove-non-existent-permissions`, `varbase:entity-update`) are unrelated to patches and should stay.
