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
use Gennadyx\Skeleton\Action\ActionInterface;
use MF\Collection\Immutable\Generic\Map;

/**
 * Class PackageBuilder
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
class PackageBuilder
{
    /**
     * Execute all actions
     *
     * @param Event $event
     *
     * @return void
     * @throws Exception\RuntimeException
     */
    public static function install(Event $event)
    {
        $packageBuilder = new static();
        $vars           = $packageBuilder->collectVars();
        $callback       = $packageBuilder->getEachCallback($vars, $event);

        /** @var ActionQueue $actions */
        $actions = $packageBuilder->createActionQueue();
        $actions->each($callback);
    }

    /**
     * @param Map   $vars
     * @param Event $event
     *
     * @return \Closure
     */
    protected function getEachCallback(Map $vars, Event $event): \Closure
    {
        return function (ActionInterface $action) use ($vars, $event) {
            if ($action instanceof VarAwareInterface) {
                $action->setVars($vars);
            }

            if ($action instanceof EventAwareInterface) {
                $action->setEvent($event);
            }

            $action->execute();
        };
    }

    /**
     * Create action queue
     *
     * @return ActionQueue|ActionInterface[]
     */
    protected function createActionQueue(): ActionQueue
    {
        return ActionQueue::create();
    }

    /**
     * Collect vars
     *
     * @return Map
     */
    protected function collectVars(): Map
    {
        return VarLoader::collect();
    }
}
