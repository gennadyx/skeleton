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
 * Trait PreloadTrait
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
trait PreloadTrait
{
    protected $preloadVars;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->preloadVars = $this->filter($this->preload());
    }

    /**
     * {@inheritdoc}
     */
    final protected function find(string $name)
    {
        if (isset($this->preloadVars[$name])) {
            return $this->preloadVars[$name];
        }

        return null;
    }

    /**
     * @param array $vars
     *
     * @return array
     */
    final protected function filter(array $vars): array
    {
        return array_filter($vars, function ($var) {
            return is_string($var) && !empty($var);
        });
    }

    /**
     * Get all variables
     *
     * @return array
     */
    abstract protected function preload(): array;
}
