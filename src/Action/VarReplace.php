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

use Gennadyx\Skeleton\Action\Traits\VarAwareTrait;
use Gennadyx\Skeleton\Exception\RuntimeException;
use Gennadyx\Skeleton\VarAwareInterface;
use Symfony\Component\Finder\Finder;

/**
 * Replace variables in all skeleton files
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
final class VarReplace implements ActionInterface, VarAwareInterface
{
    use VarAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        try {
            /** @var Finder $finder */
            $finder = Finder::create()
                ->in($this->vars['skeleton'])
                ->ignoreDotFiles(false);
            $keys   = $this->vars->keys();

            $keys->each(function ($variable) use ($finder) {
                $finder->contains(sprintf(':%s:', $variable));
            });

            $variables = $keys->map(function ($item) {
                return sprintf(':%s:', $item);
            })->toArray();

            foreach ($finder as $file) {
                $newContent = str_replace(
                    $variables,
                    $this->vars->values()->toArray(),
                    $file->getContents()
                );
                file_put_contents($file->getPathname(), $newContent);
            }
        } catch (\Exception $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority(): int
    {
        return 0;
    }
}
