<?php

namespace Vardot\VarbasePatches\Plugin;

use Composer\Composer;
use Composer\DependencyResolver\Operation\InstallOperation;
use Composer\Installer\PackageEvent;
use Composer\Installer\PackageEvents;
use Composer\IO\IOInterface;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;
use Composer\EventDispatcher\EventSubscriberInterface;
use cweagans\Composer\Event\PluginEvent;
use cweagans\Composer\Event\PluginEvents;
use cweagans\Composer\Plugin\Patches as CweagansPatches;
use cweagans\Composer\Resolver\Dependencies as DefaultDependencies;
use Vardot\VarbasePatches\Capability\VarbaseResolverProvider;
use Vardot\VarbasePatches\Resolver\FilteredDependencies;

class VarbasePatchesPlugin implements PluginInterface, EventSubscriberInterface, Capable
{
    private Composer $composer;
    private IOInterface $io;
    private bool $reresolved = false;

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
        return [
            \cweagans\Composer\Capability\Resolver\ResolverProvider::class => VarbaseResolverProvider::class,
            \Composer\Plugin\Capability\CommandProvider::class => \Vardot\VarbasePatches\Capability\VarbaseCommandProvider::class,
        ];
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PluginEvents::POST_DISCOVER_RESOLVERS => ['filterResolvers', 100],
            PackageEvents::POST_PACKAGE_INSTALL => ['onPostPackageInstall', 9999],
            PackageEvents::PRE_PACKAGE_INSTALL => ['onPrePackageInstall', 9999],
        ];
    }

    public function filterResolvers(PluginEvent $event): void
    {
        $resolvers = $event->getCapabilities();
        $kept = [];
        foreach ($resolvers as $resolver) {
            if ($resolver instanceof DefaultDependencies) {
                continue;
            }
            $kept[] = $resolver;
        }
        $event->setCapabilities($kept);
    }

    public function onPostPackageInstall(PackageEvent $event): void
    {
        $op = $event->getOperation();
        if (!$op instanceof InstallOperation) {
            return;
        }
        if ($op->getPackage()->getName() !== 'vardot/varbase-patches') {
            return;
        }
        $this->reresolveAndRewriteLock();
    }

    public function onPrePackageInstall(PackageEvent $event): void
    {
        if ($this->reresolved) {
            return;
        }
        // Fallback: re-resolve on first PRE_PACKAGE_INSTALL we observe
        // (covers the case where our own package was already installed
        // before this run, e.g. composer install with existing vendor).
        $this->reresolveAndRewriteLock();
    }

    private function reresolveAndRewriteLock(): void
    {
        if ($this->reresolved) {
            return;
        }
        $cweagans = $this->findCweagansPlugin();
        if ($cweagans === null) {
            return;
        }
        $this->reresolved = true;

        $this->io->write('<info>varbase-patches: re-resolving patches with filter (allowed: vardot/varbase-patches).</info>');

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

    private function findCweagansPlugin(): ?CweagansPatches
    {
        foreach ($this->composer->getPluginManager()->getPlugins() as $plugin) {
            if ($plugin instanceof CweagansPatches) {
                return $plugin;
            }
        }
        return null;
    }
}
