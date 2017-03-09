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

use Gennadyx\Skeleton\VarAwareInterface;
use Gennadyx\Skeleton\VarAwareTrait;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class RemoveSkeletonDirectory
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
final class RemoveSkeletonDirectory implements ActionInterface, VarAwareInterface
{
    use VarAwareTrait;

    /**
     * Execute action
     *
     * @return void
     * @throws \RuntimeException
     */
    public function execute()
    {
        try {
            (new Filesystem())->remove($this->vars['skeleton']);
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
