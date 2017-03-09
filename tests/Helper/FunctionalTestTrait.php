<?php

/*
 * This file is part of the skeleton package.
 *
 * (c) Gennady Knyazkin <dev@gennadyx.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gennadyx\Skeleton\Tests\Helper;

use Gennadyx\Skeleton\CommandHandler;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

trait FunctionalTestTrait
{
    use EventMockAwareTrait;

    private static $root;
    
    private static $testDirs;

    /**
     * @var Filesystem
     */
    protected $fs;
    
    public static function root()
    {
        if (null === static::$root) {
            static::$root = realpath('.');
        }
        
        return static::$root;
    }
    
    public static function dirs()
    {
        if (null === static::$testDirs) {
            static::$testDirs = [
                'main_test' => static::root().'/main_test',
                'phpstorm_test' => static::root().'/phpstorm_test',
            ];
        }
        
        return static::$testDirs;
    }

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->createEventMock();
        $this->fs = new Filesystem();
        $this->createTestDirs();
    }

    /**
     * @inheritDoc
     */
    protected function tearDown()
    {
        $this->event = null;
        $this->io = null;
        $this->removeTestDirs();
        $this->fs = null;
    }

    protected function createTestDirs()
    {
        $testDirs = array_values(static::dirs());
        $testDirs[] = static::dirs()['phpstorm_test'].'/composer';

        $this->fs->mkdir($testDirs);

        $finder = new Finder();
        $finder
            ->files()
            ->in(static::root())
            ->ignoreDotFiles(false);
        $phpstormTestDirs = array_slice($testDirs, 1);

        foreach ($finder as $item) {
            if (!$this->isTestDir($item->getRealPath())) {
                $this->copyToTestDir($item, $testDirs[0]);
                $this->copyToPhpstormTestDir($item, ...$phpstormTestDirs);
            }
        }
    }

    protected function isTestDir(string $path): bool
    {
        foreach (static::dirs() as $item) {
            if (strpos($path, $item) === 0) {
                return true;
            }
        }

        return false;
    }

    protected function copyToTestDir(SplFileInfo $fileInfo, string $testDir)
    {
        $this->fs->copy(
            $fileInfo->getRealPath(),
            sprintf('%s/%s/%s', $testDir, $fileInfo->getRelativePath(), $fileInfo->getBasename()))
        ;
    }

    protected function copyToPhpstormTestDir(
        SplFileInfo $fileInfo,
        string $rootDir,
        string $composerDir
    ) {
        $target = $composerDir;

        if ($fileInfo->getRelativePath() === '.idea') {
            $target = $rootDir;
        }

        $this->copyToTestDir($fileInfo, $target);
    }

    protected function removeTestDirs()
    {
        $this->fs->remove(static::dirs());
    }

    protected function executeTest(string $name, string $chdir = '')
    {
        $name .= '_test';
        chdir(static::dirs()[$name].$chdir);
        CommandHandler::handle($this->event);

        $output = $this->io->getOutput();
        static::assertEquals("Build successful!\n", $output, $output);
    }
}
