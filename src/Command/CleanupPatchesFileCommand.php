<?php

namespace Vardot\VarbasePatches\Command;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Vardot\VarbasePatches\Util\MrPatchProcessor;

/**
 * Same as CleanupPatchesCommand, but operates on the JSON file referenced by
 * extra.patches-file in the root composer.json.
 */
class CleanupPatchesFileCommand extends BaseCommand
{
    protected function configure(): void
    {
        $this
            ->setName('varbase-patches:cleanup:patches-file')
            ->setAliases(['var-ccupf'])
            ->setDescription('Detect MR patches in extra.patches-file, download them locally, and rewrite the patches-file JSON.')
            ->addOption('project-dir', null, InputOption::VALUE_REQUIRED, 'Project root (defaults to current working directory).');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $root = $input->getOption('project-dir') ?: getcwd();
        $composerPath = rtrim($root, '/') . '/composer.json';

        if (!is_file($composerPath)) {
            $output->writeln("<error>composer.json not found at {$composerPath}</error>");
            return 1;
        }

        $composer = json_decode(file_get_contents($composerPath), true);
        if (!is_array($composer)) {
            $output->writeln("<error>Invalid composer.json at {$composerPath}</error>");
            return 1;
        }

        $patchesFile = $composer['extra']['patches-file'] ?? null;
        if (!$patchesFile) {
            $output->writeln('No patches-file in the root composer.json file.');
            return 0;
        }

        $patchesFilePath = rtrim($root, '/') . '/' . $patchesFile;
        if (!is_file($patchesFilePath)) {
            $output->writeln("<error>patches-file not found at {$patchesFilePath}</error>");
            return 1;
        }

        $patchesData = json_decode(file_get_contents($patchesFilePath), true);
        if (!is_array($patchesData) || empty($patchesData['patches'])) {
            $output->writeln("No patches block in {$patchesFile}.");
            return 0;
        }

        $processor = new MrPatchProcessor($root, $output);
        $changed = false;

        foreach ($patchesData['patches'] as $package => &$patches) {
            if (!is_array($patches)) {
                continue;
            }
            foreach ($patches as $title => $url) {
                if (!is_string($url) || !MrPatchProcessor::isMrUrl($url)) {
                    continue;
                }
                $localPath = $processor->process($package, $title, $url);
                if ($localPath !== null) {
                    $patches[$title] = $localPath;
                    $changed = true;
                    $output->writeln('--------------------------------------------');
                }
            }
        }
        unset($patches);

        if (!$changed) {
            $output->writeln("No merge request patches were found in the {$patchesFile} file.");
            return 0;
        }

        file_put_contents(
            $patchesFilePath,
            json_encode($patchesData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n"
        );
        $output->writeln("Completed the composer clean up of merge request patches in the {$patchesFile} file.");
        return 0;
    }
}
