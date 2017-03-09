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
use Gennadyx\Skeleton\Exception\RuntimeException;
use Gennadyx\Skeleton\VarAwareInterface;
use Gennadyx\Skeleton\VarAwareTrait;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Class SelfRemoving
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
final class SelfRemoving implements ActionInterface, VarAwareInterface
{
    use VarAwareTrait,
        FilesystemAwareTrait;

    /**
     * Function execute
     *
     * @throws RuntimeException
     */
    public function execute()
    {
        $root = $this->vars['root'];

        try {
            $finder     = Finder::create()
                ->files()
                ->in($root)
                ->exclude(basename($this->vars['skeleton']))
                ->depth(0)
                ->ignoreDotFiles(false);
            $this->fs->remove($finder);
            $this->fs->remove([$root.'/src', $root.'/tests']);
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority(): int
    {
        return 2;
    }
}
