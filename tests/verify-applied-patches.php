<?php

/**
 * @file
 * Verifies that composer-patches applied every Varbase patch it could.
 *
 * Run after `composer install` inside the test project (tests/build). For every
 * entry in this branch's composer.json extra.patches it asserts that:
 *   - the patch was applied to the installed package — evidenced by
 *     patches.lock.json (cweagans/composer-patches v2) or by the patch URL in
 *     the install log (v1 and v2 both print the URL of each applied patch).
 *
 * Patched packages that the test project does not install (a module that has
 * no release for this branch's Drupal core, for example) are reported as
 * skipped, not failed — there is nothing to patch.
 *
 * Usage:
 *   php tests/verify-applied-patches.php <test-project-dir> <install-log>
 */

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$projectDir = $argv[1] ?? $repoRoot . '/tests/build';
$logFile = $argv[2] ?? '';

if ($logFile === '' || !is_file($logFile)) {
    fwrite(STDERR, "Usage: php tests/verify-applied-patches.php <test-project-dir> <install-log>\n");
    exit(1);
}

$plugin = json_decode((string) file_get_contents($repoRoot . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);
$patches = $plugin['extra']['patches'] ?? [];

$lock = json_decode((string) file_get_contents($projectDir . '/composer.lock'), true, 512, JSON_THROW_ON_ERROR);
$installed = [];
foreach (array_merge($lock['packages'] ?? [], $lock['packages-dev'] ?? []) as $package) {
    $installed[$package['name']] = $package['version'];
}

$log = (string) file_get_contents($logFile);
$patchesLock = is_file($projectDir . '/patches.lock.json')
    ? (string) file_get_contents($projectDir . '/patches.lock.json')
    : '';

$failures = [];
$skipped = [];
$applied = 0;
$total = 0;

foreach ($patches as $package => $packagePatches) {
    if (!isset($installed[$package])) {
        $skipped[] = sprintf('%s (%d patch(es)) — package not installed by this test project', $package, count($packagePatches));
        continue;
    }

    foreach ($packagePatches as $description => $url) {
        $total++;

        if (str_contains($log, $url) || ($patchesLock !== '' && str_contains($patchesLock, $url))) {
            $applied++;
            printf("  OK  %-42s %s\n", $package . ' (' . $installed[$package] . ')', $description);
            continue;
        }

        $failures[] = sprintf('%s (%s): patch was not applied — %s', $package, $installed[$package], $url);
    }
}

printf("\n%d of %d patches applied on installed packages.\n", $applied, $total);

if ($skipped !== []) {
    echo "\nSkipped (nothing to patch):\n";
    foreach ($skipped as $skip) {
        echo '  - ' . $skip . "\n";
    }
}

if ($failures !== []) {
    fwrite(STDERR, "\nFAIL — patches declared but not applied:\n");
    foreach ($failures as $failure) {
        fwrite(STDERR, '  - ' . $failure . "\n");
    }
    exit(1);
}

if ($applied === 0) {
    fwrite(STDERR, "\nFAIL — no patch was applied at all; composer-patches is not running.\n");
    exit(1);
}

echo "\nPASS — composer-patches applied every Varbase patch on every installed package.\n";
