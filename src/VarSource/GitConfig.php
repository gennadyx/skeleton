<?php

declare(strict_types = 1);

/*
 * This file is part of the skeleton package.
 *
 * (c) Gennady Knyazkin <dev@gennadyx.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gennadyx\Skeleton\VarSource;

use Composer\Util\ProcessExecutor;
use Gennadyx\Skeleton\Exception\RuntimeException;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

/**
 * Class GitConfig
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
class GitConfig extends AbstractSource
{
    use PreloadTrait;

    /**
     * Get all variables
     *
     * @return array
     * @throws RuntimeException
     */
    protected function preload(): array
    {
        $conf = $this->getConfig();
        $vars = [];

        foreach ($this->getVarsAssociations() as $sv => $gv) {
            $vars[$sv] = isset($conf[$gv]) ? $conf[$gv] : null;
        }

        return $vars;
    }

    /**
     * @return array
     */
    private function getVarsAssociations(): array
    {
        return [
            'author_name' => 'user.name',
            'author_email' => 'user.email'
        ];
    }

    /**
     * Get git config
     *
     * @return array
     * @throws \Gennadyx\Skeleton\Exception\RuntimeException
     */
    private function getConfig(): array
    {
        $conf = [];

        try {
            $gitBin = $this->findExecutable();
            $cmd    = $this->executeGitConfig($gitBin);

            if ($cmd->isSuccessful()) {
                $conf = $this->parseOutput($cmd->getOutput());
            }
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }

        return $conf;
    }

    /**
     * Get git binary for exec
     *
     * @return string
     */
    private function findExecutable(): string
    {
        $finder = new ExecutableFinder();
        $gitBin = $finder->find('git');

        return ProcessExecutor::escape($gitBin);
    }

    /**
     * Execute git config command
     *
     * @param string $gitBin
     *
     * @return Process
     * @throws \Symfony\Component\Process\Exception\LogicException
     * @throws \Symfony\Component\Process\Exception\RuntimeException
     */
    private function executeGitConfig(string $gitBin): Process
    {
        $cmd = new Process(sprintf('%s config -l', $gitBin));
        $cmd->run();

        return $cmd;
    }

    /**
     * @param string $output
     *
     * @return array
     */
    private function parseOutput(string $output): array
    {
        $config  = [];
        $matches = [];
        preg_match_all('{^([^=]+)=(.*)$}m', $output, $matches, PREG_SET_ORDER);

        if (is_array($matches)) {
            foreach ($matches as $match) {
                $config[$match[1]] = $match[2];
            }
        }

        return $config;
    }
}
