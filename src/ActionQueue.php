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

use Gennadyx\Skeleton\Action\ActionInterface;
use Gennadyx\Skeleton\Action\ComposerInstall;
use Gennadyx\Skeleton\Action\CreateSourceDirectories;
use Gennadyx\Skeleton\Action\InstallFiles;
use Gennadyx\Skeleton\Action\PhpstormProjectConfigure;
use Gennadyx\Skeleton\Action\RemoveSkeletonDirectory;
use Gennadyx\Skeleton\Action\SelfRemoving;
use Gennadyx\Skeleton\Action\VarReplace;
use MF\Collection\Immutable\Generic\ListCollection;

/**
 * Class ActionQueue
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
class ActionQueue extends ListCollection
{
    /**
     * ActionQueue constructor.
     */
    public function __construct()
    {
        parent::__construct(ActionInterface::class);
    }

    /**
     * Create new actions priority queue
     *
     * @return ActionQueue|static
     */
    final public static function create(): ActionQueue
    {
        return static::createGenericListFromArray(
            ActionInterface::class,
            static::sortByPriority(static::getActions())
        );
    }

    /**
     * Get actions list
     *
     * @return array|ActionInterface[]
     */
    protected static function getActions(): array
    {
        return [
            new CreateSourceDirectories(),
            new InstallFiles(),
            new PhpstormProjectConfigure(),
            new ComposerInstall(),
            new RemoveSkeletonDirectory(),
            new SelfRemoving(),
            new VarReplace(),
        ];
    }

    /**
     * Sort actions by priority
     *
     * @param array|ActionInterface[] $actions
     *
     * @return array|ActionInterface[]
     */
    protected static function sortByPriority(array $actions): array
    {
        usort($actions, function (ActionInterface $a, ActionInterface $b) {
            return $a->getPriority() <=> $b->getPriority();
        });

        return array_values($actions);
    }
}
