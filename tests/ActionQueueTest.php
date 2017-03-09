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

namespace Gennadyx\Skeleton\Tests;

use Gennadyx\Skeleton\Action\ActionInterface;
use Gennadyx\Skeleton\ActionQueue;
use Gennadyx\Skeleton\EventAwareInterface;
use Gennadyx\Skeleton\Tests\Helper\EventMockAwareTrait;
use Gennadyx\Skeleton\Action\ComposerInstall;
use Gennadyx\Skeleton\Action\CreateSourceDirectories;
use Gennadyx\Skeleton\Action\InstallFiles;
use Gennadyx\Skeleton\Action\PhpstormProjectConfigure;
use Gennadyx\Skeleton\Action\RemoveSkeletonDirectory;
use Gennadyx\Skeleton\Action\SelfRemoving;
use Gennadyx\Skeleton\Action\VarReplace;
use Gennadyx\Skeleton\VarAwareInterface;
use MF\Collection\Immutable\Generic\Map;
use MF\Validator\TypeValidator;
use PHPUnit\Framework\TestCase;

class ActionQueueTest extends TestCase
{
    use EventMockAwareTrait;

    const EXPECTED_QUEUE = [
        0 => VarReplace::class,
        1 => SelfRemoving::class,
        2 => InstallFiles::class,
        3 => RemoveSkeletonDirectory::class,
        4 => CreateSourceDirectories::class,
        5 => ComposerInstall::class,
        6 => PhpstormProjectConfigure::class,
    ];

    /**
     * @var ActionQueue
     */
    protected $queue;

    protected $rMethods;

    public function testSortByPriority()
    {
        $actions = $this->getMockActionList();
        $count   = count($actions);
        $actions = $this->rMethods['sortByPriority']($actions);

        static::assertTrue(is_array($actions));
        static::assertCount($count, $actions);
        static::assertContainsOnly(ActionInterface::class, $actions);

        foreach ($actions as $i => $action) {
            static::assertInstanceOf(self::EXPECTED_QUEUE[$i], $action);
        }
    }

    public function testCreate()
    {
        static::assertInstanceOf(ActionQueue::class, $this->rMethods['create']());
    }

    public function testGetActions()
    {
        $actions = $this->rMethods['getActions']();

        static::assertTrue(is_array($actions));
        static::assertContainsOnly(ActionInterface::class, $actions);

        /** @var ActionInterface $action */
        foreach ($actions as $action) {
            if ($action instanceof EventAwareInterface) {
                $action->setEvent($this->getEvent());
            }

            if ($action instanceof VarAwareInterface) {
                $action->setVars(new Map(TypeValidator::TYPE_INT, TypeValidator::TYPE_INT));
            }
        }
    }

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $rClass      = new \ReflectionClass(ActionQueue::class);
        $this->queue = $rClass->newInstance();
        $methods     = [];

        foreach ($rClass->getMethods() as $method) {
            $method->setAccessible(true);
            $methods[$method->getName()] = $method->getClosure($this->queue);
        }

        $this->rMethods = $methods;
    }

    /**
     * @inheritDoc
     */
    protected function tearDown()
    {
        $this->queue    = null;
        $this->rMethods = null;
    }

    /**
     * @return array|AbstractAction
     */
    protected function getMockActionList(): array
    {
        return ActionQueue::create()->toArray();
    }
}
