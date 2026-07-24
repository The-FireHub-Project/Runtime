<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=7.4
 * @package Runtime\Tests
 */

namespace FireHub\Tests\Runtime\Unit\FileSystem;

use FireHub\Testing\FileSystemTestCase;
use FireHub\Runtime\FileSystem;
use FireHub\Runtime\Exception\PathResolutionException;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Runtime File System Path Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(FileSystem\Path::class)]
final class PathTest extends FileSystemTestCase {

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param non-empty-string $path
     * @param string $suffix
     *
     * @return void
     */
    #[TestWith(['file.txt', '/var/www/file.txt'])]
    #[TestWith(['file', '/var/www/file.txt', '.txt'])]
    public function testBasename (string $expected, string $path, string $suffix = ''):void {

        self::assertSame($expected, FileSystem\Path::basename($path, $suffix));

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $path
     * @param positive-int $levels
     *
     * @throws \FireHub\Runtime\Exception\InvalidPathParentLevelException
     *
     * @return void
     */
    #[TestWith(['/var/www/html', '/var/www/html/index.php'])]
    #[TestWith(['/var/www', '/var/www/html/index.php', 2])]
    public function testParent (string $expected, string $path, int $levels = 1):void {

        self::assertSame($expected, FileSystem\Path::parent($path, $levels));

    }

    /**
     * @since 1.0.0
     *
     * @param array<string, string|null> $expected
     * @param string $path
     *
     * @return void
     */
    #[TestWith([
        [
            'dirname' => '/var/www',
            'basename' => 'index.php',
            'extension' => 'php',
            'filename' => 'index'
        ],
        '/var/www/index.php'
    ])]
    #[TestWith([
        [
            'dirname' => '.',
            'basename' => 'README',
            'extension' => null,
            'filename' => 'README'
        ],
        'README'
    ])]
    public function testInfo (array $expected, string $path):void {

        self::assertSame($expected, FileSystem\Path::info($path));

    }

    /**
     * @since 1.0.0
     *
     * @throws \FireHub\Runtime\Exception\PathResolutionException
     *
     * @return void
     */
    public function testAbsolute ():void {

        self::assertIsString(FileSystem\Path::absolute($this->temp_folder));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testAbsoluteInvalidPath ():void {

        $this->expectException(PathResolutionException::class);

        self::assertIsString(FileSystem\Path::absolute('x'));

    }

}