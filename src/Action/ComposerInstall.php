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

namespace Gennadyx\Skeleton\Action;

use Gennadyx\Skeleton\EventAwareInterface;
use Gennadyx\Skeleton\EventAwareTrait;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

/**
 * Class ComposerInstall
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
final class ComposerInstall implements ActionInterface, EventAwareInterface
{
    use EventAwareTrait;

    /**
     * Execute action
     *
     * @return void
     * @throws \Exception
     */
    public function execute()
    {
        $phpBin  = $this->findPhp();
        $command = sprintf('%s %s update', $phpBin, realpath($_SERVER['argv'][0]));
        $this->run($command);
    }

    /**
     * @return string
     * @throws \RuntimeException
     */
    private function findPhp(): string
    {
        $phpBin = (new PhpExecutableFinder())->find();

        if (false === $phpBin) {
            throw new \RuntimeException('Failed to locate PHP binary to execute "composer install"');
        }

        return $phpBin;
    }

    /**
     * @param string $command
     *
     * @throws \Exception
     */
    private function run(string $command)
    {
        $cmd = new Process($command);
        $cmd->run();
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority(): int
    {
        return PHP_INT_MAX - 1;
    }
}
