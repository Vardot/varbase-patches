<?php

/**
 * @file
 * Verifies that every patch file this branch points at physically exists.
 *
 * For every URL in composer.json extra.patches:
 *   - the URL must return HTTP 200 with a non-empty body,
 *   - the body must look like a unified diff (--- / +++ / @@ hunks),
 *   - and if it is a raw.githubusercontent.com URL served from this repo's
 *     "patches" branch, the file must also exist in that branch of the
 *     canonical repository (the CDN can serve a stale copy of a deleted file).
 *
 * Usage:
 *   git fetch --depth=1 https://github.com/Vardot/varbase-patches.git patches:refs/remotes/upstream/patches
 *   php tests/verify-patch-files.php [patches-branch-ref]
 */

declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$patchesRef = $argv[1] ?? 'upstream/patches';

$plugin = json_decode((string) file_get_contents($repoRoot . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);
$patches = $plugin['extra']['patches'] ?? [];

if ($patches === []) {
    fwrite(STDERR, "No patches declared in composer.json extra.patches.\n");
    exit(1);
}

/**
 * Fetches a URL, following redirects, and returns [status, body].
 */
function fetch(string $url): array
{
    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'follow_location' => 1,
            'max_redirects' => 5,
            'timeout' => 60,
            'ignore_errors' => true,
            'header' => "User-Agent: varbase-patches-ci\r\n",
        ],
    ]);

    $body = @file_get_contents($url, false, $context);
    $status = 0;
    foreach ($http_response_header ?? [] as $header) {
        if (preg_match('#^HTTP/\S+\s+(\d{3})#', $header, $m) === 1) {
            $status = (int) $m[1];
        }
    }

    return [$status, $body === false ? '' : $body];
}

function looksLikeDiff(string $body): bool
{
    return str_contains($body, '@@')
        && (str_contains($body, "\n--- ") || str_starts_with($body, '--- ') || str_contains($body, 'diff --git'));
}

/**
 * Returns the path inside the "patches" branch for a self-hosted patch URL.
 */
function selfHostedPath(string $url): ?string
{
    $pattern = '#^https://raw\.githubusercontent\.com/[Vv]ardot/varbase-patches/(?:refs/heads/)?patches/(.+)$#';

    return preg_match($pattern, $url, $m) === 1 ? $m[1] : null;
}

$failures = [];
$checked = 0;
$selfHosted = 0;

foreach ($patches as $package => $packagePatches) {
    foreach ($packagePatches as $description => $url) {
        $checked++;
        [$status, $body] = fetch($url);

        if ($status !== 200) {
            $failures[] = sprintf('%s: HTTP %d — %s (%s)', $package, $status, $url, $description);
            continue;
        }

        if (trim($body) === '') {
            $failures[] = sprintf('%s: empty patch body — %s', $package, $url);
            continue;
        }

        if (!looksLikeDiff($body)) {
            $failures[] = sprintf('%s: body is not a unified diff — %s', $package, $url);
            continue;
        }

        $path = selfHostedPath($url);
        if ($path !== null) {
            $selfHosted++;
            $ref = escapeshellarg($patchesRef . ':' . $path);
            exec("git -C " . escapeshellarg($repoRoot) . " cat-file -e {$ref} 2>/dev/null", $out, $code);
            if ($code !== 0) {
                $failures[] = sprintf('%s: file missing from %s — %s', $package, $patchesRef, $path);
                continue;
            }
        }

        printf("  OK  %-45s %s\n", $package, basename(parse_url($url, PHP_URL_PATH) ?: $url));
    }
}

printf(
    "\n%d patch URLs checked (%d served from this repo's \"%s\" branch).\n",
    $checked,
    $selfHosted,
    $patchesRef
);

if ($failures !== []) {
    fwrite(STDERR, "\nFAIL — missing or invalid patch files:\n");
    foreach ($failures as $failure) {
        fwrite(STDERR, '  - ' . $failure . "\n");
    }
    exit(1);
}

echo "PASS — every patch file this branch points at exists and is a valid diff.\n";
