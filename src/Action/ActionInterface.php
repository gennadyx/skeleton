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

use Gennadyx\Skeleton\Exception\RuntimeException;

/**
 * Interface ActionInterface
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
interface ActionInterface
{
    /**
     * Execute action
     *
     * @return void
     * @throws RuntimeException
     */
    public function execute();

    /**
     * Get action priority
     *
     * @return int
     */
    public function getPriority(): int;
}
