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

namespace Gennadyx\Skeleton\Tests\Helper;

use Composer\IO\BufferIO;
use Composer\Script\Event;

/**
 * @method \Prophecy\Prophecy\ObjectProphecy prophesize(string $class)
 */
trait EventMockAwareTrait
{
    /**
     * @var Event
     */
    private $event;

    /**
     * @var BufferIO
     */
    private $io;

    protected function createEventMock()
    {
        $event = $this->prophesize(Event::class);
        /** @noinspection PhpUndefinedMethodInspection */
        $event->getIO()
            ->willReturn($this->getIo());
        $this->event = $event->reveal();
    }

    protected function getEvent()
    {
        if (null === $this->event) {
            $this->createEventMock();
        }

        return $this->event;
    }

    protected function getIo()
    {
        if (null === $this->io) {
            $this->io = new BufferIO();
        }

        return $this->io;
    }
}
