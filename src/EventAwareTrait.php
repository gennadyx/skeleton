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

use Composer\Script\Event;

/**
 * Trait EventAwareTrait
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
trait EventAwareTrait
{
    /**
     * @var Event
     */
    protected $event;

    /**
     * Set event
     *
     * @param Event $event
     */
    public function setEvent(Event $event)
    {
        $this->event = $event;
    }
}
