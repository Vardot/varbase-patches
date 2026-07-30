# Changelog — Vardot/varbase-patches (`11.0.x`)

All notable changes on the `11.0.x` branch of [`Vardot/varbase-patches`](https://github.com/Vardot/varbase-patches), newest first.
Each release lists the commits — merged pull requests and the drupal.org issues they reference — since the previous release.
`#N` links to the pull request; 7-digit `#NNNNNNN` refs are drupal.org issues. Generated from git history.

## [Unreleased]

- Change a patch for the Drupal Canvas module on feat: #3567225 Allow per-node override of Content Template via checkbox in node selector -- re-rolled to add the tolerance guard in `CanvasConfigUpdater::blockComponentInstanceId()`, without which canvas 1.9.0 aborts a site template install with `UnexpectedValueException: Missing component source` when a recipe installs a content template before the Component entities its tree references exist ([#3567225](https://git.drupalcode.org/project/canvas/-/work_items/3567225))

- Add a patch for the Drupal Canvas module on fix: #3560889 JsComponent crash renders Canvas Editor unusable when Image Props have relative example URLs ([#3560889](https://git.drupalcode.org/project/canvas/-/work_items/3560889))

- Add a patch for the Drupal Canvas module on fix: #3591751 Compile on serve when a code component's compiled JS is empty ([#3591751](https://git.drupalcode.org/project/canvas/-/work_items/3591751))

- Add a patch for the Drupal Canvas module on fix: #3591876 Canvas AI: page builder discards the whole build when the LLM names a region that does not exist ([#3591876](https://git.drupalcode.org/project/canvas/-/work_items/3591876))

- Change a patch for the Drupal Canvas module on feat: #3567225 Allow per-node override of Content Template via checkbox in node selector -- re-rolled against canvas 1.9.0 (canvas 1.8.0's patch failed to apply once a fresh `composer update` resolves canvas 1.9.0) ([#3567225](https://git.drupalcode.org/project/canvas/-/work_items/3567225))

## [11.0.32] - 2026-07-28

- Add a patch for the Tagify module on fix: #3555084 Exposed filter tag input missing label; add aria-labelledby to Tagify input and propagate to contenteditable -- re-rolled against tagify 1.2.53 (credits MR !177 by Ethan Teague) ([#3555084](https://git.drupalcode.org/project/tagify/-/work_items/3555084))

## [11.0.30] - 2026-07-26

- Remove all patches for the CTools (Chaos Tool Suite) module on fix: #3492432 PHP 8.4 nullable types in MaskContentEntityStorage::doLoadMultiple() and fix: #3572317 ctools_views schema alter missing requiredKey for views_block mapping keys causes validation errors in Drupal Canvas (both fixed upstream, released in ctools 4.1.1) (#552)

## [11.0.29] - 2026-07-22

- Remove a patch for the AI (Artificial Intelligence) module on fix: #3586589 Do not assume action definitions have a type when deriving action plugin functions (fixed upstream, released in drupal/ai 1.4.5) (#549)

## [11.0.28] - 2026-07-20

- Remove a patch for the CKEditor Media Resize module on chore: #3607786 Add Drupal Core ~11.4.0 support in the CKEditor Media Resize module on the 1.1.x branch -- no longer needed, `drupal/varbase_editor_base` (1.0.0-beta3) now requires the `vardot/ckeditor_media_resize` fork (`~2.0.0`), which carries Drupal core ~11.4.0 support natively and `replace`s `drupal/ckeditor_media_resize`

## [11.0.27] - 2026-07-20

- Fix the allow-list surviving a broken third-party dependency patch on fresh builds - stop caching a negative cweagans/composer-patches version detection, and document the lock-less bootstrap window with its `patches.lock.json` bridge in the README and AGENTS.md (#541)
- Add a patch for the AI Context module on fix: #3586336 Remove the Drupal Canvas patch from the package (#544)

## [11.0.26] - 2026-07-16

- Add a patch for the CKEditor Media Resize module on chore: #3607786 Add Drupal Core ~11.4.0 support in the CKEditor Media Resize module on the 1.1.x branch (#533)

## [11.0.25] - 2026-07-16

- Remove a patch for the AI Provider amazee.ai module on fix: #3586236 Do not abort recipe apply when amazee.ai trial provisioning fails (fixed upstream in 1.3.3) (#522)

## [11.0.24] - 2026-07-14

- Add a patch for the AI (Artificial Intelligence) module on fix: #3586589 Do not assume action definitions have a type when deriving action plugin functions

## [11.0.23] - 2026-07-13

- Add a patch for the AI Provider amazee.ai module on fix: #3586236 Do not abort recipe apply when amazee.ai trial provisioning fails (#499)
- ci: Add a GitHub Actions patches test — installs Drupal and the modules this branch patches from `tests/test.composer.json`, asserts Composer Patches (v1 and v2) applies every Varbase patch, and checks that every patch file still exists

## [11.0.21] - 2026-07-10

- Change a patch for the Drupal Canvas module on fix: #3591751 Compile JSX server-side for AI-created/edited code components (fixes [object Object]) -- re-rolled against Canvas 1.8.0 (#478)
- Change a patch for the Drupal Canvas module on feat: #3567225 Allow per-node override of Content Template via checkbox in node selector -- re-rolled against Canvas 1.8.0 (#477)
- docs: lock the patch issue/PR title standard in the agent docs (#480)

## [11.0.20] - 2026-07-06

- Add a patch for the Redirect module on Drupal 11.4 compatibility for RedirectPathProcessorManager (#3607821) (#420)
- docs: Add the contribution workflow to the varbase-patches agent (#422)
- Revert "Add a patch for the Redirect module on Drupal 11.4 compat: PathProcessorManager::addInbound() removed (constructor-injected autowired path processors), applied after Issue #2879648 mr-109"
- Add a patch for the Redirect module on Drupal 11.4 compat: PathProcessorManager::addInbound() removed (constructor-injected autowired path processors), applied after Issue #2879648 mr-109
- docs: Add CHANGELOG.md for the 11.0.x branch (#432)
- fix: #446 Remove the openapi_jsonapi #3539722 patch on 11.0.x (fixed upstream in 3.x) (#447)
- fix: add the eca_helper #3608313 patch on the 11.0.x branch (same patch file as 10.1.x) (#454)
- fix: Point the redirect patch at #2879648 MR!202 and drop the superseded #3607821 patch (Drupal 11.4 RedirectPathProcessorManager)
- Change a patch for the Rabbit Hole module for Fix Return value must be of type bool fatal error (#3419073) — for Varbase 11.0.x (#465)

## [11.0.19] - 2026-06-30

- fix: #3607044 Chat: requests rejected when the conversation ends with a non-user (assistant/system) message (#414)
- fix: #3586043 Array to string conversion in Token::doReplace() when a dynamical token value is an array (applyTokens) (#413)
- fix: #3591751 Compile JSX server-side for AI-created/edited code components (fixes [object Object]) (#415)
- docs: document drupal-core-patches and update the patch-ignore guidance (#409)

## [11.0.18] - 2026-06-28

- Change a patch for the Drupal Canvas module on feat: #3567225 Allow per-node override of Content Template via checkbox in node selector #404
- fix: remove non-applying canvas patch (#3591716 mr-1285) — base blob drifted in canvas dev
- docs: document the smart core-patching workflow in AGENTS.md/CLAUDE.md

## [11.0.17] - 2026-06-28

- docs: PR/MR template with Checkpoints (no UX/UI line)
- fix: [11.0.x] apply vardot/drupal-core-patches by default (allowed-dependency-patches) (#394)
- task: require vardot/drupal-core-patches (~11 || ~12); move drupal/core patches out (#387)

## [11.0.16] - 2026-06-25

- Removed all patches for the Paragraphs module #385
- Remove a patch for the Layout Library module on chore: #3562479 PHP 8.4 - Implicit nullable SectionStorageInterface parameter #384

## [11.0.15] - 2026-06-23

- Add a patch for Drupal Canvas on fix(ui): #3591716 boolean props auto-enable when another prop is changed #383

## [11.0.14] - 2026-06-17

- Remove a patch for the Layout Builder Component Attributes module on fix: #3498301 PHP 8.4 Deprecation Notices #382

## [11.0.13] - 2026-06-17

- Remove a patch for the Drupal Canvas module on fix: #3563139 Strip JSON Schema draft-04 id keyword from prop schemas to prevent Ajv strict-mode crash on blur #381
- Remove a patch for the Drupal Canvas module on fix(Redux-integrated field widgets): #3591651 Misaligned select options in right side panel of canvas editor #380

## [11.0.12] - 2026-06-14

- Change a patch for the Content locking (anti-concurrent editing) module fix: #3544019 Form Actions Stay Cached and Disabled After Breaking Lock in Gin Admin Theme #378
- Remove a patch for the Content Lock module in fix: #3568535 SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db.sessions' doesn't exist  #379

## [11.0.11] - 2026-06-14

- Add a patch for the Drupal Canvas module on fix(Redux-integrated field widgets): #3591651 Misaligned select options in right side panel of canvas editor  #377

## [11.0.10] - 2026-06-09

- Change a patch for the Drupal Canvas module on feat: #3584713 Add Allow Edit Global Regions permission to restrict editing of global page regions #376
- Remove a patch for the Drupal Canvas module on fix(Component sources): #3591624 Block validation is broken for any block without a default value for label_display #375

## [11.0.9] - 2026-06-07

- Change a patch for the Inline Entity Form on Issue #2913571: Add a setting to enable/disable inline editing for existing entities #374
- Add a patch for the Drupal Canvas module on fix(Component sources): #3591624 Block validation is broken for any block without a default value for label_display #373
- Change a patch for Drupal Canvas on fix: #3563139 Strip JSON Schema draft-04 id keyword from prop schemas to prevent Ajv strict-mode crash on blur #372
- Change a patch for the Drupal Canvas module on feat: #3584713 Add Allow Edit Global Regions permission to restrict editing of global page regions #371
- Change a patch for the Drupal Canvas module on feat: #3567225 Allow per-node override of Content Template via checkbox in node selector #370

## [11.0.8] - 2026-05-29

- Remove a patch for the Easy Encryption module on fix: #3589914 Remove global _custom_access registration from Easy Encryption admin access checker  #369

## [11.0.7] - 2026-05-19

- Add a patch for The Gin Admin theme on fix: #3590827 Sticky form actions appear on node revision revert/delete confirm forms (incomplete exclusion pattern) #367

## [11.0.6] - 2026-05-14

- Issue #366: Ship in-repo AI agent + skills for varbase-patches (Claude / AGENTS.md / CLAUDE.md)
- Issue #365: Rename docs/index.md to docs/README.md and refresh docs landing for branch 11.0.x

## [11.0.5] - 2026-05-13

- Add a patch on the Easy Encryption module on fix: #3589914 Remove global _custom_access registration from Easy Encryption admin access checker #364

## [11.0.4] - 2026-05-11

- Issue #363: Drop the extra.plugin-modifies-downloads and extra.plugin-modifies-install-path flags from composer.json. Those promote the plugin to early activation, which makes Composer's autoloader require() drupal/core's includes/bootstrap.inc before drupal/core has been extracted on a fresh composer create-project, causing "Plugin initialization failed ... Failed to open stream" and "Install of vardot/varbase-patches failed". The plugin's late-activation path (POST_PACKAGE_INSTALL of self, with reflection-driven lock rewrite for v2 and patch-map rebuild for v1) already covers the in-flight re-resolve, so the early-load flags are unnecessary.
- add missing Composer dependencies required for Varbase project installation #363
- Issue #363: Move the autoload block in composer.json so it sits immediately after the require block, before extra. JSON-equivalent change; the file still parses identically.
- Issue #363: Reformat composer.json patch entries to two indented lines (description on its own line, URL on the next) for readability, matching the long-standing layout used in older releases. JSON-equivalent change; the file still parses identically.
- Issue #363: Support cweagans/composer-patches ~1.7.0 || ~2.0 and drop the static version field from composer.json. The plugin now detects the installed cweagans version at runtime: on v2 it keeps the existing FilteredDependencies + patches.lock.json rewrite path; on v1 it rebuilds cweagans v1's in-memory patches map from composer.lock (applying allowed-dependency-patches, ignore-dependency-patches wildcards, and patches-ignore) and sets it via reflection before postInstall runs. Composer commands varbase-patches:cleanup:patches and :cleanup:patches-file work on both versions. The static "version" field is removed; the package version is now derived from the git branch/tag.
- Issue #363: Document the patches-ignore handling for Varbase Patches in README.md and docs/configuration.md. Mirrors the upstream Varbase docs layout (https://docs.varbase.vardot.com/developers/varbase-patches), shows the v1-style description-keyed schema and the equivalent flat-array schema. URL string is what matches; description is informational.
- Issue #363: Clean up README.md commands section. Restore the "List of needed patches for Varbase used packages with Composer Patches." tagline. Replace the cramped commands table with a readable, default-markdown layout (Name / Aliases / Description bullet lists plus invocation code blocks). Add a Filename convention example. No GitBook syntax.
- Issue #363: Add Composer commands varbase-patches:cleanup:patches and varbase-patches:cleanup:patches-file (aliases var-ccup and var-ccupf) to convert merge-request URLs to local timestamped patch files. Replaces the equivalent Drush commands previously shipped in varbase_core. Adds docs/ and rewrites README.md.
- Issue #362: Convert varbase-patches into a Composer plugin to add wildcard ignore-dependency-patches, allowed-dependency-patches allowlist, and patches-ignore (v1-style) support over cweagans/composer-patches v2.

## [11.0.3] - 2026-05-07

- Change a patch for the Drupal Canvas module on feat: #3567225 Allow per-node override of Content Template via checkbox in node selector -- After Canvas 1.4.0 was released #361

## [11.0.2] - 2026-05-03

- Add a patch for the Drupal Canvas module on fix: #3563139 Strip JSON Schema draft-04 id keyword from prop schemas to prevent Ajv strict-mode crash on blur #360

## [11.0.1] - 2026-04-28

- Initial tracked release on the `11.0.x` branch.

