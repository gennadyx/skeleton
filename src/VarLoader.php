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

namespace Gennadyx\Skeleton;

use Gennadyx\Skeleton\VarSource\BasedOnVars;
use Gennadyx\Skeleton\VarSource\Env;
use Gennadyx\Skeleton\VarSource\Filesystem;
use Gennadyx\Skeleton\VarSource\GitConfig;
use MF\Collection\Immutable\Generic\Map;
use MF\Validator\TypeValidator;

/**
 * Class VarLoader
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
class VarLoader
{
    /**
     * Required variables
     */
    const REQUIRED_VARIABLES = [
        'root',
        'skeleton',
        'vendor',
        'name',
        'description',
        'homepage',
        'author_name',
        'author_email',
        'author_homepage',
        'namespace',
        'tests_namespace',
    ];

    /**
     * @return Map
     */
    public static function collect(): Map
    {
        $source = new Env();
        $source
            ->setNext(new Filesystem())
            ->setNext(new GitConfig())
            ->setNext(new BasedOnVars());

        return Map::createGenericFromArray(
            TypeValidator::TYPE_STRING,
            TypeValidator::TYPE_STRING,
            $source->collect(self::REQUIRED_VARIABLES)
        );
    }
}
