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
use Symfony\Component\Filesystem\Exception\IOException;

/**
 * Class RemoveSkeletonDirectory
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
final class RemoveSkeletonDirectory implements ActionInterface, VarAwareInterface
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
        try {
            $this->fs->remove($this->vars['skeleton']);
        } catch (IOException $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority(): int
    {
        return 4;
    }
}
