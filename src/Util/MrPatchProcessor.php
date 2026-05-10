<?php

namespace Vardot\VarbasePatches\Util;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Downloads merge-request patch URLs to a local ./patches/ folder using a
 * deterministic timestamped filename, and returns the local path to use as the
 * replacement value in composer.json / patches-file JSON.
 */
class MrPatchProcessor
{
    private string $root;
    private string $patchesDir;
    private OutputInterface $output;

    public function __construct(string $root, OutputInterface $output)
    {
        $this->root = rtrim($root, '/');
        $this->patchesDir = $this->root . '/patches';
        $this->output = $output;
    }

    public static function isMrUrl(string $url): bool
    {
        return str_contains($url, '/-/merge_requests/');
    }

    public function process(string $package, string $title, string $url): ?string
    {
        if (!is_dir($this->patchesDir) && !mkdir($this->patchesDir, 0777, true) && !is_dir($this->patchesDir)) {
            $this->output->writeln("<error>Unable to create patches directory: {$this->patchesDir}</error>");
            return null;
        }

        $patch = $this->fetch($url);
        if ($patch === null || $patch === '') {
            $this->output->writeln("Unable to retrieve patch {$url}");
            return null;
        }

        $packageSlug = $package === 'drupal/core'
            ? 'drupal-core--'
            : str_replace('drupal/', '', $package) . '--';

        $fetchDate = date('Y-m-d') . '--';

        $issueId = '';
        if (preg_match('/#(\d+)/', $title, $m)) {
            $issueId = $m[1] . '--';
        } else {
            $this->output->writeln("Unable to retrieve the issue ID from \"{$title}\" from {$package} package patches list.");
        }

        $mrId = 'mr';
        $parts = explode('/-/merge_requests/', $url);
        if (isset($parts[1]) && preg_match('/(\d+)/', $parts[1], $m2)) {
            $mrId = 'mr-' . $m2[0];
        } else {
            $this->output->writeln("Unable to retrieve the merge request ID from \"{$url}\" for {$package} package.");
        }

        $filename = $packageSlug . $fetchDate . $issueId . $mrId . '.patch';
        $fullPath = $this->patchesDir . '/' . $filename;

        if (file_put_contents($fullPath, $patch) === false) {
            $this->output->writeln("Unable to save patch file {$filename}");
            return null;
        }

        $this->output->writeln("Processed the patch for \"{$title}\" for the {$package} package");
        $this->output->writeln("From: {$url}");
        $this->output->writeln("To: ./patches/{$filename}");

        return './patches/' . $filename;
    }

    private function fetch(string $url): ?string
    {
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'varbase-patches/1.0');
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: text/plain, text/x-diff, */*']);
            $body = curl_exec($ch);
            $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($body === false || $code >= 400) {
                return null;
            }
            return $body;
        }
        $ctx = stream_context_create([
            'http' => ['follow_location' => 1, 'user_agent' => 'varbase-patches/1.0'],
        ]);
        $body = @file_get_contents($url, false, $ctx);
        return $body === false ? null : $body;
    }
}
