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
use PHPUnit\Framework\Attributes\ {
    CoversClass, DependsExternal, Group, Small, TestWith
};

/**
 * ### Test PHP Runtime File System Permission Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(FileSystem\Permission::class)]
final class PermissionTest extends FileSystemTestCase {

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param string $path
     *
     * @return void
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith([false, '/test.txt'])]
    #[TestWith([false, '/test_unknown.txt'])]
    public function testSize (bool $expected, string $path):void {

        self::assertSame($expected, FileSystem\Permission::isExecutable($this->temp_folder.$path));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param string $path
     *
     * @return void
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith([true, '/test.txt'])]
    #[TestWith([false, '/test_unknown.txt'])]
    public function testIsReadable (bool $expected, string $path):void {

        self::assertSame($expected, FileSystem\Permission::isReadable($this->temp_folder.$path));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param string $path
     *
     * @return void
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith([true, '/test.txt'])]
    #[TestWith([false, '/test_unknown.txt'])]
    public function testIsWritable (bool $expected, string $path):void {

        self::assertSame($expected, FileSystem\Permission::isWritable($this->temp_folder.$path));

    }

}