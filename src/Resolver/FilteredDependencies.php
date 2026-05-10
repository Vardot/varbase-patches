<?php

namespace Vardot\VarbasePatches\Resolver;

use cweagans\Composer\Patch;
use cweagans\Composer\PatchCollection;
use cweagans\Composer\Resolver\ResolverBase;

/**
 * Replacement Dependencies resolver with:
 *  - Wildcard support in ignore-dependency-patches (fnmatch).
 *  - Allowlist via allowed-dependency-patches (default: vardot/varbase-patches).
 *  - patches-ignore semantics from composer-patches v1.
 *
 * Config (root composer.json):
 *   extra.composer-patches.ignore-dependency-patches: ["drupal/*", ...]
 *   extra.composer-patches.allowed-dependency-patches: ["vardot/varbase-patches"]
 *   extra.patches-ignore: { "<source-pkg>": { "<target-pkg>": ["<url>", ...] } }
 */
class FilteredDependencies extends ResolverBase
{
    public function resolve(PatchCollection $collection): void
    {
        $locker = $this->composer->getLocker();
        if (!$locker->isLocked()) {
            $this->io->write('  - <info>Composer lock file does not exist.</info>');
            $this->io->write('  - <info>Patches defined in dependencies will not be resolved.</info>');
            return;
        }

        $this->io->write('  - <info>Resolving patches from dependencies (varbase-patches filter).</info>');

        $rootExtra = $this->composer->getPackage()->getExtra();
        $cp = $rootExtra['composer-patches'] ?? [];
        $ignored = (array) ($cp['ignore-dependency-patches'] ?? []);
        $allowed = (array) ($cp['allowed-dependency-patches'] ?? ['vardot/varbase-patches']);
        $patchesIgnore = (array) ($rootExtra['patches-ignore'] ?? []);

        $lockdata = $locker->getLockData();
        foreach ($lockdata['packages'] as $p) {
            $name = $p['name'];

            if (!$this->matchesAny($name, $allowed)) {
                continue;
            }
            if ($this->matchesAny($name, $ignored)) {
                continue;
            }
            if (empty($p['extra']['patches'])) {
                continue;
            }

            $patches = $p['extra']['patches'];
            if (isset($patchesIgnore[$name])) {
                foreach ($patchesIgnore[$name] as $targetPkg => $urls) {
                    if (!isset($patches[$targetPkg])) {
                        continue;
                    }
                    $patches[$targetPkg] = array_filter(
                        $patches[$targetPkg],
                        fn($url) => !in_array($url, (array) $urls, true)
                    );
                    if (empty($patches[$targetPkg])) {
                        unset($patches[$targetPkg]);
                    }
                }
            }

            foreach ($this->findPatchesInJson($patches) as $package => $patchObjs) {
                foreach ($patchObjs as $patch) {
                    /** @var Patch $patch */
                    $patch->extra['provenance'] = "dependency:" . $package;
                    $collection->addPatch($patch);
                }
            }
        }
    }

    private function matchesAny(string $name, array $patterns): bool
    {
        foreach ($patterns as $pattern) {
            if (fnmatch($pattern, $name)) {
                return true;
            }
        }
        return false;
    }
}
