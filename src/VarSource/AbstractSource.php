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
 * Class AbstractSource
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
abstract class AbstractSource
{
    /**
     * @var AbstractSource
     */
    protected $next;

    /**
     * @var array
     */
    private static $vars = [];

    /**
     * Set next source
     *
     * @param AbstractSource $source
     *
     * @return AbstractSource
     */
    public function setNext(AbstractSource $source): AbstractSource
    {
        $this->next = $source;

        return $source;
    }

    /**
     * Find and collect variables from sources
     *
     * @param array $requiredVars
     *
     * @return array
     */
    final public function collect(array $requiredVars = []): array
    {
        foreach ($requiredVars as $requiredVar) {
            self::$vars[$requiredVar] = $this->get($requiredVar);
        }

        return self::$vars;
    }

    /**
     * Get variable value by name
     *
     * @param string $name
     *
     * @return string
     */
    final protected function get(string $name): string
    {
        $value = $this->find($name);

        if (null === $value) {
            $value = null !== $this->next ? $this->next->get($name) : '';
        }

        return $value;
    }

    /**
     * Find value for variable by name
     *
     * @param string $name
     *
     * @return string|null
     */
    abstract protected function find(string $name);

    /**
     * @return array
     */
    final protected static function vars(): array
    {
        return self::$vars;
    }
}
