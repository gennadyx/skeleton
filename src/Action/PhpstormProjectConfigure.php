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
use Gennadyx\Skeleton\Exception\RuntimeException;
use Gennadyx\Skeleton\VarAwareInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

/**
 * Class PhpstormProjectConfigure
 *
 * @author Gennady Knyazkin <dev@gennadyx.tech>
 */
final class PhpstormProjectConfigure implements ActionInterface, VarAwareInterface
{
    use VarAwareTrait,
        FilesystemAwareTrait;

    const IDEA_PATH             = '.idea';
    const COMPOSER_PROJECT_PATH = 'composer';

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        if (!$this->canExecute()) {
            return;
        }

        $this->removeComposerPluginDir();
        $this->markSourceDirectories();
    }

    /**
     * {@inheritdoc}
     */
    public function canExecute(): bool
    {
        return is_dir($this->getIdeaDirectory()) && file_exists($this->getProjectFile());
    }

    /**
     * @return void
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     */
    private function removeComposerPluginDir()
    {
        $directory = $this->vars['root'].'/composer';

        if (is_dir($directory)) {
            $this->fs->remove($directory);
        }
    }

    /**
     * @return void
     * @throws RuntimeException
     */
    private function markSourceDirectories()
    {
        $encoder = new XmlEncoder('module');

        try {
            $data = $encoder->decode(file_get_contents($this->getProjectFile()), 'xml');

            if (isset($data['component']['content']['#'])) {
                unset($data['component']['content']['#']);
            }

            $data['component']['content']['sourceFolder'] = [
                [
                    '@url'           => 'file://$MODULE_DIR$/src',
                    '@isTestSource'  => 'false',
                    '@packagePrefix' => $this->getNamespace(),
                    '#'              => '',
                ],
                [
                    '@url'           => 'file://$MODULE_DIR$/tests',
                    '@isTestSource'  => 'true',
                    '@packagePrefix' => $this->getTestsNamespace(),
                    '#'              => '',
                ],
            ];

            file_put_contents($this->getProjectFile(), $encoder->encode($data, 'xml'));
        } catch (UnexpectedValueException $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return string
     */
    private function getIdeaDirectory(): string
    {
        return $this->vars['root'].'/'.self::IDEA_PATH;
    }

    /**
     * @return string
     */
    private function getProjectFile(): string
    {
        return $this->getIdeaConfigFile($this->vars['name']);
    }

    /**
     * @param string $name Config name
     *
     * @return string
     */
    private function getIdeaConfigFile(string $name): string
    {
        return $this->getIdeaDirectory().'/'.$name.'.iml';
    }

    /**
     * @return string
     */
    private function getNamespace(): string
    {
        return $this->fixNamespaceVariable('namespace');
    }

    /**
     * @param string $variable
     *
     * @return string
     */
    private function fixNamespaceVariable(string $variable): string
    {
        return str_replace('\\\\', '\\', $this->vars[$variable]);
    }

    /**
     * @return string
     */
    private function getTestsNamespace(): string
    {
        return $this->fixNamespaceVariable('tests_namespace');
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority(): int
    {
        return PHP_INT_MAX;
    }
}
