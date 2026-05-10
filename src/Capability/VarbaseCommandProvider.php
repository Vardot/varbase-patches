<?php

namespace Vardot\VarbasePatches\Capability;

use Composer\Plugin\Capability\CommandProvider;
use Vardot\VarbasePatches\Command\CleanupPatchesCommand;
use Vardot\VarbasePatches\Command\CleanupPatchesFileCommand;

class VarbaseCommandProvider implements CommandProvider
{
    public function getCommands(): array
    {
        return [
            new CleanupPatchesCommand(),
            new CleanupPatchesFileCommand(),
        ];
    }
}
