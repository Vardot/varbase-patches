<?php

namespace Vardot\VarbasePatches\Capability;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\Capability;
use cweagans\Composer\Capability\Resolver\ResolverProvider;
use Vardot\VarbasePatches\Resolver\FilteredDependencies;

class VarbaseResolverProvider implements ResolverProvider
{
    private Composer $composer;
    private IOInterface $io;
    private $plugin;

    public function __construct(array $args)
    {
        $this->composer = $args['composer'];
        $this->io = $args['io'];
        $this->plugin = $args['plugin'] ?? null;
    }

    public function getResolvers(): array
    {
        $cweagansPlugin = null;
        foreach ($this->composer->getPluginManager()->getPlugins() as $p) {
            if ($p instanceof \cweagans\Composer\Plugin\Patches) {
                $cweagansPlugin = $p;
                break;
            }
        }
        if ($cweagansPlugin === null) {
            return [];
        }
        return [new FilteredDependencies($this->composer, $this->io, $cweagansPlugin)];
    }
}
