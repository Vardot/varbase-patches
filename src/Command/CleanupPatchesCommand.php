<?php

namespace Vardot\VarbasePatches\Command;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Vardot\VarbasePatches\Util\MrPatchProcessor;

/**
 * Detects merge request patches under extra.patches in the root composer.json,
 * downloads them to ./patches/ with a timestamped filename, and rewrites the
 * URL entries to local paths.
 */
class CleanupPatchesCommand extends BaseCommand
{
    protected function configure(): void
    {
        $this
            ->setName('varbase-patches:cleanup:patches')
            ->setAliases(['var-ccup'])
            ->setDescription('Detect MR patches in extra.patches, download them locally, and rewrite composer.json entries.')
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

        if (empty($composer['extra']['patches']) || !is_array($composer['extra']['patches'])) {
            $output->writeln('No extra.patches block in composer.json.');
            return 0;
        }

        $processor = new MrPatchProcessor($root, $output);
        $changed = false;

        foreach ($composer['extra']['patches'] as $package => &$patches) {
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
            $output->writeln('No merge request patches were found in the root composer.json file.');
            return 0;
        }

        file_put_contents(
            $composerPath,
            json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n"
        );
        $output->writeln('Completed the composer clean up of merge request patches in the root composer.json file.');
        return 0;
    }
}
