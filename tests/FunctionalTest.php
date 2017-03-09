<?php

/*
 * This file is part of the skeleton package.
 *
 * (c) Gennady Knyazkin <dev@gennadyx.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gennadyx\Skeleton\Tests;

use PHPUnit\Framework\TestCase;
use Gennadyx\Skeleton\Tests\Helper\FunctionalTestTrait;

class FunctionalTest extends TestCase
{
    use FunctionalTestTrait;

    public function testMain()
    {
        $this->executeTest('main');
    }

    public function testPhpstorm()
    {
        $this->executeTest('phpstorm', '/composer', true);
    }
}
