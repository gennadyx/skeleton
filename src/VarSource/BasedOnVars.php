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

use Stringy\StaticStringy;

/**
 * Class BasedOnVars
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
class BasedOnVars extends AbstractSource
{
    /**
     * @inheritDoc
     */
    protected function find(string $name)
    {
        $vars = $this->getVars();

        if (isset($vars[$name]) && !empty($vars[$name])) {
            return $vars[$name];
        }

        return null;
    }

    /**
     * @return array
     */
    protected function getVars(): array
    {
        $defined = static::vars();

        if (!isset($defined['name'], $defined['vendor'])) {
            return [];
        }

        $vars    = [
            'description'     => sprintf('%s composer package', $defined['name']),
            'author_homepage' => sprintf('https://github.com/%s', $defined['vendor']),
            'namespace'       => sprintf(
                '%s\\\%s',
                ...array_map([StaticStringy::class, 'upperCamelize'], [$defined['vendor'], $defined['name']])
            )
        ];
        $vars['homepage']        = sprintf('https://github.com/%s/%s', $defined['vendor'], $defined['name']);
        $vars['tests_namespace'] = sprintf('%s\\\Tests', $vars['namespace']);

        return $vars;
    }
}
