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

use MF\Collection\Immutable\Generic\Map;

/**
 * Class VarAwareTrait
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
trait VarAwareTrait
{
    /**
     * @var Map
     */
    protected $vars;

    /**
     * Set variable map
     *
     * @param Map $vars
     */
    public function setVars(Map $vars)
    {
        $this->vars = $vars;
    }
}
