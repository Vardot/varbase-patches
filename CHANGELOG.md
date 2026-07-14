# Changelog — Vardot/varbase-patches (`9.1.x`)

All notable changes on the `9.1.x` branch of [`Vardot/varbase-patches`](https://github.com/Vardot/varbase-patches), newest first.
Each release lists the commits — merged pull requests and the drupal.org issues they reference — since the previous release.
`#N` links to the pull request; 7-digit `#NNNNNNN` refs are drupal.org issues. Generated from git history.

## [Unreleased]

## [9.1.91] - 2026-07-13

- ci: Add a GitHub Actions patches test — installs Drupal and the modules this branch patches from `tests/test.composer.json`, asserts Composer Patches (v1 and v2) applies every Varbase patch, and checks that every patch file still exists

- Change a patch for the Inline Entity Form module for Add a setting to enable/disable inline editing for existing entities (#2913571) — the 2024-12-27 file no longer applies to Inline Entity Form 3.0.0 (#488)

## [9.1.90] - 2026-07-06

- docs: document drupal-core-patches and update the patch-ignore guidance (#405)
- docs: Add CHANGELOG.md for the 9.1.x branch (#428)
- fix: #450 Remove the openapi_jsonapi #3079209 patch on 9.1.x (implemented upstream in 3.x) (#451)
- Change a patch for the Rabbit Hole module for Fix Return value must be of type bool fatal error (#3419073) — for Varbase 9.1.x (#461)

## [9.1.89] - 2026-06-28

- docs: PR/MR template with Checkpoints (no UX/UI line)
- fix: [9.1.x] apply vardot/drupal-core-patches by default (allowed-dependency-patches) (#396)
- task: require vardot/drupal-core-patches (~10 || ~11 || ~12); move drupal/core patches out (#389)

## [9.1.88] - 2026-06-25

- Change patch for the Paragraphs module on Issue #3090200: Paragraph access check using incorrect revision of its parent, leading to issues editing and viewing paragraphs when content moderation is involved #385

## [9.1.87] - 2026-05-20

- Add a patch for the reCAPTCHA module on fix: #3588269 Make Drupal8Post::submit() compatible with parent #368

## [9.1.86] - 2026-05-14

- Issue #366: Backport in-repo AI agent + skills (AGENTS.md / CLAUDE.md / .claude/) to 9.1.x
- Issue #365: Rename docs/index.md to docs/README.md and refresh docs landing for branch 9.1.x

## [9.1.85] - 2026-05-11

- Issue #363: Drop the extra.plugin-modifies-downloads and extra.plugin-modifies-install-path flags from composer.json. Those promote the plugin to early activation, which makes Composer's autoloader require() drupal/core's includes/bootstrap.inc before drupal/core has been extracted on a fresh composer create-project, causing "Plugin initialization failed ... Failed to open stream" and "Install of vardot/varbase-patches failed". The plugin's late-activation path (POST_PACKAGE_INSTALL of self, with reflection-driven lock rewrite for v2 and patch-map rebuild for v1) already covers the in-flight re-resolve, so the early-load flags are unnecessary.
- add missing Composer dependencies required for Varbase project installation #363
- Issue #363: Move the autoload block in composer.json so it sits immediately after the require block, before extra. JSON-equivalent change; the file still parses identically.
- Issue #363: Reformat composer.json patch entries to two indented lines (description on its own line, URL on the next) for readability, matching the long-standing layout used in older releases. JSON-equivalent change; the file still parses identically.
- Issue #363: Support cweagans/composer-patches ~1.7.0 || ~2.0 and drop the static version field from composer.json. The plugin now detects the installed cweagans version at runtime: on v2 it keeps the existing FilteredDependencies + patches.lock.json rewrite path; on v1 it rebuilds cweagans v1's in-memory patches map from composer.lock (applying allowed-dependency-patches, ignore-dependency-patches wildcards, and patches-ignore) and sets it via reflection before postInstall runs. Composer commands varbase-patches:cleanup:patches and :cleanup:patches-file work on both versions. The static "version" field is removed; the package version is now derived from the git branch/tag.
- Issue #363: Document the patches-ignore handling for Varbase Patches in README.md and docs/configuration.md. Mirrors the upstream Varbase docs layout (https://docs.varbase.vardot.com/developers/varbase-patches), shows the v1-style description-keyed schema and the equivalent flat-array schema. URL string is what matches; description is informational.
- Issue #363: Clean up README.md commands section. Restore the "List of needed patches for Varbase used packages with Composer Patches." tagline. Replace the cramped commands table with a readable, default-markdown layout (Name / Aliases / Description bullet lists plus invocation code blocks). Add a Filename convention example. No GitBook syntax.
- Issue #363: Add Composer commands varbase-patches:cleanup:patches and varbase-patches:cleanup:patches-file (aliases var-ccup and var-ccupf) to convert merge-request URLs to local timestamped patch files. Replaces the equivalent Drush commands previously shipped in varbase_core. Adds docs/ and rewrites README.md.
- Issue #362: Convert varbase-patches into a Composer plugin to add wildcard ignore-dependency-patches, allowed-dependency-patches allowlist, and patches-ignore (v1-style) support over cweagans/composer-patches v2.

## [9.1.84] - 2026-04-26

- Change a patch for the Redirect module on feat: #2879648 Redirects from aliased paths aren't triggered -- After 8.x-1.13 was released #358
- Remove a patch for the Redirect module on fix: #3057250 Validation issue on adding url redirect -- After 8.x-1.13 was released #356

## [9.1.83] - 2026-04-22

- Remove a patch for the Scheduler content moderation integration module on Issue #3543642: Fix duplicates bundles for cleaner output -- After 3.0.5 was released #352

## [9.1.82] - 2026-04-07

- Remove a patch for the Page Manager module on Issue #3438993: Some mandatory parameters are missing (machine_name, step) to generate a URL for route entity.page.devel_load #344

## [9.1.81] - 2026-01-22

- Change a patch for the OpenAPI for JSON:API module on feat: #3079209 Hide POST, PUT, and DELETE endpoints when JSON:API is configured to be read-only #313
- Change a patch for Drupal Core on Issue #3326684: Fix PHP8.1+ Deprecated function: mb_strtolower(): Passing null to parameter #1 () of type string is deprecated - for Drupal 10.6.2 #309
- Remove a patch for Drupal core on Issue #3044656: Add a helper method to strip subdirectories from URL paths #307
- Change a patch for Drupal Core on feat: #3080606 add Reorder Layout Builder sections -- for Drupal 10.6.2 #306
- Change a patch for the Layout Library module on Issue #3075067: Duplicate entry for key 'block_content_field__uuid__value' #304
- Remove a patch for Drupal Core on Issue #3226791: Fix Validation error saving untranslatable Media reference field #299
- Remove a patch for Drupal Core on Issue #3496329: Fix not loading CKEditor 5 and Tour with BigPipe enabled after Drupal 10.4 update #289

## [9.1.80] - 2026-01-18

- Remove a patch for the Diff module on Issue #3348096: Fix Entity queries must explicitly set whether the query should be access checked or not in Diff #284

## [9.1.79] - 2026-01-12

- Remove a patch for the Smart Trim module on fix: #3566575 Call to undefined function _token_field_label() #273

## [9.1.78] - 2026-01-11

- Add a patch for the Smart Trim module on fix: #3566575 Call to undefined function _token_field_label() #271

## [9.1.77] - 2025-12-31

- Change a patch for Drupal Core on Issue #3049332: Fix Log error + visual warning for missing or broken block #267
- Update Drupal Core to ~10.6.0 #221

## [9.1.76] - 2025-11-23

- Remove a patch for Issue #3421309: Fix Unable to save Access Unpublished settings form due to TypeError in Drupal Core Render Element::children() #216

## [9.1.75] - 2025-09-08

- Add a patch for the Content Planner module on Issue #3545519: Fix Prevent fatal error when entity cannot be loaded #206

## [9.1.74] - 2025-09-04

- Change a patch for the Redirect module on Issue #2879648: Redirects from aliased paths aren't triggered after 8.x-1.12 was released #199
- Change a patch for the Redirect module on Issue #3057250: Validation issue on adding url redirect after 8.x-1.12 was released #198

## [9.1.73] - 2025-09-03

- Add a patch for the Views Bulk Edit module on Issue #3544584: Change default Change method to Replace the current value when configuring Modify field values action #204

## [9.1.72] - 2025-08-30

- Add  a patch for the Redirect module on Issue #2879648: Redirects from aliased paths aren't triggered after 8.x-1.12 was released #199
- Add a patch for Drupal Core on Issue #3538500: Fix block plugin not found warnings during Drush installation #201
- Add a patch for the Scheduler content moderation integration module on Issue #3543642: Fix duplicates bundles for cleaner output #200
- Change a patch for the Redirect module on Issue #2879648: Redirects from aliased paths aren't triggered after 8.x-1.12 was released #199
- Change a patch for the Redirect module on Issue #3057250: Validation issue on adding url redirect after 8.x-1.12 was released #198

## [9.1.71] - 2025-08-21

- Add a patch for the DropzoneJS module on Issue #3542463: Fix TypeError: count(): Argument #1 () must be of type Countable|array, null given in DropzoneJsUploadForm::validateUploadElement() #192

## [9.1.70] - 2025-08-11

- Add a patch for Access Unpublished module on Issue #3421309: Fix Unable to save 'Access Unpublished' settings form due to TypeError in Drupal\Core\Render\Element::children() #177

## [9.1.69] - 2025-07-30

- Change the path for Varbase Patches storage branch with refs/heads/patches for the patches branch #187

## [9.1.68] - 2025-06-23

- Remove a patch for Drupal Core on Issue #3413079: Cannot read properties of null (reading 'nodeType') on node.page.body #162
- Remove a patch for Drupal Core on Issue #2869592: Disabled update module shouldn't produce a status report warning #161
- Update Drupal Core from ~10.4.0 to ~10.5.0 #157

## [9.1.67] - 2025-05-15

- Remove a patch for the Tour module on #3506084: Remove the Tour module does not have integration with Navigation warning when saving any config as Tour 2.0.9 was released #151

## [9.1.66] - 2025-05-08

- Remove a patch Drupal Core on Issue #3458067: Fix contextual links disappear intermittently leading to console errors #150

## [9.1.65] - 2025-04-23

- Remove a patch for Block Class module on Issue #3467450: Failsafe conversion of block_classes_stored after Block Class 4.0.1 was released #149

## [9.1.64] - 2025-04-23

- Remove a patch for Field Group module on Issue #2969051: Fix HTML5 validation prevents submission in tabs #147
- Remove a patch for Field Group module on Issue #3491233: Fix Drupal 10.4 RC1 error with field_ui.js after Field Group 4.0.0 stable was released #146

## [9.1.63] - 2025-03-29

- Add a patch for Block Class module on Issue #3493849: Argument #1 () must be of type array, string given #145
- Add a patch for Block Class module on Issue #3467450: Failsafe conversion of block_classes_stored #144

## [9.1.62] - 2025-02-16

- Change a path for Drupal Core on Issue #2741877: Nested modals don't work: opening a modal from a modal closes the original #133

## [9.1.61] - 2025-02-12

- Change a patch for Tour module on Issue #3506084: Remove the Tour module does not have integration with Navigation warning when saving any config #132
- Remove a patch for Layout Builder Restrictions on Issue #3491116: Fix inlineBlocksAllowedinContext() not checking for View Display in Entity View Mode Restriction #131

## [9.1.60] - 2025-02-12

- Add a patch for Layout Builder Restriction on Issue #3491116: Fix inlineBlocksAllowedinContext() not checking for View Display in Entity View Mode Restriction #130
- Add a patch for Tour module on Issue #3506084: Remove the Tour module does not have integration with Navigation warning when saving any config #129
- Remove Documentation for 10.1.0 Until Stable Release #128

## [9.1.59] - 2025-02-06

- Change a patch for Drupal Core on Issue #2741877: Nested modals don't work: opening a modal from a modal closes the original #127

## [9.1.58] - 2025-02-05

- Remove a patch for Scheduler module on Issue #3498553: BC event class aliases are not always being loaded #126

## [9.1.57] - 2025-01-26

- Add a patch for Drupal Core on Issue #3497061: Allow recipe input values in array keys #122

## [9.1.56] - 2025-01-20

- Add a patch for Field Group module on Issue #2969051: Fix HTML5 validation prevents submission in tabs #118
- Add a patch for Field Group on Issue #3491233: Fix Drupal 10.4 RC1 error with field_ui.js #117
- Add a patch for Field Group on Issue #3491233: Fix Drupal 10.4 RC1 error with field_ui.js #117
- Add a patch for Scheduler module on Issue #3498553: Sheduler upgrade 2.2.0 and content planner 8.x-1.2 #116
- Remove a patch for Real-time SEO module on Issue #3362165: Fix Deprecated function: Creation of dynamic property #115

## [9.1.55] - 2025-01-14

- Remove a patch for Drupal Core on Issue #3165435: Fix tour <front> route as route name when a selected node had been set as the front page for the site #113

## [9.1.54] - 2025-01-04

- Change a patch for Inline Entity Form module on Issue #3136514: IEF complex widget: Re-ordering / weight sometimes not updated #111
- Change a patch for Drupal Core on Issue #3496329: Fix not loading CKEditor 5 and Tour with BigPipe enabled after Drupal 10.4 update #110
- Change a patch for Drupal Core on Issue #3496329: Fix not loading CKEditor 5 and Tour with BigPipe enabled after Drupal 10.4 update #110

## [9.1.53] - 2024-12-31

- Add a patch for Drupal Core on Issue #3496329: Fix not loading CKEditor 5 and Tour on existing content after Drupal 10.4 update #109
- Add a patch for Inline Entity Form module on Issue #2913571: Add a setting to enable/disable inline editing for existing entities #108
- Change a patch for Inline Entity Form on Issue #3136514: IEF complex widget: Re-ordering / weight sometimes not updated to work with IEF ~3.0 #107
- Remove a patch for Inline Entity Form module on Issue #3143422: Allow to hide the Edit button in Complex widget #106
- Update Drupal Core from ~10.3.0 to ~10.4.0 for Varbase Patches #105

## [9.1.52] - 2024-12-08

- Remove a patch for Editoria11y Accessibility Checker module on Issue #3492469: Fix Error: Call to Member Function id() on Null in editoria11y Page Attachments() During Content Type Creation #103

## [9.1.51] - 2024-12-08

- Add a patch for Editoria11y Accessibility Checker module on Issue #3492469: Fix Error: Call to Member Function id() on Null in editoria11y Page Attachments() During Content Type Creation #102

## [9.1.50] - 2024-12-08

- Remove a patch for Content Moderation Notifications module on Issue #3347958: Fix Entity queries must explicitly set whether the query should be access checked or not in Content Moderation Notifications #101

## [9.1.49] - 2024-12-02

- Change a patch for the Default Content module on Issue #3160146: Add a Normalizer and Denormalizer to support Layout Builder #100
- Change a patch for the Default Content module on Issue #3160146: Add a Normalizer and Denormalizer to support Layout Builder #100

## [9.1.48] - 2024-11-17

- Remove a patch for Security Review module on Issue #3463712: Fix fatal error when pressing Run checklist button #98

## [9.1.47] - 2024-11-13

- Change a patch for the Default Content module on Issue #3160146: Add a Normalizer and Denormalizer to support Layout Builder #97
- Remove a patch for Varbase 9.1.x profile on Issue #3479338: Fix style for active menu in Admin Toolbar on Claro Theme after updating to Drupal Core 10.3.6 #96
- Update the README.md file after the 10.1.x new branch #94

## [9.1.46] - 2024-10-08

- Add a patch for Varbase 9.1.x profile on Issue #3479338: Fix style for active menu in Admin Toolbar on Claro Theme after updating to Drupal Core 10.3.6 #88

## [9.1.45] - 2024-10-03

- Remove a patch for Drupal Core on Issue #3457168: Since twig/twig 3.9: error with twig_escape_filter function usage in /core/lib/Drupal/Core/Template/TwigExtension.php #87
- Remove a patch for Drupal Core on Issue #3457168: Since twig/twig 3.9: error with twig_escape_filter function usage in /core/lib/Drupal/Core/Template/TwigExtension.php #87

## [9.1.44] - 2024-10-01

- Remove the patch for JSON:API Extras on Issue #3473990: Fix PHP Fatal error on declaration of the normalize function must be compatible with normalize function return type after JSON:API Extras 8.x-3.26 was released #85

## [9.1.43] - 2024-09-12

- Add a commit patch for JSON:API Extras on Issue #3473990: Fix PHP Fatal error on Declaration of the normalize function must be compatible with normalize function return type after Schemata 8.x-1.0 was released #83

## [9.1.42] - 2024-09-12

- Add a patch for Drupal Core on Issue #3457168: Since twig/twig 3.9: error with twig_escape_filter function usage in /core/lib/Drupal/Core/Template/TwigExtension.php #82

## [9.1.41] - 2024-09-04

- Remove a patch for Issue #3471821: Fix The specified library bootstrap_barrio/messages does not exist issue #81

## [9.1.40] - 2024-09-03

- Add a patch for Bootstrap 4 Barrio theme on Issue #3471821: Fix The specified library bootstrap_barrio/messages does not exist issue #80

## [9.1.39] - 2024-08-15

- Remove a patch for Webform Views Integration module on __ Issue #3467786: Fix Major error causes WSOD Error: Uncaught TypeError __ after webform_views 8.x-5.4 was released #76

## [9.1.38] - 2024-08-13

- Remove a patch for Password Policy module on Issue #3465364: Fix Fatal error when changing password when password_policy_history is enabled after password_policy 4.0.3 was released #74

## [9.1.37] - 2024-08-13

- Add a patch for Webform Views Integration module on Issue #3467786: Fix Major error causes WSOD Error: Uncaught TypeError #7

## [9.1.36] - 2024-08-13

- Remove a patch for Webform Views Integration module on Issue #3386492: Fix Fatal error on Drupal 9/10 : ArgumentCountError: Too few arguments to function EntityViewsData::__construct(), 6 passed after webform_views 8.x-5.3 was released #72

## [9.1.35] - 2024-08-11

- Update patches for the Redirect module after redirect 8.x-1.10 was released #70
- Remove a patch for Entity Embed module on Issue #3466609: Entity Embed fails to install after Embed module update #71

## [9.1.34] - 2024-08-07

- Add a patch for Entity Embed on Issue #3466609: Entity Embed fails to install after Embed module update #68

## [9.1.33] - 2024-08-07

- Add a patch for Password Policy on Issue #3465364: Fatal error when changing password when password_policy_history is enabled #67

## [9.1.32] - 2024-08-03

- Remove a patch for Admin Toolbar module on Issue #3338408: Resolve access check errors for D10 compatibility after admin toolbar 3.5.0 was released #66

## [9.1.31] - 2024-08-01

- Add a patch for Drupal Core on Issue #3465033: Fix not saving addItemToToolbar recipe action for divider | (vertical separator) or wrapping - items to CKEditor 5 #65

## [9.1.30] - 2024-07-30

- Remove a patch for the Email Registration module on Issue #3456461: [2.x] Login fails with Drupal 10.3 after Email Registration 2.0.0-rc6 was released #63

## [9.1.29] - 2024-07-25

- Add the patch for Security Review module on Issue #3463712: Fix fatal error when pressing Run checklist button #62

## [9.1.28] - 2024-07-13

- Remove the patch for OpenAPI on Issue #3362322: PHP 8.2 Deprecations #57

## [9.1.27] - 2024-07-08

- Add a patch for Drupal Core 10.3.1 on Issue #3459881: Fix TypeError: implode(): Argument #1 () must be of type array, string given in implode() (line 537 of core/lib/Drupal/Core/Field/WidgetBase.php) #56

## [9.1.26] - 2024-07-07

- Add a patch for Node Edit Protection module on Issue #3455823: Fix the warning issue that occurs when pressing the save submit button in the Gin Admin theme #55

## [9.1.25] - 2024-07-02

- Add a patch for Varbase Core CKEditor 5 on Issue #3457431: Fix validation warnings when saving text format by remove inactive filters from the list of filters to validate for the text format #52

## [9.1.24] - 2024-06-30

- Add a patch for Drupal Core on Issue #3458067: Fix contextual links disappear intermittently leading to console errors #51

## [9.1.23] - 2024-06-29

- Add a TEMP patch for Drupal Core Big Pipe module on Issue #3456176: 10.3 upgrade now missing status-message theme suggestions #50

## [9.1.22] - 2024-06-25

- Add a patch for the Email Registration module on Issue #3456461: [2.x] Login fails with Drupal 10.3 #49

## [9.1.21] - 2024-06-20

- Update the list of patches for Drupal Core to be compatible with Drupal ~10.3.0 #43
- Update the list of patches for Drupal Core to be compatible with Drupal ~10.3.0 #43
- Update the list of patches for Drupal Core to be compatible with Drupal ~10.3.0 #43
- Update the list of patches for Drupal Core to be compatible with Drupal ~10.3.0 #43

## [9.1.20] - 2024-06-20

- Restrict old list of Drupal core's patches to Drupal ~10.2.0 in the 9.1.x branch and release the 9.1.20 tag #40

## [9.1.19] - 2024-06-06

- Remove the committed patch for Views Bulk Operations (VBO) module to Issue #3334229: Update existing 'node' entity while changing the ID is not supported when using delete action after VBO 4.2.7 #36

## [9.1.18] - 2024-05-20

- Update the patch for Issue #2900313: Add ability to embed media and other rich content in WYSIWYG with Varbase Editor [Rich editor] Text format #27

## [9.1.17] - 2024-05-15

- Remove all patches for the Content Lock module as they are committed in 2.4.0 #24

## [9.1.16] - 2024-05-01

- Add the patch for Issue #3444588: Switch from base_path to origin_url to fix issues when retrieving the path of the CKEditor plugins for use in a URL #19

## [9.1.15] - 2024-04-18

- Remove the patch for Issue #3366524: Fix Creation of dynamic property  is deprecated #15

## [9.1.14] - 2024-04-18

- Update the patch for Issue #2900313: Add ability to embed tweets and other rich content in WYSIWYG with Varbase Editor [Rich editor] Text format #14

## [9.1.13] - 2024-04-18

- Remove committed patch for Issue #3393693: Add Drush 12 compatibility for custom CKEditor Media Embed Plugin commands #13

## [9.1.12] - 2024-04-16

- Add a patch for Drupal Core to Add Action Method to Add a button plugin and settings into the Active toolbar in editor #12

## [9.1.11] - 2024-04-14

- Add a patch for the Page Manager module to fix Issue #3438993: Some mandatory parameters are missing (machine_name, step) to generate a URL for route entity.page.devel_load #11

## [9.1.10] - 2024-04-08

- Remove the committed patch for Issue #3348548: Fix Entity queries must explicitly set whether the query should be access checked or not in Password Policy #10

## [9.1.9] - 2024-04-07

- Remove the Drupal Recipes patch from old Varbase 9 versions #8

## [9.1.8] - 2024-04-07

- Update Drupal Recipes patch to work with latest Drupal version #6
- Update the README.md and composer.json with info #5

## [9.1.7] - 2024-04-07

- Update the README.md and composer.json with info

## [9.1.6] - 2024-04-04

- Revert - Remove the patch for Issue #2869592: Disabled update module shouldn't produce a status report warning #3

## [9.1.5] - 2024-04-03

- Remove the patch for Issue #2869592: Disabled update module shouldn't produce a status report warning #3

## [9.1.4] - 2024-04-03

- Update distributions recipes recipe-10.2.x.patch #2

## [9.1.3] - 2024-04-03

- Update distributions recipes recipe-10.2.x.patch #2

## [9.1.2] - 2024-04-02

- Initialize varbase-patches for Varbase ~9.1.0 #1

## [9.1.1] - 2024-04-02

- Initialize varbase-patches for Varbase ~9.1.0 #1

## [9.1.0] - 2024-04-02

- Initial tracked release on the `9.1.x` branch.

