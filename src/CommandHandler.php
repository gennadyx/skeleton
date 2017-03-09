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
 * Handler for 'post-create-project-cmd' script
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
class CommandHandler
{
    /**
     * Handle command
     *
     * @param Event $event
     */
    public static function handle(Event $event)
    {
        try {
            PackageBuilder::install($event);
            $event->getIO()->write('Build successful!');
        } catch (\Exception $e) {
            $event->getIO()->writeError($e->getMessage());
            $event->stopPropagation();
        }
    }
}
