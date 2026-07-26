# Changelog — Vardot/varbase-patches (`10.0.x`)

All notable changes on the `10.0.x` branch of [`Vardot/varbase-patches`](https://github.com/Vardot/varbase-patches), newest first.
Each release lists the commits — merged pull requests and the drupal.org issues they reference — since the previous release.
`#N` links to the pull request; 7-digit `#NNNNNNN` refs are drupal.org issues. Generated from git history.

## [Unreleased]

- Remove a patch for the CTools (Chaos Tool Suite) module on fix: #3492432 PHP 8.4 nullable types in MaskContentEntityStorage::doLoadMultiple() (fixed upstream, released in ctools 4.1.1)

## [10.0.137] - 2026-07-13

- ci: Add a GitHub Actions patches test — installs Drupal and the modules this branch patches from `tests/test.composer.json`, asserts Composer Patches (v1 and v2) applies every Varbase patch, and checks that every patch file still exists

## [10.0.136] - 2026-07-06

- docs: document drupal-core-patches and update the patch-ignore guidance (#407)
- docs: Add CHANGELOG.md for the 10.0.x branch (#430)
- fix: #442 Remove the openapi_jsonapi #3539722 patch on 10.0.x (fixed upstream in 3.x) (#443)
- Change a patch for the Rabbit Hole module for Fix Return value must be of type bool fatal error (#3419073) — for Varbase 10.0.x (#463)

## [10.0.135] - 2026-06-28

- docs: PR/MR template with Checkpoints (no UX/UI line)
- fix: [10.0.x] apply vardot/drupal-core-patches by default (allowed-dependency-patches) (#397)
- task: require vardot/drupal-core-patches (~10 || ~11 || ~12); move drupal/core patches out (#390)

## [10.0.134] - 2026-06-25

- Change patch for the Paragraphs module on Issue #3090200: Paragraph access check using incorrect revision of its parent, leading to issues editing and viewing paragraphs when content moderation is involved #385
- Remove a patch for the Layout Library module on chore: #3562479 PHP 8.4 - Implicit nullable SectionStorageInterface parameter #384

## [10.0.133] - 2026-06-17

- Remove a patch for the Layout Builder Component Attributes module on fix: #3498301 PHP 8.4 Deprecation Notices #382

## [10.0.132] - 2026-06-07

- Change a patch for the Inline Entity Form on Issue #2913571: Add a setting to enable/disable inline editing for existing entities #374

## [10.0.131] - 2026-05-20

- Add a patch for the reCAPTCHA module on fix: #3588269 Make Drupal8Post::submit() compatible with parent #368

## [10.0.130] - 2026-05-19

- Add a patch for The Gin Admin theme on fix: #3590827 Sticky form actions appear on node revision revert/delete confirm forms (incomplete exclusion pattern) #367

## [10.0.129] - 2026-05-14

- Issue #366: Backport in-repo AI agent + skills (AGENTS.md / CLAUDE.md / .claude/) to 10.0.x
- Issue #365: Rename docs/index.md to docs/README.md and refresh docs landing for branch 10.0.x

## [10.0.128] - 2026-05-11

- Issue #363: Drop the extra.plugin-modifies-downloads and extra.plugin-modifies-install-path flags from composer.json. Those promote the plugin to early activation, which makes Composer's autoloader require() drupal/core's includes/bootstrap.inc before drupal/core has been extracted on a fresh composer create-project, causing "Plugin initialization failed ... Failed to open stream" and "Install of vardot/varbase-patches failed". The plugin's late-activation path (POST_PACKAGE_INSTALL of self, with reflection-driven lock rewrite for v2 and patch-map rebuild for v1) already covers the in-flight re-resolve, so the early-load flags are unnecessary.
- add missing Composer dependencies required for Varbase project installation #363
- Issue #363: Move the autoload block in composer.json so it sits immediately after the require block, before extra. JSON-equivalent change; the file still parses identically.
- Issue #363: Reformat composer.json patch entries to two indented lines (description on its own line, URL on the next) for readability, matching the long-standing layout used in older releases. JSON-equivalent change; the file still parses identically.
- Issue #363: Support cweagans/composer-patches ~1.7.0 || ~2.0 and drop the static version field from composer.json. The plugin now detects the installed cweagans version at runtime: on v2 it keeps the existing FilteredDependencies + patches.lock.json rewrite path; on v1 it rebuilds cweagans v1's in-memory patches map from composer.lock (applying allowed-dependency-patches, ignore-dependency-patches wildcards, and patches-ignore) and sets it via reflection before postInstall runs. Composer commands varbase-patches:cleanup:patches and :cleanup:patches-file work on both versions. The static "version" field is removed; the package version is now derived from the git branch/tag.
- Issue #363: Document the patches-ignore handling for Varbase Patches in README.md and docs/configuration.md. Mirrors the upstream Varbase docs layout (https://docs.varbase.vardot.com/developers/varbase-patches), shows the v1-style description-keyed schema and the equivalent flat-array schema. URL string is what matches; description is informational.
- Issue #363: Clean up README.md commands section. Restore the "List of needed patches for Varbase used packages with Composer Patches." tagline. Replace the cramped commands table with a readable, default-markdown layout (Name / Aliases / Description bullet lists plus invocation code blocks). Add a Filename convention example. No GitBook syntax.
- Issue #363: Add Composer commands varbase-patches:cleanup:patches and varbase-patches:cleanup:patches-file (aliases var-ccup and var-ccupf) to convert merge-request URLs to local timestamped patch files. Replaces the equivalent Drush commands previously shipped in varbase_core. Adds docs/ and rewrites README.md.
- Issue #362: Convert varbase-patches into a Composer plugin to add wildcard ignore-dependency-patches, allowed-dependency-patches allowlist, and patches-ignore (v1-style) support over cweagans/composer-patches v2.

## [10.0.127] - 2026-04-26

- Change a patch for the Redirect module on feat: #2879648 Redirects from aliased paths aren't triggered -- After 8.x-1.13 was released #358
- Remove a patch for the Config Ignore module on fix: #3561884 Implicit nullable Request parameter for PHP 8.4 compatibility in Config Ignore #357
- Remove a patch for the Redirect module on fix: #3057250 Validation issue on adding url redirect -- After 8.x-1.13 was released #356

## [10.0.126] - 2026-04-22

- Remove a patch for the Scheduler content moderation integration module on Issue #3543642: Fix duplicates bundles for cleaner output -- After 3.0.5 was released #352

## [10.0.125] - 2026-04-15

- Change a patch for the WebP module on fix: #3561953 PHP 8.4 implicit nullable & constructor parameter order issues in WebP FileDownloadController - After WebP 8.x-1.0-rc2 was released #346

## [10.0.124] - 2026-03-31

- Remove a patch for the Dashboards module on fix: #3542888 PHP 8.4 Support #342

## [10.0.123] - 2026-03-17

- Remove a patch for the Rabbit Hole module on fix: #3516167 Multiple Implicit Nullable Parameters for PHP 8.4 Compatibility #336

## [10.0.122] - 2026-03-05

- Remove a patch for the Statistics module on fix: #3562419 PHP 8.4 - Implicit nullable parameters for Statistics #331
- Remove a patch for the User protect on Issue #3510800: (PHP 8.4) Fixed implicitly marking parameter  as nullable is deprecated in userprotect_entity_field_access() #330

## [10.0.121] - 2026-01-26

- Remove a patch for the View Bulk Edit module on Issue #3561886 : Implicit nullable AccountInterface parameters for PHP 8.4 compatibility #315

## [10.0.120] - 2026-01-21

- Change a patch for the UI Patterns Settings module on fix: #3564894 PHP8.4 Deprecated notice #312
- Change a patch for the Social Auth module on fix: #3564906 PHP 8.4 compatibility - Implicit nullable parameter deprecations in Social Auth module #311
- Remove a patch for the Focal Point module on Issue #2906631: After changing focal point, image doesn't change until you click preview - as it was fixed in #2842260 #293
- Change a patch for the Dashboards with Layout Builder module on fix: #3542888 PHP 8.4 Support #310
- Change a patch for Drupal Core on Issue #3326684: Fix PHP8.1+ Deprecated function: mb_strtolower(): Passing null to parameter #1 () of type string is deprecated - for Drupal 10.6.2 #309
- Change a patch for Drupal Core on Issue #3431330: Add Action Method to Add a button plugin and settings into the Active toolbar in editor - for Drupal 10.6.2 #308
- Remove a patch for Drupal core on Issue #3044656: Add a helper method to strip subdirectories from URL paths #307
- Change a patch for Drupal Core on feat: #3080606 add Reorder Layout Builder sections -- for Drupal 10.6.2 #306
- Change a patch for the Layout Library module on Issue #3075067: Duplicate entry for key 'block_content_field__uuid__value' #304
- Remove a patch for the Gin Admin theme on Issue #3398040: Fix issue with changing between responsive views and Gin Toolbar over menus #301
- Remove a patch for Media Bulk Upload on fix: #3542595 Implicit nullable Request parameter for PHP 8.4 compatibility in Media Bulk Upload #297
- Remove a patch for Drupal Core on Issue #3226791: Fix Validation error saving untranslatable Media reference field #299
- Remove leftover Composer Patches ~1.0 extra configs, which are no longer needed in both ~1 or ~2 #298
- Change a patch for the User protect module on Issue #3510800: (PHP 8.4) Fixed implicitly marking parameter  as nullable is deprecated in userprotect_entity_field_access() #294
- Remove a patch for Drupal Core on Issue #3496329: Fix not loading CKEditor 5 and Tour with BigPipe enabled after Drupal 10.4 update #289

## [10.0.119] - 2026-01-18

- Remove a patch for the Bootstrap Styles module on Issue #3282082: Support Bootstrap 5 on bootstrap_styles module - after bootstrap_styles-1.2.3 was released #286

## [10.0.118] - 2026-01-18

- Remove a patch for the Layout Builder Blocks module on feat: #3349066 Limit Layout Builder Blocks not to work in the dashboards route - after layout_builder_blocks-1.1.3 was released #285
- Remove a patch for the Diff module on Issue #3348096: Fix Entity queries must explicitly set whether the query should be access checked or not in Diff #284

## [10.0.117] - 2026-01-13

- Remove a patch for the Default Content module on fix: #3470061 [PHP 8.4] Fix implicitly nullable type declarations #275

## [10.0.116] - 2026-01-12

- Remove a patch for the Webform Views Integration module on fix: #3546386 PHP 8.4 Deprecation: Implicitly nullable parameter #274
- Remove a patch for the Smart Trim module on fix: #3566575 Call to undefined function _token_field_label() #273

## [10.0.115] - 2026-01-11

- Add a patch for the Smart Trim module on fix: #3566575 Call to undefined function _token_field_label() #271
- Remove a patch for the CKEditor 5 Plugin Pack on fix: #3565156 PHP 8.4 compatibility - Fix implicit nullable parameter deprecations for CKEditor 5 Plugin Pack #270
- Change a patch for the Simple OAuth (OAuth2) & OpenID Connect module on fix: #3565011 Install oauth2_scope entity type during simple_oauth_install() to prevent EntityTypeManager errors #269

## [10.0.114] - 2025-12-31

- Change a patch for Drupal Core on Issue #3049332: Fix Log error + visual warning for missing or broken block #267
- Add a patch for the CKEditor 5 Plugin Pack module on fix: #3565156 PHP 8.4 compatibility - implicit nullable parameter deprecations for CKEditor 5 Plugin Pack #265
- Add a patch for the CKEditor 5 Plugin Pack module on fix: #3565156 PHP 8.4 compatibility - implicit nullable parameter deprecations for CKEditor 5 Plugin Pack #265
- Add a patch for the Simple OAuth (OAuth2) & OpenID Connect module on fix: #3565011 Install oauth2_scope entity type during simple_oauth_install() to prevent EntityTypeManager errors #264

## [10.0.113] - 2025-12-27

- Add a patch for the Social Auth module on fix: #3564906 PHP 8.4 compatibility – Implicit nullable parameter deprecations in Social Auth module #256
- Add a patch for the Dashboards with Layout Builder module on fix: #3542888 PHP 8.4 Support #255
- Add patch for UI Patterns Settings module on fix: #3564894 PHP8.4 Deprecated notice #254

## [10.0.112] - 2025-12-21

- Add a patch for the neilime/php-css-lint library on fix: #3498301 PHP 8.4 compatibility to fix PHP 8.4 deprecation warning for implicit nullable parameter in CssLint Linter #252
- Change a patch for Drupal Core on Issue #3080606: Reorder Layout Builder sections #239
- Add a patch for the Password Policy module on fix: #3516906 PHP 8.4 nullable types must be explicit #248
- Add a patch for the Statistics module on fix: #3562419 PHP 8.4 - Implicit nullable parameters for Statistics #247
- Add a patch for the Shield module on fix: #3562392 PHP 8.4 - Implicit nullable parameters for Shield #246
- Add a patch for the CTools module on fix: 3492432 PHP 8.4 nullable types in MaskContentEntityStorage::doLoadMultiple() #245
- Add a patch for the OpenAPI for JSON:API module on fix: #3539722 PHP 8.4: Implicitly nullable parameter declarations deprecated #244
- Add a patch for Schemata module on fix: #3523349 PHP 8.4: Implicitly nullable parameter declarations deprecated #243
- Add a patch for the Google Analytics module on fix: #3562288 PHP 8.4 - Implicit Nullable Parameters for Google Analytics #241
- Add a patch for the OpenAPI module on fix: #3523346 PHP 8.4: Implicitly nullable parameter declarations deprecated #236
- Add a patch for the Layout Builder Component Attributes on fix: #3498301 PHP 8.4 compatibility implicit nullable SectionStorageInterface parameter #234
- Add a patch for the Webform Views Integration module on fix: #3546386 PHP 8.4 Deprecation: Implicitly nullable parameter #232
- Add a patch for the User Protect module on Issue #3510800: (PHP 8.4) Fixed implicitly marking parameter  as nullable is deprecated in userprotect_entity_field_access() #231
- Add a patch for the Media Bulk Upload module on fix: #3542595 Implicit nullable Request parameter for PHP 8.4 compatibility in Media Bulk Upload #230
- Add a patch for the WebP module on Issue #3561953 : PHP 8.4 implicit nullable & constructor parameter order issues in WebP FileDownloadController #229
- Add a patch for the Config Ignore module on Issue #3561884 : Implicit nullable Request parameter for PHP 8.4 compatibility in Config Ignore #226
- Add a patch for the Content Planner module on fix: #3542886 PHP 8.4 Support fixes #240
- Add a patch for Views Build Edit module on Issue #3561886 : Implicit nullable AccountInterface parameters for PHP 8.4 compatibility in Views Bulk Edit #228
- Add a patch for the Layout Builder Advanced Permissions module on fix: #3562020 PHP 8.4 implicit nullable parameters across Layout Builder Advanced Permissions #233
- Add a patch for the Paragraphs Previewer module on fix: #3538671 PHP 8.4 compatibility with implicit nullable parameters in ParagraphsPreviewController #238
- Add a patch for the Layout builder library module on fix: #3562479 PHP 8.4 - Implicit nullable SectionStorageInterface parameter #249
- Add a patch for the Rabbit Hole module on fix: #3516167 Multiple Implicit Nullable Parameters for PHP 8.4 Compatibility #237
- Add a patch for the Default Content on fix: #3470061 [PHP 8.4] Fix implicitly nullable type declarations #235
- Change a patch for Drupal Core on Issue #3080606: Reorder Layout Builder sections #239
- Update Drupal Core to ~10.6.0 #221
- Update Drupal Core to ~11.3.0 #220

## [10.0.111] - 2025-11-23

- Remove a patch for Issue #3421309: Fix Unable to save Access Unpublished settings form due to TypeError in Drupal Core Render Element::children() #216

## [10.0.110] - 2025-09-30

- Remove a patch for the CKEditor Media Resize module on the Issue #3531299: Fix compatibility with CKEditor5 45.x #207

## [10.0.109] - 2025-09-08

- Add a patch for the Content Planner module on Issue #3545519: Fix Prevent fatal error when entity cannot be loaded #206

## [10.0.108] - 2025-09-04

- Change a patch for the Redirect module on Issue #3057250: Validation issue on adding url redirect after 8.x-1.12 was released #198
- Change a patch for the Redirect module on Issue #2879648: Redirects from aliased paths aren't triggered after 8.x-1.12 was released #199

## [10.0.107] - 2025-09-03

- Add a patch for the Views Bulk Edit module on Issue #3544584: Change default Change method to Replace the current value when configuring Modify field values action #204

## [10.0.106] - 2025-08-30

- Add  a patch for the Redirect module on Issue #2879648: Redirects from aliased paths aren't triggered after 8.x-1.12 was released #199
- Add a patch for Drupal Core on Issue #3538500: Fix block plugin not found warnings during Drush installation #201
- Add a patch for the Scheduler content moderation integration module on Issue #3543642: Fix duplicates bundles for cleaner output #200
- Change a patch for the Redirect module on Issue #3057250: Validation issue on adding url redirect after 8.x-1.12 was released #198

## [10.0.105] - 2025-08-25

- Remove a patch for the CKEditor Media Embed Plugin module on Issue #3444588: Switch from base_path to origin_url to fix issues when retrieving the path of the CKEditor plugins for use in a URL #194

## [10.0.104] - 2025-08-21

- Add a patch for the DropzoneJS module on Issue #3542463: Fix TypeError: count(): Argument #1 () must be of type Countable|array, null given in DropzoneJsUploadForm::validateUploadElement() #192

## [10.0.103] - 2025-08-11

- Add a patch for Access Unpublished module on Issue #3421309: Fix Unable to save 'Access Unpublished' settings form due to TypeError in Drupal\Core\Render\Element::children() #177

## [10.0.102] - 2025-08-05

- Remove a patch for the Project Browser module on Issue #3499406: Fix fallback logic for empty  in browse() method to ensure config validation with improved fallback logic #190

## [10.0.101] - 2025-07-31

- Add a patch for the Entity API module on Issue #3532309: Fix Deprecation notice from DeleteAction class causes errors in ECA module #188

## [10.0.100] - 2025-07-30

- Change the path for Varbase Patches storage branch with refs/heads/patches for the patches branch #187

## [10.0.99] - 2025-07-08

- Add a patch for Drupal Core on Issue #3415961: [drupalMedia] Using the Insert Media button causes the window to scroll to the bottom of the page #156

## [10.0.98] - 2025-07-07

- Remove a patch for CKEditor 5 Premium Features module on Issue #3531493: Fix WProofreader JS Error Preventing CKEditor 5 from Loading #173

## [10.0.97] - 2025-07-02

- Remove a patch for Issue #3531194: D11.2 / D10.5: Uncaught CKEditorError: Cannot read properties of undefined (reading viewUid) #172

## [10.0.96] - 2025-06-30

- Add a patch for Entity Embed module on Issue #3531672: Drupal 10.5/11.2 compatability (tooltip broken, cannot edit embedded entities) #170
- Add a patch for Embed module on Issue #3517882: The namespace of EmbedCKEditor5PluginBase does not respect PSR4 #169

## [10.0.95] - 2025-06-30

- Add a patch for Editor Advanced link module on Issue #3531194: D11.2 / D10.5: Uncaught CKEditorError: Cannot read properties of undefined (reading viewUid) #168

## [10.0.94] - 2025-06-28

- Add a patch for CKEditor Media Resize module on Issue #3531299: Plugin not found error in CKEditor5 45.x prevents loading of CKEditor5 altogether when enabled #167
- Add a patch for CKEditor 5 Premium Features module on Issue #3531493: Fix WProofreader JS Error Preventing CKEditor 5 from Loading #166
- Add a patch for CKEditor 5 Plugin Pack module on Issue #3531493: Fix WProofreader JS Error Preventing CKEditor 5 from Loading #166
- Add a patch for CKEditor 5 Plugin Pack module on Issue #3531493: Fix WProofreader JS Error Preventing CKEditor 5 from Loading #166
- Remove a patch for Drupal Core on Issue #3413079: Cannot read properties of null (reading 'nodeType') on node.page.body #162
- Remove a patch for Drupal Core on Issue #2869592: Disabled update module shouldn't produce a status report warning #161
- Update Drupal Core from ~10.4.0 to ~10.5.0 #157

## [10.0.93] - 2025-05-15

- Remove a patch for the Tour module on #3506084: Remove the Tour module does not have integration with Navigation warning when saving any config as Tour 2.0.9 was released #151

## [10.0.92] - 2025-05-08

- Remove a patch Drupal Core on Issue #3458067: Fix contextual links disappear intermittently leading to console errors #150

## [10.0.91] - 2025-04-23

- Remove a patch for Block Class module on Issue #3467450: Failsafe conversion of block_classes_stored after Block Class 4.0.1 was released #149

## [10.0.90] - 2025-04-23

- Remove a patch for Filed Group module on Issue #3395375: Fix Duplicated required marks in field tabs with Gin admin theme after Field Group 4.0.0 stable was released #148
- Remove a patch for Field Group module on Issue #2969051: Fix HTML5 validation prevents submission in tabs #147
- Remove a patch for Field Group module on Issue #3491233: Fix Drupal 10.4 RC1 error with field_ui.js after Field Group 4.0.0 stable was released #146

## [10.0.89] - 2025-03-29

- Add a patch for Block Class module on Issue #3493849: Argument #1 () must be of type array, string given #145
- Add a patch for Block Class module on Issue #3467450: Failsafe conversion of block_classes_stored #144

## [10.0.88] - 2025-02-16

- Change a path for Drupal Core on Issue #2741877: Nested modals don't work: opening a modal from a modal closes the original #133

## [10.0.87] - 2025-02-12

- Change a patch for Tour module on Issue #3506084: Remove the Tour module does not have integration with Navigation warning when saving any config #132
- Remove a patch for Layout Builder Restrictions on Issue #3491116: Fix inlineBlocksAllowedinContext() not checking for View Display in Entity View Mode Restriction #131

## [10.0.86] - 2025-02-12

- Add a patch for Layout Builder Restriction on Issue #3491116: Fix inlineBlocksAllowedinContext() not checking for View Display in Entity View Mode Restriction #130
- Add a patch for Tour module on Issue #3506084: Remove the Tour module does not have integration with Navigation warning when saving any config #129
- Remove Documentation for 10.1.0 Until Stable Release #128

## [10.0.85] - 2025-02-06

- Change a patch for Drupal Core on Issue #2741877: Nested modals don't work: opening a modal from a modal closes the original #127

## [10.0.84] - 2025-02-05

- Remove a patch for Scheduler module on Issue #3498553: BC event class aliases are not always being loaded #126

## [10.0.83] - 2025-02-04

- Remove all patches for the Gin Type Tray module as 1.0.0-rc1 was released #125

## [10.0.82] - 2025-01-30

- Add patch for Project Browser module on Issue #3499406: Fix fallback logic for empty  in browse() method to ensure config validation with improved fallback logic after Project Browser 2.0.0-alpha8 was released #124

## [10.0.81] - 2025-01-30

- Remove a patch for Project Browser module on Issue #3499406: Fix fallback logic for empty  in browse() method to ensure config validation with improved fallback logic #123

## [10.0.80] - 2025-01-26

- Add a patch for Drupal Core on Issue #3497061: Allow recipe input values in array keys #122

## [10.0.79] - 2025-01-25

- Add a patch for Layout Builder Advanced Permissions module on Issue #3502237: Fix type error in layout builder perms access manager logger channel factory with LoggerChannelFactoryInterface #121
- Remove a patch for Layout Builder Advanced Permissions module on Issue #3471460: Fix users having access to the layout builder on entities regardless of whether the layout is enabled #120
- Remove a patch for Layout Builder Advanced Permissions module on Issue #3392780: Fix not valid context for entity context when editing the default layout entity types or bundles #119

## [10.0.78] - 2025-01-20

- Add a patch for Field Group module on Issue #2969051: Fix HTML5 validation prevents submission in tabs #118
- Add a patch for Field Group on Issue #3491233: Fix Drupal 10.4 RC1 error with field_ui.js #117
- Add a patch for Scheduler module on Issue #3498553: Sheduler upgrade 2.2.0 and content planner 8.x-1.2 #116
- Remove a patch for Real-time SEO module on Issue #3362165: Fix Deprecated function: Creation of dynamic property #115

## [10.0.77] - 2025-01-14

- Remove a patch for Gin Everywhere module on Issue #3436449: Fix showing the status tab out in the delete confirmation route #114
- Remove a patch for Drupal Core on Issue #3165435: Fix tour <front> route as route name when a selected node had been set as the front page for the site #113

## [10.0.76] - 2025-01-13

- Add a patch for Project Browser module on Issue #3499406: Fix fallback logic for empty  in browse() method to ensure config validation with improved fallback logic #112

## [10.0.75] - 2025-01-04

- Change a patch for Inline Entity Form module on Issue #3136514: IEF complex widget: Re-ordering / weight sometimes not updated #111
- Change a patch for Drupal Core on Issue #3496329: Fix not loading CKEditor 5 and Tour with BigPipe enabled after Drupal 10.4 update #110
- Change a patch for Drupal Core on Issue #3496329: Fix not loading CKEditor 5 and Tour with BigPipe enabled after Drupal 10.4 update #110

## [10.0.74] - 2024-12-31

- Add a patch for Drupal Core on Issue #3496329: Fix not loading CKEditor 5 and Tour on existing content after Drupal 10.4 update #109
- Add a patch for Inline Entity Form module on Issue #2913571: Add a setting to enable/disable inline editing for existing entities #108
- Change a patch for Inline Entity Form on Issue #3136514: IEF complex widget: Re-ordering / weight sometimes not updated to work with IEF ~3.0 #107
- Remove a patch for Inline Entity Form module on Issue #3143422: Allow to hide the Edit button in Complex widget #106
- Update Drupal Core from ~10.3.0 to ~10.4.0 for Varbase Patches #105

## [10.0.73] - 2024-12-09

- Add a patch for Field Group module on Issue #3395375: Fix Duplicated required marks in field tabs with Gin admin theme #104

## [10.0.72] - 2024-12-08

- Remove a patch for Editoria11y Accessibility Checker module on Issue #3492469: Fix Error: Call to Member Function id() on Null in editoria11y Page Attachments() During Content Type Creation #103

## [10.0.71] - 2024-12-08

- Add a patch for Editoria11y Accessibility Checker module on Issue #3492469: Fix Error: Call to Member Function id() on Null in editoria11y Page Attachments() During Content Type Creation #102

## [10.0.70] - 2024-12-08

- Remove a patch for Content Moderation Notifications module on Issue #3347958: Fix Entity queries must explicitly set whether the query should be access checked or not in Content Moderation Notifications #101

## [10.0.69] - 2024-12-02

- Change a patch for the Default Content module on Issue #3160146: Add a Normalizer and Denormalizer to support Layout Builder #100

## [10.0.68] - 2024-12-01

- Remove a patch for Taxonomy Manager module on Issue #3474919: Fix broken form element taxonomy manager tree #99

## [10.0.67] - 2024-11-17

- Remove a patch for Security Review module on Issue #3463712: Fix fatal error when pressing Run checklist button #98

## [10.0.66] - 2024-11-13

- Change a patch for the Default Content module on Issue #3160146: Add a Normalizer and Denormalizer to support Layout Builder #97

## [10.0.65] - 2024-11-12

- Change the patch for the Gin Admin theme on Issue #3325263: Fix user.data ServiceNotFoundException when using Gin as distribution installer theme #95
- Update the README.md file after the 10.1.x new branch #94

## [10.0.64] - 2024-10-30

- Remove a patch for Single Directory Components: Display on Issue #3458639: The module is not compatible with Drupal 10.3.0 #93
- Remove a patch for Component Libraries: Editorial on Issue #3456850: Support Drupal 10.3 SDC deprecation #92

## [10.0.63] - 2024-10-26

- Remove a patch for Component Libraries: Devel on Issue #3456669: Update Drupal core to ^10.3 and ^11 and drop the use of the SDC experimental module #91

## [10.0.62] - 2024-10-21

- Add a patch for Taxonomy Manager module on Issue #3474919: Fix broken form element taxonomy manager tree #89
- Issue #3474919: Form element taxonomy_manager_tree broken (#90)

## [10.0.61] - 2024-10-03

- Remove a patch for Drupal Core on Issue #3457168: Since twig/twig 3.9: error with twig_escape_filter function usage in /core/lib/Drupal/Core/Template/TwigExtension.php #87

## [10.0.60] - 2024-10-02

- Remove a patch for Drimage on Issue #3456085: Fix Drupal 10.3 compatibility for Too few arguments to function deliver() 3 passed in Drimage #86

## [10.0.59] - 2024-10-01

- Remove the patch for JSON:API Extras on Issue #3473990: Fix PHP Fatal error on declaration of the normalize function must be compatible with normalize function return type after JSON:API Extras 8.x-3.26 was released #85

## [10.0.58] - 2024-09-16

- Change a patch for Bootstrap Styles on Issue #3282082: Support Bootstrap 5 on bootstrap_styles module #84

## [10.0.57] - 2024-09-15

- Change a patch for Bootstrap Styles on Issue #3282082: Support Bootstrap 5 on bootstrap_styles module #84

## [10.0.56] - 2024-09-12

- Add a commit patch for JSON:API Extras on Issue #3473990: Fix PHP Fatal error on Declaration of the normalize function must be compatible with normalize function return type after Schemata 8.x-1.0 was released #83

## [10.0.55] - 2024-09-12

- Add a patch for Drupal Core on Issue #3457168: Since twig/twig 3.9: error with twig_escape_filter function usage in /core/lib/Drupal/Core/Template/TwigExtension.php #82

## [10.0.54] - 2024-09-02

- Add a patch for Layout Builder Permission module on Issue #3471460: users having access to the layout builder on entities regardless of whether the layout is enabled #79

## [10.0.53] - 2024-08-20

- Add a patch for the Single Directory Components: Display module on Issue #3458639: The module is not compatible with Drupal 10.3.0 #78
- Add a patch for Component Libraries: Editorial module on Issue #3456850: Support Drupal 10.3 SDC deprecation #77

## [10.0.52] - 2024-08-15

- Remove a patch for Webform Views Integration module on __ Issue #3467786: Fix Major error causes WSOD Error: Uncaught TypeError __ after webform_views 8.x-5.4 was released #76

## [10.0.51] - 2024-08-14

- Add a patch for the Layout Builder Blocks module on Issue #3349066: Limit Layout Builder Blocks not to work in the dashboards route #75

## [10.0.50] - 2024-08-13

- Remove a patch for Password Policy module on Issue #3465364: Fix Fatal error when changing password when password_policy_history is enabled after password_policy 4.0.3 was released #74

## [10.0.49] - 2024-08-13

- Add a patch for Webform Views Integration module on Issue #3467786: Fix Major error causes WSOD Error: Uncaught TypeError #7

## [10.0.48] - 2024-08-13

- Remove a patch for Webform Views Integration module on Issue #3386492: Fix Fatal error on Drupal 9/10 : ArgumentCountError: Too few arguments to function EntityViewsData::__construct(), 6 passed after webform_views 8.x-5.3 was released #72

## [10.0.47] - 2024-08-11

- Update patches for the Redirect module after redirect 8.x-1.10 was released #70
- Remove a patch for Entity Embed module on Issue #3466609: Entity Embed fails to install after Embed module update #71

## [10.0.46] - 2024-08-08

- Remove a patch for Dynamic Responsive Image (Drimage) – Improved module on Issue #3456065 Fix Drupal 10.3 compatibility for Too few arguments to function deliver() 3 passed in Drimage Improved #69

## [10.0.45] - 2024-08-07

- Add a patch for Entity Embed on Issue #3466609: Entity Embed fails to install after Embed module update #68

## [10.0.44] - 2024-08-07

- Add a patch for Password Policy on Issue #3465364: Fatal error when changing password when password_policy_history is enabled #67

## [10.0.43] - 2024-08-03

- Remove a patch for Admin Toolbar module on Issue #3338408: Resolve access check errors for D10 compatibility after admin toolbar 3.5.0 was released #66

## [10.0.42] - 2024-08-01

- Add a patch for Drupal Core on Issue #3465033: Fix not saving addItemToToolbar recipe action for divider | (vertical separator) or wrapping - items to CKEditor 5 #65
- Revert - Add a patch for CKEditor 5 Premium Features module on Issue #3455574: Fix plugincollection-plugin-not-loaded when upgraded to 1.2.9 #59
- Add a patch for CKEditor 5 Premium Features module on Issue #3455574: Fix plugincollection-plugin-not-loaded when upgraded to 1.2.9 #59

## [10.0.41] - 2024-07-30

- Remove a patch for the Email Registration module on Issue #3456461: [2.x] Login fails with Drupal 10.3 after Email Registration 2.0.0-rc6 was released #63

## [10.0.40] - 2024-07-25

- Add the patch for Security Review module on Issue #3463712: Fix fatal error when pressing Run checklist button #62

## [10.0.39] - 2024-07-17

- Remove all patches for Taxonomy Manager module on Issue #3213205: Fix Redirects to external URLs are not allowed by default, after saving a term in Taxonomy Manager #58

## [10.0.38] - 2024-07-08

- Add a patch for Drupal Core 10.3.1 on Issue #3459881: Fix TypeError: implode(): Argument #1 () must be of type array, string given in implode() (line 537 of core/lib/Drupal/Core/Field/WidgetBase.php) #56

## [10.0.37] - 2024-07-07

- Add a patch for Node Edit Protection module on Issue #3455823: Fix the warning issue that occurs when pressing the save submit button in the Gin Admin theme #55

## [10.0.36] - 2024-07-03

- Remove the committed patch for OpenAI module on Issue #3452184: OpenAI CKEditor integration compatibility issue with Drupal 10.3 #54

## [10.0.35] - 2024-07-03

- Add a patch for OpenAI / ChatGPT Integration module on Issue #3452184: OpenAI CKEditor integration compatibility issue with Drupal 10.3 #53

## [10.0.34] - 2024-07-02

- Add a patch for Varbase Core CKEditor 5 on Issue #3457431: Fix validation warnings when saving text format by remove inactive filters from the list of filters to validate for the text format #52

## [10.0.33] - 2024-06-30

- Add a patch for Drupal Core on Issue #3458067: Fix contextual links disappear intermittently leading to console errors #51

## [10.0.32] - 2024-06-29

- Add a TEMP patch for Drupal Core Big Pipe module on Issue #3456176: 10.3 upgrade now missing status-message theme suggestions #50

## [10.0.31] - 2024-06-25

- Add a patch for the Email Registration module on Issue #3456461: [2.x] Login fails with Drupal 10.3 #49

## [10.0.30] - 2024-06-25

- Change the patch for Component Libraries: Theme Server module on Issue #3456661: Update Drupal core to ^10.3 and ^11 and drop the use of the SDC experimental module #48

## [10.0.29] - 2024-06-24

- Add the patch for Component Libraries: Devel module to apply Issue #3456669: Update Drupal core to ^10.3 and ^11 and drop the use of the SDC experimental module #47
- Add the patch for Component Libraries: Theme Server to apply Issue #3456661: Update Drupal core to ^10.3 and ^11 and drop the use of the SDC experimental module #46

## [10.0.28] - 2024-06-21

- Add patches for Drimage and Drimage Improved to Fix Drupal 10.3 compatibility for Too few arguments to function deliver() 3 passed #44

## [10.0.27] - 2024-06-20

- Update the list of patches for Drupal Core to be compatible with Drupal ~10.3.0 #43
- Update the list of patches for Drupal Core to be compatible with Drupal ~10.3.0 #43
- Update the list of patches for Drupal Core to be compatible with Drupal ~10.3.0 #43

## [10.0.26] - 2024-06-20

- Restrict old list of Drupal core's patches to Drupal ~10.2.0 in the 10.0.x branch and release the 10.0.26 tag #42

## [10.0.25] - 2024-06-16

- Update the patch for The Gin Admin theme for Issue #3325263: Fix user.data ServiceNotFoundException when using Gin as distribution installer theme after Gin 8.x-3.0-rc11 #37

## [10.0.24] - 2024-06-06

- Remove the committed patch for Views Bulk Operations (VBO) module to Issue #3334229: Update existing 'node' entity while changing the ID is not supported when using delete action after VBO 4.2.7 #36

## [10.0.23] - 2024-06-05

- Remove the patch for UI Patterns Settings to fix #3409221: Fix TypeError: array_unshift(): Argument #1 () must be of type array, null given in array_unshift() Caused by Deprecated Hooks in Drupal ~10.2.0 #35

## [10.0.22] - 2024-06-04

- Add a patch to the Layout Builder Advanced Permissions module for Issue #3392780: Fix not valid context for entity context when editing the default layout entity types or bundles #34

## [10.0.21] - 2024-06-02

- Add Patch for Gin Type Tray from Issue #3450665: Fix Twig Error Loader Error when attempting to add new content (#33)

## [10.0.20] - 2024-05-27

- Remove the patch for Issue #3449903: Add the "use keysave" permission to the Keysave module to be able to control access by user roles #31

## [10.0.19] - 2024-05-26

- Fix wrong merge conflict commit
- Add patch for the issue #3448085: Add Gin Type Tray module to Varbase Admin and enable it by default (#26)
- Add the patch for new feature Issue #3449903: Add the "use keysave" permission to the Keysave module to be able to control access by user roles #29

## [10.0.18] - 2024-05-15

- Remove all patches for the Content Lock module as they are committed in 2.4.0 #24

## [10.0.17] - 2024-05-15

- Add patch for the issue #3436449: The status tab is showing out in the Are you sure you want to delete the content item page

## [10.0.16] - 2024-05-07

- Remove patch to enable the Term Merge module with the Taxonomy Manager module as the issue was fixed into the 2.0.11 release #21
- Remove all patches for the Taxonomy Manager module as they are fixed into the 2.0.11 release #21

## [10.0.15] - 2024-05-01

- Add the patch for Issue #3444588: Switch from base_path to origin_url to fix issues when retrieving the path of the CKEditor plugins for use in a URL #19

## [10.0.14] - 2024-04-30

- Change the patch to Issue #3444071: Enable the Term Merge module - with a better logic #18

## [10.0.13] - 2024-04-30

- Add the patch to Issue #3444071: Enable the Term Merge module #18

## [10.0.12] - 2024-04-29

- Add the patch for Issue #3213205: Fix Redirects to external URLs are not allowed by default, after saving a term in Taxonomy Manager #17

## [10.0.11] - 2024-04-20

- Revert -- ignore-dependency-patches to Remove the patch for Issue #3437739: SchedulerManager should take an EventDispatcherInterface object, not ContainerAwareEventDispatcher #16

## [10.0.10] - 2024-04-20

- ignore-dependency-patches to Remove the patch for Issue #3437739: SchedulerManager should take an EventDispatcherInterface object, not ContainerAwareEventDispatcher #16

## [10.0.9] - 2024-04-16

- Add a patch for Drupal Core to Add Action Method to Add a button plugin and settings into the Active toolbar in editor #12

## [10.0.8] - 2024-04-08

- Remove the committed patch for Issue #3348548: Fix Entity queries must explicitly set whether the query should be access checked or not in Password Policy #10

## [10.0.7] - 2024-04-07

- Add drupal-core--distributions_recipes--2024-03-06--4683c884--recipe-10.2.x.patch to patches #9

## [10.0.6] - 2024-04-07

- Add drupal-core--distributions_recipes--2024-03-06--4683c884--recipe-10.2.x.patch to patches #9

## [10.0.5] - 2024-04-07

- Update Drupal Recipes patch to work with latest Drupal version #6
- Update the README.md and composer.json with info #5

## [10.0.4] - 2024-04-07

- Update the README.md and composer.json with info

## [10.0.3] - 2024-04-03

- Update distributions recipes recipe-10.2.x.patch #2

## [10.0.2] - 2024-04-02

- Initialize varbase-patches for Varbase ~10.0.0 #1

## [10.0.1] - 2024-04-02

- Initialize varbase-patches for Varbase ~10.0.0 #1

## [10.0.0] - 2024-04-02

- Initial tracked release on the `10.0.x` branch.

