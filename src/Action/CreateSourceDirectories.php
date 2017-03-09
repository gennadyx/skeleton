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

use Gennadyx\Skeleton\Action\Traits\FilesystemAwareTrait;
use Gennadyx\Skeleton\Action\Traits\VarAwareTrait;
use Gennadyx\Skeleton\VarAwareInterface;

/**
 * Class CreateSourceDirectories
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
final class CreateSourceDirectories implements ActionInterface, VarAwareInterface
{
    use VarAwareTrait,
        FilesystemAwareTrait;

    /**
     * Execute action
     *
     * @return void
     * @throws \RuntimeException
     */
    public function execute()
    {
        foreach (['src', 'tests'] as $name) {
            $directory = $this->vars['root'].'/'.$name;

            if (!is_dir($directory)) {
                $this->fs->mkdir($directory);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority(): int
    {
        return 5;
    }
}
