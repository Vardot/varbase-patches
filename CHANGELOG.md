# Changelog — Vardot/varbase-patches (`10.1.x`)

All notable changes on the `10.1.x` branch of [`Vardot/varbase-patches`](https://github.com/Vardot/varbase-patches), newest first.
Each release lists the commits — merged pull requests and the drupal.org issues they reference — since the previous release.
`#N` links to the pull request; 7-digit `#NNNNNNN` refs are drupal.org issues. Generated from git history.

## [Unreleased]

## [10.1.79] - 2026-07-13

- Add a patch for the AI Provider amazee.ai module on fix: #3586236 Do not abort recipe apply when amazee.ai trial provisioning fails (#499)
- ci: Add a GitHub Actions patches test — installs Drupal and the modules this branch patches from `tests/test.composer.json`, asserts Composer Patches (v1 and v2) applies every Varbase patch, and checks that every patch file still exists
- ci: Fix the `install-log` artifact name on pull requests by using `github.run_id` instead of `github.ref_name` (#501)

## [10.1.77] - 2026-07-06

- docs: document drupal-core-patches and update the patch-ignore guidance (#408)
- docs: Add CHANGELOG.md for the 10.1.x branch (#431)
- Replace the drupal/redirect #2879648 (mr-109) stored patch with the Drupal 11.4 compatible merge request (#439)
- fix: #444 Remove the openapi_jsonapi #3539722 patch on 10.1.x (fixed upstream in 3.x) (#445)
- Add a patch for the ECA Helper module on fix: #3608313 Guard null event and catch Throwable in Messenger decorator (#453)
- fix: Point the redirect patch at #2879648 MR!202 and drop the superseded #3607821 patch (Drupal 11.4 RedirectPathProcessorManager)
- Change a patch for the Rabbit Hole module for Fix Return value must be of type bool fatal error (#3419073) — for Varbase 10.1.x (#464)

## [10.1.76] - 2026-06-28

- docs: PR/MR template with Checkpoints (no UX/UI line)
- fix: [10.1.x] apply vardot/drupal-core-patches by default (allowed-dependency-patches) (#395)
- task: require vardot/drupal-core-patches (~11 || ~12); move drupal/core patches out (#388)

## [10.1.75] - 2026-06-25

- Fix invalid JSON in composer.json: remove trailing comma in drupal/layout_library patches
- Remove a patch for the Layout Library module on chore: #3562479 PHP 8.4 - Implicit nullable SectionStorageInterface parameter #384
- Change patch for the Paragraphs module on Issue #3090200: Paragraph access check using incorrect revision of its parent, leading to issues editing and viewing paragraphs when content moderation is involved #385
- Remove a patch for the Layout Library module on chore: #3562479 PHP 8.4 - Implicit nullable SectionStorageInterface parameter #384

## [10.1.74] - 2026-06-17

- Remove a patch for the Layout Builder Component Attributes module on fix: #3498301 PHP 8.4 Deprecation Notices #382

## [10.1.73] - 2026-06-08

- Change a patch for the Inline Entity Form on Issue #2913571: Add a setting to enable/disable inline editing for existing entities #374
- Change a patch for the Inline Entity Form on Issue #2913571: Add a setting to enable/disable inline editing for existing entities #374

## [10.1.72] - 2026-05-20

- Add a patch for the reCAPTCHA module on fix: #3588269 Make Drupal8Post::submit() compatible with parent #368

## [10.1.71] - 2026-05-19

- Add a patch for The Gin Admin theme on fix: #3590827 Sticky form actions appear on node revision revert/delete confirm forms (incomplete exclusion pattern) #367

## [10.1.70] - 2026-05-14

- Issue #366: Backport in-repo AI agent + skills (AGENTS.md / CLAUDE.md / .claude/) to 10.1.x
- Issue #365: Rename docs/index.md to docs/README.md and refresh docs landing for branch 10.1.x

## [10.1.69] - 2026-05-11

- Issue #363: Drop the extra.plugin-modifies-downloads and extra.plugin-modifies-install-path flags from composer.json. Those promote the plugin to early activation, which makes Composer's autoloader require() drupal/core's includes/bootstrap.inc before drupal/core has been extracted on a fresh composer create-project, causing "Plugin initialization failed ... Failed to open stream" and "Install of vardot/varbase-patches failed". The plugin's late-activation path (POST_PACKAGE_INSTALL of self, with reflection-driven lock rewrite for v2 and patch-map rebuild for v1) already covers the in-flight re-resolve, so the early-load flags are unnecessary.
- add missing Composer dependencies required for Varbase project installation #363
- Issue #363: Move the autoload block in composer.json so it sits immediately after the require block, before extra. JSON-equivalent change; the file still parses identically.
- Issue #363: Reformat composer.json patch entries to two indented lines (description on its own line, URL on the next) for readability, matching the long-standing layout used in older releases. JSON-equivalent change; the file still parses identically.
- Issue #363: Support cweagans/composer-patches ~1.7.0 || ~2.0 and drop the static version field from composer.json. The plugin now detects the installed cweagans version at runtime: on v2 it keeps the existing FilteredDependencies + patches.lock.json rewrite path; on v1 it rebuilds cweagans v1's in-memory patches map from composer.lock (applying allowed-dependency-patches, ignore-dependency-patches wildcards, and patches-ignore) and sets it via reflection before postInstall runs. Composer commands varbase-patches:cleanup:patches and :cleanup:patches-file work on both versions. The static "version" field is removed; the package version is now derived from the git branch/tag.
- Issue #363: Document the patches-ignore handling for Varbase Patches in README.md and docs/configuration.md. Mirrors the upstream Varbase docs layout (https://docs.varbase.vardot.com/developers/varbase-patches), shows the v1-style description-keyed schema and the equivalent flat-array schema. URL string is what matches; description is informational.
- Issue #363: Clean up README.md commands section. Restore the "List of needed patches for Varbase used packages with Composer Patches." tagline. Replace the cramped commands table with a readable, default-markdown layout (Name / Aliases / Description bullet lists plus invocation code blocks). Add a Filename convention example. No GitBook syntax.
- Issue #363: Add Composer commands varbase-patches:cleanup:patches and varbase-patches:cleanup:patches-file (aliases var-ccup and var-ccupf) to convert merge-request URLs to local timestamped patch files. Replaces the equivalent Drush commands previously shipped in varbase_core. Adds docs/ and rewrites README.md.
- Issue #362: Convert varbase-patches into a Composer plugin to add wildcard ignore-dependency-patches, allowed-dependency-patches allowlist, and patches-ignore (v1-style) support over cweagans/composer-patches v2.

## [10.1.68] - 2026-04-26

- Change a patch for the Redirect module on feat: #2879648 Redirects from aliased paths aren't triggered -- After 8.x-1.13 was released #358
- Remove a patch for the Config Ignore module on fix: #3561884 Implicit nullable Request parameter for PHP 8.4 compatibility in Config Ignore #357
- Remove a patch for the Redirect module on fix: #3057250 Validation issue on adding url redirect -- After 8.x-1.13 was released #356

## [10.1.67] - 2026-04-26

- Remove a patch for the Trash module on feat: #3491947 Add support for taxonomy terms -- After Trash 2.0.27 was released #355

## [10.1.66] - 2026-04-22

- Remove a patch for the Scheduler content moderation integration module on Issue #3543642: Fix duplicates bundles for cleaner output -- After 3.0.5 was released #352

## [10.1.65] - 2026-04-15

- Change a patch for the WebP module on fix: #3561953 PHP 8.4 implicit nullable & constructor parameter order issues in WebP FileDownloadController - After WebP 8.x-1.0-rc2 was released #346

## [10.1.64] - 2026-03-17

- Remove a patch for the Storybook module on fix: #3513496 Fix PHP 8.4 deprecations #337

## [10.1.63] - 2026-03-17

- Remove a patch for the Rabbit Hole module on fix: #3516167 Multiple Implicit Nullable Parameters for PHP 8.4 Compatibility #336

## [10.1.62] - 2026-03-12

- Add a patch for the Social Auth module on fix: #3578754 Uncaught SocialApiException shows fatal error page when credentials are not configured #335
- Change a patch for the Social Auth Facebook module on Issue #3507470: Fix fatal error for validateConfig() method signature mismatch #334

## [10.1.61] - 2026-03-11

- Remove a patch for the Modeler API module on Issue #3537810: Fix Circular Reference by Removing Autowire and Minimizing Dependencies in modeler_api.service #333

## [10.1.60] - 2026-03-05

- Remove a patch for the UI Patterns module on Issue #3496209: Add token replacement support to AttributesWidget using new centralized token and normalizer services from SourcePluginBase #332

## [10.1.59] - 2026-03-05

- Remove a patch for the Statistics module on fix: #3562419 PHP 8.4 - Implicit nullable parameters for Statistics #331
- Remove a patch for the User protect on Issue #3510800: (PHP 8.4) Fixed implicitly marking parameter  as nullable is deprecated in userprotect_entity_field_access() #330

## [10.1.58] - 2026-02-01

- Remove a patch for the Trash module on Issue #3561877 : RedirectTrashHandler should check if deleted field exists before accessing it to support Drupal ~11.3.0 #318
- Change a patch for the Trash module on feat: #3491947 Add support for taxonomy terms #317

## [10.1.57] - 2026-01-26

- Remove a patch for the View Bulk Edit module on Issue #3561886 : Implicit nullable AccountInterface parameters for PHP 8.4 compatibility #315

## [10.1.56] - 2026-01-21

- Change a patch for Layout builder library module on Issue #3561874 : Add missing isSupported method to Library class for SupportAwareSectionStorageInterface compatibility with Drupal ~11.3.0 #305
- Change a patch for the Layout Library module on Issue #3075067: Duplicate entry for key 'block_content_field__uuid__value' #304
- Change a patch for the JSON:API Extras module on fix: #3508142 installation error with JSON:API Extra in custom Drupal 11 profiles due to missing synthetic service kernel #303
- Remove a patch for the Gin Admin theme on Issue #3398040: Fix issue with changing between responsive views and Gin Toolbar over menus #301
- Change a patch for Drupal Core on fix: #3352384 Add Exception for TypeError Argument must be String in Drupal Component Utility Html escape{} #300
- Remove a patch for Media Bulk Upload on fix: #3542595 Implicit nullable Request parameter for PHP 8.4 compatibility in Media Bulk Upload #297
- Remove a patch for Drupal Core on Issue #3226791: Fix Validation error saving untranslatable Media reference field #299
- Remove leftover Composer Patches ~1.0 extra configs, which are no longer needed in both ~1 or ~2 #298
- Change a patch for Drupal Core on Issue #3543210: Quick Edit Save Via Contextual Links Redirects to 404 Page #295
- Change a patch for the User protect module on Issue #3510800: (PHP 8.4) Fixed implicitly marking parameter $items as nullable is deprecated in userprotect_entity_field_access() #294
- Remove a patch for the Drupal CMS Admin UI recipe on fix: #3568407 Remove obsolete automatic_updates_extensions from drupal_cms_admin_ui recipe #292
- Remove a patch for the Focal Point module on Issue #2906631: After changing focal point, image doesn't change until you click preview - as it was fixed in #2842260 #293
- Remove a patch for Drupal Core on Issue #3496329: Fix not loading CKEditor 5 and Tour with BigPipe enabled after Drupal 10.4 update #289
- Remove a patch for Drupal Core on Issue #3326684: Fix PHP8.1+ Deprecated function: mb_strtolower(): Passing null to parameter #1 () of type string is deprecated -- As likely it fixed in core 11.3 #288

## [10.1.55] - 2026-01-18

- Remove a patch for the Bootstrap Styles module on Issue #3282082: Support Bootstrap 5 on bootstrap_styles module - after bootstrap_styles-1.2.3 was released #286

## [10.1.54] - 2026-01-18

- Remove a patch for the Layout Builder Blocks module on feat: #3349066 Limit Layout Builder Blocks not to work in the dashboards route - after layout_builder_blocks-1.1.3 was released #285
- Remove a patch for the Diff module on Issue #3348096: Fix Entity queries must explicitly set whether the query should be access checked or not in Diff #284

## [10.1.53] - 2026-01-17

- Remove a patch for the e0ipso/twig-storybook library on Support Twig 4.x with YieldReady after twig-storybook v1.6.1 was released #278

## [10.1.52] - 2026-01-13

- Remove a patch for the Default Content module on fix: #3470061 [PHP 8.4] Fix implicitly nullable type declarations #275

## [10.1.51] - 2026-01-12

- Remove a patch for the Webform Views Integration module on fix: #3546386 PHP 8.4 Deprecation: Implicitly nullable parameter #274
- Remove a patch for the Smart Trim module on fix: #3566575 Call to undefined function _token_field_label() #273

## [10.1.50] - 2026-01-11

- Revert wrong change for Issue #3349066: Limit Layout Builder Blocks not to work in the dashboards route #272
- Change a patch for the Dashboard module on feat: #3528064 Add support for Layout Builder Restrictions after dashboard 2.2.0 was released #272
- Change a patch for the Dashboard module on feat: #3528064 Add support for Layout Builder Restrictions after dashboard 2.2.0 was released #272

## [10.1.49] - 2026-01-11

- Add a patch for the Smart Trim module on fix: #3566575 Call to undefined function _token_field_label() #271

## [10.1.48] - 2026-01-08

- Remove a patch for the CKEditor 5 Plugin Pack on fix: #3565156 PHP 8.4 compatibility - Fix implicit nullable parameter deprecations for CKEditor 5 Plugin Pack #270
- Change a patch for the Simple OAuth (OAuth2) & OpenID Connect module on fix: #3565011 Install oauth2_scope entity type during simple_oauth_install() to prevent EntityTypeManager errors #269

## [10.1.47] - 2025-12-31

- Add a patch for the CKEditor 5 Plugin Pack module on fix: #3565156 PHP 8.4 compatibility - implicit nullable parameter deprecations for CKEditor 5 Plugin Pack #265
- Add a patch for the openai-php/client library on fix: PHP 8.4 compatibility - TypeError when API returns null for results array #266
- Add a patch for the CKEditor 5 Plugin Pack module on fix: #3565156 PHP 8.4 compatibility - implicit nullable parameter deprecations for CKEditor 5 Plugin Pack #265
- Add a patch for the Simple OAuth (OAuth2) & OpenID Connect module on fix: #3565011 Install oauth2_scope entity type during simple_oauth_install() to prevent EntityTypeManager errors #264

## [10.1.46] - 2025-12-28

- Remove a patch for the Display Suite module on fix: #3507312 Fix array_unshift() Error in ds_theme_registry_alter() when running Field Group pre-process before ds_entity_view #260

## [10.1.45] - 2025-12-23

- Add a patch for the e0ipso/twig-storybook library on Support Twig 4.x with YieldReady #253

## [10.1.44] - 2025-12-21

- Add a patch for the neilime/php-css-lint library on fix: #3498301 PHP 8.4 compatibility to fix PHP 8.4 deprecation warning for implicit nullable parameter in CssLint Linter #252
- Change a patch for Drupal Core on Issue #3080606: Reorder Layout Builder sections #239
- Remove a patch for the JSON:API Extras module on Issue #3561878 : Readonly property redeclaration for dependencies in ResourceFieldEnhancer with support for Drupal ~11.3.0 #225
- Remove a patch for the Gin admin theme on fix: #3562873 Secondary admin toolbar not visible #251
- Remove a patch for the Gin admin theme on fix: #3560487 Gin Top Bar styling is fully gone in 11.3.x #250
- Add a patch for the Gin admin theme on fix: #3560487 Gin Top Bar styling is fully gone in 11.3.x #250
- Add a patch for the Gin admin theme on fix: #3560487 Gin Top Bar styling is fully gone in 11.3.x #250
- Add a patch for the Gin admin theme on fix: #3560487 Gin Top Bar styling is fully gone in 11.3.x #250
- Add a patch for the Gin admin theme on fix: #3560487 Gin Top Bar styling is fully gone in 11.3.x #250
- Add a patch for the Gin admin theme on fix: #3562873 Secondary admin toolbar not visible #251
- Add a patch for the Gin admin theme on fix: #3560487 Gin Top Bar styling is fully gone in 11.3.x #250
- Change a patch for Drupal Core on Issue #3080606: Reorder Layout Builder sections #239
- Add a patch for the Layout builder library module on fix: #3562479 PHP 8.4 - Implicit nullable SectionStorageInterface parameter #249
- Add a patch for the Password Policy module on fix: #3516906 PHP 8.4 nullable types must be explicit #248
- Add a patch for the Statistics module on fix: #3562419 PHP 8.4 - Implicit nullable parameters for Statistics #247
- Add a patch for the Shield module on fix: #3562392 PHP 8.4 - Implicit nullable parameters for Shield #246
- Add a patch for the CTools module on fix: 3492432 PHP 8.4 nullable types in MaskContentEntityStorage::doLoadMultiple() #245
- Add a patch for the OpenAPI for JSON:API module on fix: #3539722 PHP 8.4: Implicitly nullable parameter declarations deprecated #244
- Add a patch for Schemata module on fix: #3523349 PHP 8.4: Implicitly nullable parameter declarations deprecated #243
- Add a patch for the Storybook module on fix: #3513496 PHP 8.4 deprecations #242
- Add a patch for the Google Analytics module on fix: #3562288 PHP 8.4 - Implicit Nullable Parameters for Google Analytics #241
- Add a patch for the Google Analytics module on fix: #3562288 PHP 8.4 - Implicit Nullable Parameters for Google Analytics #241
- Add a patch for the Content Planner module on fix: #3542886 PHP 8.4 Support fixes #240
- Change a patch for Drupal Core on Issue #3080606: Reorder Layout Builder sections #239
- Remove a patch for the Display Suite module on Issue #3533907 : PHP 8.4 - Implicitly nullable via default value null deprecation as ds 8.x-3.32 was released #227
- Add a patch for the Paragraphs Previewer module on fix: #3538671 PHP 8.4 compatibility with implicit nullable parameters in ParagraphsPreviewController #238
- Add a patch for the Rabbit Hole module on fix: #3516167 Multiple Implicit Nullable Parameters for PHP 8.4 Compatibility #237
- Add a patch for the OpenAPI module on fix: #3523346 PHP 8.4: Implicitly nullable parameter declarations deprecated #236
- Add a patch for the Default Content on fix: #3470061 [PHP 8.4] Fix implicitly nullable type declarations #235
- Add a patch for the Layout Builder Component Attributes on fix: #3498301 PHP 8.4 compatibility implicit nullable SectionStorageInterface parameter #234
- Add a patch for the Layout Builder Advanced Permissions module on fix: #3562020 PHP 8.4 implicit nullable parameters across Layout Builder Advanced Permissions #233
- Add a patch for the Webform Views Integration module on fix: #3546386 PHP 8.4 Deprecation: Implicitly nullable parameter #232
- Add a patch for the User Protect module on Issue #3510800: (PHP 8.4) Fixed implicitly marking parameter  as nullable is deprecated in userprotect_entity_field_access() #231
- Add a patch for the Media Bulk Upload module on fix: #3542595 Implicit nullable Request parameter for PHP 8.4 compatibility in Media Bulk Upload #230
- Add a patch for the WebP module on Issue #3561953 : PHP 8.4 implicit nullable & constructor parameter order issues in WebP FileDownloadController #229
- Add a patch for Views Build Edit module on Issue #3561886 : Implicit nullable AccountInterface parameters for PHP 8.4 compatibility in Views Bulk Edit #228
- Add a patch for the Display Suite module on Issue #3533907 : PHP 8.4 - Implicitly nullable via default value null deprecation #227
- Add a patch for the Config Ignore module on Issue #3561884 : Implicit nullable Request parameter for PHP 8.4 compatibility in Config Ignore #226
- Add a patch for the JSON:API Extras module on Issue #3561878 : Readonly property redeclaration for dependencies in ResourceFieldEnhancer with support for Drupal ~11.3.0 #225
- Add a patch for the JSON:API Extras module on Issue #3561878 : Readonly property redeclaration for dependencies in ResourceFieldEnhancer with support for Drupal ~11.3.0 #225
- Add a patch for the Trash module on Issue #3561877 : RedirectTrashHandler should check if deleted field exists before accessing it to support Drupal ~11.3.0 #224
- Add a patch for the Layout Library module on Issue #3561874 : Add missing isSupported method to Library class for SupportAwareSectionStorageInterface compatibility with Drupal ~11.3.0 #223
- Remove a patch for Drupal Core on Issue #3044656: Add a helper method to strip subdirectories from URL paths #222
- Update Drupal Core to ~11.3.0 #220

## [10.1.43] - 2025-12-04

- Remove a patch for the Webform module on Issue #3556347: Fix WebformEntityStorageTrait::__get() declaration after Drupal 11.2.6 #219

## [10.1.42] - 2025-11-24

- Add a patch for the UI Patterns DS module on Issue #3504614 Render field value in component using DS field source #218
- Change a patch for the UI Patterns module on Issue #3496209: Add token replacement support to AttributesWidget using new centralized token and normalizer services from SourcePluginBase #217

## [10.1.41] - 2025-11-23

- Remove a patch for Issue #3421309: Fix Unable to save Access Unpublished settings form due to TypeError in Drupal Core Render Element::children() #216

## [10.1.40] - 2025-11-09

- Change a patch for Modeler API module on Issue #3537810: Fix Circular Reference by Removing Autowire and Minimizing Dependencies in modeler_api.service after 1.0.5 was released #215

## [10.1.39] - 2025-11-06

- Add a patch for the Webform module on #3556347: Fix WebformEntityStorageTrait::__get() declaration after Drupal 11.2.6 #214

## [10.1.38] - 2025-11-03

- Change a patch for the Modeler API module on Issue #3537810: Fix Circular Reference by Removing Autowire and Minimizing Dependencies in modeler_api.service #213

## [10.1.37] - 2025-10-19

- Remove a patch for the JSON:API Extras module on Issue #3452036: Update constructor when #3100732: Allow specifying metadata on JSON:API objects lands #212

## [10.1.36] - 2025-10-12

- Remove all patches for the Responsive Theme Preview module after 2.3.0 was released #211

## [10.1.35] - 2025-10-02

- Change a patch for the Trash module on Issue #3491947: Add support for taxonomy terms #210
- Remove a patch for ECA Helper module on [#3549723] fix: Prevent DIC RuntimeException when kernel service unavailable during Drupal installation after eca_helper 3.0.0-beta2 was released #209
- Add a patch for ECA Helper module on [#3549723] fix: Prevent DIC RuntimeException when kernel service unavailable during Drupal installation #209

## [10.1.34] - 2025-10-01

- Change a patch for the UI Patterns module on Issue #3496209: Add token replacement support to AttributesWidget using new centralized token and normalizer services from SourcePluginBase #208

## [10.1.33] - 2025-09-30

- Remove a patch for the CKEditor Media Resize module on the Issue #3531299: Fix compatibility with CKEditor5 45.x #207

## [10.1.32] - 2025-09-08

- Add a patch for the Content Planner module on Issue #3545519: Fix Prevent fatal error when entity cannot be loaded #206

## [10.1.31] - 2025-09-04

- Change a patch for the Redirect module on Issue #3057250: Validation issue on adding url redirect after 8.x-1.12 was released #198
- Change a patch for the Redirect module on Issue #2879648: Redirects from aliased paths aren't triggered after 8.x-1.12 was released #199

## [10.1.30] - 2025-09-03

- Add a patch for Drupal Core on Issue 3544608: Fix Media Library: Selected media lost after pager navigation prevents insertion #205
- Add a patch for the Views Bulk Edit module on Issue #3544584: Change default Change method to Replace the current value when configuring Modify field values action #204
- Change a patch for the Modeler API module on Issue #3537810: Fix Circular Reference by Removing Autowire and Minimizing Dependencies in modeler_api.service #203

## [10.1.29] - 2025-08-31

- Change a patch for the Dashboard module on Issue #3528064: Add support for Layout Builder Restrictions after dashboard 2.1.0 was released #202
- Add  a patch for the Redirect module on Issue #2879648: Redirects from aliased paths aren't triggered after 8.x-1.12 was released #199
- Add a patch for Drupal Core on Issue #3538500: Fix block plugin not found warnings during Drush installation #201
- Add a patch for the Scheduler content moderation integration module on Issue #3543642: Fix duplicates bundles for cleaner output #200
- Change a patch for the Redirect module on Issue #2879648: Redirects from aliased paths aren't triggered after 8.x-1.12 was released #199
- Change a patch for the Redirect module on Issue #3057250: Validation issue on adding url redirect after 8.x-1.12 was released #198

## [10.1.28] - 2025-08-27

- Change a patch for the Modeler API module on Issue #3537810: Fix Circular Reference by Removing Autowire and Minimizing Dependencies in modeler_api.service #195
- Add a patch for the Drupal Core on Issue #3543210: Quick Edit Save Via Contextual Links Redirects to 404 Page #196 (#197)

## [10.1.27] - 2025-08-25

- Remove a patch for the CKEditor Media Embed Plugin module on Issue #3444588: Switch from base_path to origin_url to fix issues when retrieving the path of the CKEditor plugins for use in a URL #194

## [10.1.26] - 2025-08-25

- Add a patch for the Trash module on Issue #3491947: Add support for taxonomy terms #193

## [10.1.25] - 2025-08-21

- Add a patch for the DropzoneJS module on Issue #3542463: Fix TypeError: count(): Argument #1 () must be of type Countable|array, null given in DropzoneJsUploadForm::validateUploadElement() #192

## [10.1.24] - 2025-08-18

- Remove a patch for the Navigation Extra Tools module on Issue #3532284: Use Icon Api for adding icons in Navigation items #191

## [10.1.23] - 2025-08-11

- Add a patch for Access Unpublished module on Issue #3421309: Fix Unable to save 'Access Unpublished' settings form due to TypeError in Drupal\Core\Render\Element::children() #177
- Issue #3421309: Fix Unable to save  settings form due to TypeError in Drupal\Core\Render\Element::children()
- Issue #3421309: Fix Unable to save `Access Unpublished` settings form due to TypeError in Drupal\Core\Render\Element::children()

## [10.1.22] - 2025-08-05

- Remove a patch for the Project Browser module on Issue #3499406: Fix fallback logic for empty  in browse() method to ensure config validation with improved fallback logic #190

## [10.1.21] - 2025-08-01

- Remove a patch for the Tour module on Issue #3535875: Add Navigation Top Bar integration for Tour module in Drupal ~11.2.0 with Gin admin theme after Tour 2.0.12 was released #189

## [10.1.20] - 2025-07-31

- Add a patch for the Entity API module on Issue #3532309: Fix Deprecation notice from DeleteAction class causes errors in ECA module #188

## [10.1.19] - 2025-07-30

- Remove a patch for the Responsive Preview module on Issue #3531527: Gin: button font #183
- Change the path for Varbase Patches storage branch with refs/heads/patches for the patches branch #187
- Add a patch for the Coffee module on Issue #3535874: Add Navigation Top Bar integration for Coffee module in Drupal ~11.2.0 and Gin ~5.0 #186
- Add a patch for the Tour module on Issue #3535875: Add Navigation Top Bar integration for Tour module in Drupal ~11.2.0 with Gin admin theme #185
- Add a patch for the Responsive Preview module on Issue #3501374: Preview displays include Navigation Toolbars #184
- Add a patch for the Responsive Preview module on Issue #3531527: Gin: button font #183
- Add a patch for the Responsive Preview module on Issue #3489112: Integrate responsive preview with Navigation top bar #182

## [10.1.18] - 2025-07-24

- Add a patch for Modeler API on Issue #3537810: Fix Circular Reference by Removing Autowire and Minimizing Dependencies in modeler_api.service #181

## [10.1.17] - 2025-07-11

- Remove a patch for Tour module on Issue #3535035: Fix uncaught TypeError in Tour module by validating focus() and currentStep usage in Shepherd callbacks Tour 2.0.11 was released #180

## [10.1.16] - 2025-07-10

- Add a patch for Navigation Extra Tools module on Issue #3532284: Use Icon Api for adding icons in Navigation items #179

## [10.1.15] - 2025-07-10

- Add a patch for the Tour module on Issue #3535035: Fix uncaught TypeError in Tour module by validating focus() and currentStep usage in Shepherd callbacks #176

## [10.1.14] - 2025-07-09

- Update a patch for Drupal Core on Issue #3049332: Fix Log error + visual warning for missing or broken block after Drupal ~11.2.0 was released #175

## [10.1.13] - 2025-07-08

- Add a patch for Drupal Core on Issue #3415961: [drupalMedia] Using the Insert Media button causes the window to scroll to the bottom of the page #156

## [10.1.12] - 2025-07-07

- Remove a patch for CKEditor 5 Premium Features module on Issue #3531493: Fix WProofreader JS Error Preventing CKEditor 5 from Loading #173

## [10.1.11] - 2025-07-02

- Remove a patch for Issue #3531194: D11.2 / D10.5: Uncaught CKEditorError: Cannot read properties of undefined (reading viewUid) #172

## [10.1.10] - 2025-06-30

- Add a patch for JSON:API Extras module on Issue #3452036: Update constructor when #3100732: Allow specifying metadata on JSON:API objects lands #171
- Add a patch for Entity Embed module on Issue #3531672: Drupal 10.5/11.2 compatability (tooltip broken, cannot edit embedded entities) #170
- Add a patch for Embed module on Issue #3517882: The namespace of EmbedCKEditor5PluginBase does not respect PSR4 #169

## [10.1.9] - 2025-06-30

- Add a patch for Editor Advanced link module on Issue #3531194: D11.2 / D10.5: Uncaught CKEditorError: Cannot read properties of undefined (reading viewUid) #168

## [10.1.8] - 2025-06-28

- Add a patch for CKEditor Media Resize module on Issue #3531299: Plugin not found error in CKEditor5 45.x prevents loading of CKEditor5 altogether when enabled #167
- Add a patch for CKEditor 5 Premium Features module on Issue #3531493: Fix WProofreader JS Error Preventing CKEditor 5 from Loading #166
- Add a patch for CKEditor 5 Plugin Pack module on Issue #3531493: Fix WProofreader JS Error Preventing CKEditor 5 from Loading #166
- Add a patch for Dashboard module on Issue #3528064: Add support for Layout Builder Restrictions #165
- Change the patch for Issue #3349066: Limit Layout Builder Blocks not to work in the dashboards route to Allow to both Dashboards and the new Dashboard module #153
- Change a patch for Drupal Core Issue #3049332: Fix Log error + visual warning for missing or broken block - After Drupal 11.2.0 was released #164
- Change a patch for Drupal Core on Issue #2741877: Nested modals don't work: opening a modal from a modal closes the original #163
- Remove a patch for Drupal Core on Issue #3413079: Cannot read properties of null (reading 'nodeType') on node.page.body #162
- Remove a patch for Drupal Core on Issue #2869592: Disabled update module shouldn't produce a status report warning #161
- Change a patch for Drupal Core on Issue #3456176: 11.2 upgrade now missing status-message theme suggestions after Drupal 11.2.0 was released #160
- Remove a patch for Drupal Core on Issue #3046152: Add playsinline option to Video media file formatter after Drupal 11.2.0 was released #159
- Update Drupal Core from ~11.1.0 to ~11.2.0 #158

## [10.1.7] - 2025-05-16

- Add a patch for the UI Patterns module on Issue #3496209: Add Support for Attributes Prop Type Source Replacing Token Values #152

## [10.1.6] - 2025-05-15

- Remove a patch for the Tour module on #3506084: Remove the Tour module does not have integration with Navigation warning when saving any config as Tour 2.0.9 was released #151

## [10.1.5] - 2025-05-08

- Remove a patch Drupal Core on Issue #3458067: Fix contextual links disappear intermittently leading to console errors #150

## [10.1.4] - 2025-04-23

- Remove a patch for Block Class module on Issue #3467450: Failsafe conversion of block_classes_stored after Block Class 4.0.1 was released #149

## [10.1.3] - 2025-04-23

- Remove a patch for Field Group module on Issue #2969051: Fix HTML5 validation prevents submission in tabs #147
- Remove a patch for Field Group module on Issue #3491233: Fix Drupal 10.4 RC1 error with field_ui.js after Field Group 4.0.0 stable was released #146

## [10.1.2] - 2025-03-29

- Add a patch for Block Class module on Issue #3493849: Argument #1 () must be of type array, string given #145
- Add a patch for Block Class module on Issue #3467450: Failsafe conversion of block_classes_stored #144
- Add a patch for Drupal Core on Issue #3352384: Add Exception for TypeError Argument must be String in Drupal Component Utility Html escape{} #143

## [10.1.1] - 2025-03-09

- Initial tracked release on the `10.1.x` branch.

