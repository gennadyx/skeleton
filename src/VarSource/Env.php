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
 * Class Env
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
class Env extends AbstractSource
{
    /**
     * Template for sprintf
     */
    const TEMPLATE = 'COMPOSER_DEFAULT_%s';

    /**
     * @var array
     */
    private $customEnv;

    /**
     * Env constructor.
     *
     */
    public function __construct()
    {
        $this->customEnv = self::getCustomEnv();
    }

    /**
     * {@inheritdoc}
     */
    protected function find(string $name)
    {
        $value = $this->getEnv(sprintf(self::TEMPLATE, strtoupper($name)));

        if (null === $value && isset($this->customEnv[$name])) {
            $value = $this->getEnv($this->customEnv[$name]);
        }

        return $value;
    }

    /**
     * @param string $env
     *
     * @return string|null
     */
    private function getEnv(string $env)
    {
        $value = getenv($env);

        if ($this->checkString($value)) {
            return $value;
        } elseif ($this->checkArray($value)) {
            return array_shift($value);
        }

        return null;
    }

    /**
     * Check is valid string
     *
     * @param mixed $value
     *
     * @return bool
     */
    private function checkString($value): bool
    {
        return is_string($value) && !empty($value);
    }

    /**
     * Check is valid array
     *
     * @param $value
     *
     * @return bool
     */
    private function checkArray($value): bool
    {
        if (!is_array($value)) {
            return false;
        }

        $first = array_shift($value);

        return $this->checkString($first);
    }

    /**
     * @return array
     */
    private static function getCustomEnv(): array
    {
        return [
            'vendor' => strpos(PHP_OS, 'WIN') === 0 ? 'USERNAME' : 'USER',
        ];
    }
}
