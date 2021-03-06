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

namespace Gennadyx\Skeleton\Action;

use Gennadyx\Skeleton\Action\Traits\FilesystemAwareTrait;
use Gennadyx\Skeleton\Action\Traits\VarAwareTrait;
use Gennadyx\Skeleton\VarAwareInterface;
use Stringy\StaticStringy;
use Symfony\Component\Finder\Finder;

/**
 * Class InstallFiles
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
final class InstallFiles implements ActionInterface, VarAwareInterface
{
    use VarAwareTrait,
        FilesystemAwareTrait;

    public function execute()
    {
        try {
            /** @var Finder $finder */
            $finder     = Finder::create()
                ->files()
                ->in($this->vars['skeleton'])
                ->ignoreDotFiles(false);

            foreach ($finder as $file) {
                $target = str_replace(
                    $this->vars['skeleton'],
                    $this->vars['root'],
                    $file->getRealPath()
                );
                $this->fs->rename(
                    $file->getRealPath(),
                    (string)StaticStringy::removeRight($target, '.skltn'),
                    true
                );
            }
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority(): int
    {
        return 3;
    }
}
