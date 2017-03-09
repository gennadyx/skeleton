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

namespace Gennadyx\Skeleton\Action\Traits;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Class FilesystemAwareTrait
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
trait FilesystemAwareTrait
{
    /**
     * @var Filesystem
     */
    protected $fs;

    public function __construct()
    {
        $this->fs = new Filesystem();
    }
}
