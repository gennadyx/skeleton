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
        $root = realpath('.');
        $skeleton = sprintf('%s/skeleton', $root);
        $name = basename($root);

        if ('composer' === $name) {
            $name = basename(realpath('..'));
        }

        return [
            'root'     => $root,
            'skeleton' => $skeleton,
            'name'     => $name,
        ];
    }
}
