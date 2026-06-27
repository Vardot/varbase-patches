<?php

namespace Vardot\VarbasePatches\Plugin;

use Composer\Composer;
use Composer\DependencyResolver\Operation\InstallOperation;
use Composer\DependencyResolver\Operation\UpdateOperation;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Installer\PackageEvent;
use Composer\Installer\PackageEvents;
use Composer\IO\IOInterface;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event as ScriptEvent;
use Composer\Script\ScriptEvents;

/**
 * Adds wildcard ignore-dependency-patches, an allowed-dependency-patches
 * allowlist, and v1-style patches-ignore on top of cweagans/composer-patches.
 *
 * Supports cweagans/composer-patches "~1.7.0 || ~2.0":
 *
 *  - v2: replaces the default Dependencies resolver with FilteredDependencies
 *        (via Capability + POST_DISCOVER_RESOLVERS) and force-rewrites
 *        patches.lock.json once our own package is installed.
 *  - v1: mutates each package's extra.patches in place at PRE_INSTALL_CMD,
 *        PRE_UPDATE_CMD, PRE_PACKAGE_INSTALL and PRE_PACKAGE_UPDATE at higher
 *        priority than cweagans v1, so v1's gatherPatches() sees the filtered
 *        set. v1's native patches-ignore is left to v1 itself.
 *
 * Always registers the cleanup-patches Composer commands via
 * VarbaseCommandProvider regardless of cweagans version.
 */
class VarbasePatchesPlugin implements PluginInterface, EventSubscriberInterface, Capable
{
    /**
     * Packages whose extra.patches are applied by default (no config needed).
     */
    public const DEFAULT_ALLOWED_DEPENDENCY_PATCHES = ['vardot/varbase-patches', 'vardot/drupal-core-patches'];

    private Composer $composer;
    private IOInterface $io;
    private bool $reresolved = false;
    private bool $v1Mutated = false;
    private ?int $cweagansVersion = null;

    public function activate(Composer $composer, IOInterface $io): void
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    public function deactivate(Composer $composer, IOInterface $io): void
    {
    }

    public function uninstall(Composer $composer, IOInterface $io): void
    {
    }

    public function getCapabilities(): array
    {
        $caps = [
            \Composer\Plugin\Capability\CommandProvider::class
                => \Vardot\VarbasePatches\Capability\VarbaseCommandProvider::class,
        ];
        if ($this->detectVersion() === 2) {
            $caps[\cweagans\Composer\Capability\Resolver\ResolverProvider::class]
                = \Vardot\VarbasePatches\Capability\VarbaseResolverProvider::class;
        }
        return $caps;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ScriptEvents::PRE_INSTALL_CMD => [['onPreCmdV1', 9999]],
            ScriptEvents::PRE_UPDATE_CMD => [['onPreCmdV1', 9999]],
            ScriptEvents::POST_INSTALL_CMD => [['onPreCmd', 9999]],
            ScriptEvents::POST_UPDATE_CMD => [['onPreCmd', 9999]],
            PackageEvents::PRE_PACKAGE_INSTALL => [['onPrePackage', 9999]],
            PackageEvents::PRE_PACKAGE_UPDATE => [['onPrePackage', 9999]],
            PackageEvents::POST_PACKAGE_INSTALL => [['onPostPackage', 9999]],
            'post-discover-resolvers' => [['filterResolversV2', 100]],
        ];
    }

    private function detectVersion(): int
    {
        if ($this->cweagansVersion !== null) {
            return $this->cweagansVersion;
        }
        if (class_exists(\cweagans\Composer\Plugin\Patches::class)) {
            return $this->cweagansVersion = 2;
        }
        if (class_exists(\cweagans\Composer\Patches::class)) {
            return $this->cweagansVersion = 1;
        }
        return $this->cweagansVersion = 0;
    }

    public function filterResolversV2($event): void
    {
        if ($this->detectVersion() !== 2) {
            return;
        }
        $resolvers = $event->getCapabilities();
        $kept = [];
        foreach ($resolvers as $resolver) {
            if ($resolver instanceof \cweagans\Composer\Resolver\Dependencies) {
                continue;
            }
            $kept[] = $resolver;
        }
        $event->setCapabilities($kept);
    }

    public function onPreCmdV1(ScriptEvent $event): void
    {
        if ($this->detectVersion() === 1) {
            $this->rewriteV1Patches();
        }
    }

    /**
     * Rewrite cweagans v1's $this->patches map from the lock file, applying
     * allowed/ignore wildcards + patches-ignore. Idempotent across calls.
     */
    private function rewriteV1Patches(): void
    {
        if ($this->detectVersion() !== 1) {
            return;
        }
        $cw = $this->findCweagansV1Plugin();
        if ($cw === null) {
            return;
        }

        $newPatches = $this->buildV1PatchesMap();
        $newPatches['_patchesGathered'] = true;

        $rc = new \ReflectionClass($cw);
        if (!$rc->hasProperty('patches')) {
            return;
        }
        $prop = $rc->getProperty('patches');
        $prop->setAccessible(true);
        $prop->setValue($cw, $newPatches);

        if (!$this->v1Mutated) {
            $this->v1Mutated = true;
            $this->io->write('<info>varbase-patches: re-gathered patches via v1 (allowed dependency patches).</info>');
        }
    }

    private function buildV1PatchesMap(): array
    {
        $patches = [];
        $rootExtra = $this->composer->getPackage()->getExtra();

        if (!empty($rootExtra['patches']) && is_array($rootExtra['patches'])) {
            $patches = $this->mergePatchesRecursive($patches, $rootExtra['patches']);
        }

        if (!empty($rootExtra['patches-file'])) {
            $patchesFile = $rootExtra['patches-file'];
            if ($patchesFile[0] !== '/') {
                $patchesFile = getcwd() . '/' . $patchesFile;
            }
            if (is_file($patchesFile)) {
                $data = json_decode((string) file_get_contents($patchesFile), true);
                if (is_array($data) && !empty($data['patches'])) {
                    $patches = $this->mergePatchesRecursive($patches, $data['patches']);
                }
            }
        }

        $cp = $rootExtra['composer-patches'] ?? [];
        $allowed = (array) ($cp['allowed-dependency-patches'] ?? self::DEFAULT_ALLOWED_DEPENDENCY_PATCHES);
        $ignored = (array) ($cp['ignore-dependency-patches'] ?? []);
        $patchesIgnore = (array) ($rootExtra['patches-ignore'] ?? []);

        $locker = $this->composer->getLocker();
        if (!$locker->isLocked()) {
            return $patches;
        }
        $lockData = $locker->getLockData();
        $lockedPackages = $lockData['packages'] ?? [];

        foreach ($lockedPackages as $p) {
            $name = $p['name'] ?? null;
            if ($name === null || empty($p['extra']['patches'])) {
                continue;
            }
            if (!$this->matchesAny($name, $allowed)) {
                continue;
            }
            if ($this->matchesAny($name, $ignored)) {
                continue;
            }
            $depPatches = $p['extra']['patches'];
            if (isset($patchesIgnore[$name])) {
                foreach ($patchesIgnore[$name] as $targetPkg => $urls) {
                    if (!isset($depPatches[$targetPkg])) {
                        continue;
                    }
                    $urlList = is_array($urls) ? array_values($urls) : [(string) $urls];
                    $depPatches[$targetPkg] = array_filter(
                        $depPatches[$targetPkg],
                        fn($u) => !in_array($u, $urlList, true)
                    );
                    if (empty($depPatches[$targetPkg])) {
                        unset($depPatches[$targetPkg]);
                    }
                }
            }
            $patches = $this->mergePatchesRecursive($patches, $depPatches);
        }
        return $patches;
    }

    private function matchesAny(string $name, array $patterns): bool
    {
        foreach ($patterns as $pattern) {
            if (fnmatch((string) $pattern, $name)) {
                return true;
            }
        }
        return false;
    }

    private function mergePatchesRecursive(array $a, array $b): array
    {
        foreach ($b as $package => $patches) {
            if (!isset($a[$package])) {
                $a[$package] = $patches;
            } elseif (is_array($patches) && is_array($a[$package])) {
                $a[$package] = array_merge($a[$package], $patches);
            }
        }
        return $a;
    }

    private function findCweagansV1Plugin()
    {
        foreach ($this->composer->getPluginManager()->getPlugins() as $plugin) {
            if (class_exists(\cweagans\Composer\Patches::class)
                && $plugin instanceof \cweagans\Composer\Patches) {
                return $plugin;
            }
        }
        return null;
    }

    public function onPrePackage(PackageEvent $event): void
    {
        $version = $this->detectVersion();
        $op = $event->getOperation();
        $pkg = null;
        if ($op instanceof InstallOperation) {
            $pkg = $op->getPackage();
        } elseif ($op instanceof UpdateOperation) {
            $pkg = $op->getTargetPackage();
        }

        if ($version === 1) {
            $this->rewriteV1Patches();
            return;
        }

        if ($version === 2 && !$this->reresolved) {
            $this->reresolveAndRewriteLockV2();
        }
    }

    public function onPostPackage(PackageEvent $event): void
    {
        $version = $this->detectVersion();
        $op = $event->getOperation();
        if (!$op instanceof InstallOperation) {
            if ($version === 1) {
                $this->rewriteV1Patches();
            }
            return;
        }
        if ($op->getPackage()->getName() === 'vardot/varbase-patches') {
            if ($version === 2) {
                $this->reresolveAndRewriteLockV2();
            } elseif ($version === 1) {
                $this->rewriteV1Patches();
            }
            return;
        }
        if ($version === 1) {
            $this->rewriteV1Patches();
        }
    }

    public function onPreCmd(ScriptEvent $event): void
    {
        if ($this->detectVersion() === 1) {
            $this->rewriteV1Patches();
        }
    }

    private function reresolveAndRewriteLockV2(): void
    {
        if ($this->reresolved) {
            return;
        }
        if ($this->detectVersion() !== 2) {
            return;
        }
        $cweagans = $this->findCweagansV2Plugin();
        if ($cweagans === null) {
            return;
        }
        $this->reresolved = true;

        $this->io->write('<info>varbase-patches: re-resolving patches with filter (allowed dependency patches).</info>');
        $newCollection = $cweagans->resolvePatches();

        $r = new \ReflectionClass($cweagans);
        $lockerProp = $r->getProperty('locker');
        $lockerProp->setAccessible(true);
        $locker = $lockerProp->getValue($cweagans);
        $locker->setLockData($newCollection, true);

        if ($r->hasProperty('patchCollection')) {
            $pcProp = $r->getProperty('patchCollection');
            $pcProp->setAccessible(true);
            $pcProp->setValue($cweagans, $newCollection);
        }
    }

    private function findCweagansV2Plugin()
    {
        foreach ($this->composer->getPluginManager()->getPlugins() as $plugin) {
            if ($plugin instanceof \cweagans\Composer\Plugin\Patches) {
                return $plugin;
            }
        }
        return null;
    }
}
