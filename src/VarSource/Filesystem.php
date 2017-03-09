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

/**
 * Class Filesystem
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
class Filesystem extends AbstractSource
{
    use PreloadTrait;

    /**
     * {@inheritdoc}
     */
    protected function preload(): array
    {
        $root = $this->getRoot();
        $skeleton = $this->getSkeleton($root);

        return [
            'root'     => $root,
            'skeleton' => $skeleton,
            'name'     => basename($root),
        ];
    }

    /**
     * @return string
     */
    protected function getRoot(): string
    {
        $root = realpath('.');

        if ('composer' === basename($root)) {
            $root = realpath('..');
        }

        return $root;
    }

    /**
     * @param string $root
     *
     * @return string
     */
    protected function getSkeleton(string $root): string
    {
        $path = '/skeleton';

        if (is_dir($root.'/composer')) {
            $path = '/composer'.$path;
        }

        return $root.$path;
    }
}
