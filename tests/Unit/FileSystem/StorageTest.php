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
use FireHub\Runtime\Exception\DiskSpaceException;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DependsExternal, Group, Small
};

/**
 * ### Test PHP Runtime File System Storage Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(FileSystem\Storage::class)]
final class StorageTest extends FileSystemTestCase {

    /**
     * @since 1.0.0
     *
     * @throws \FireHub\Runtime\Exception\DiskSpaceException
     *
     * @return void
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    public function testTotalSpace ():void {

        self::assertGreaterThanOrEqual(0, FileSystem\Storage::totalSpace($this->temp_folder));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testTotalSpaceException ():void {

        $this->expectException(DiskSpaceException::class);

        $this->suppressPhpErrors(
            fn() => FileSystem\Storage::totalSpace($this->temp_folder.'-')
        );

    }

    /**
     * @since 1.0.0
     *
     * @throws \FireHub\Runtime\Exception\DiskSpaceException
     *
     * @return void
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    public function testFreeSpace ():void {

        self::assertGreaterThanOrEqual(0, FileSystem\Storage::freeSpace($this->temp_folder));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testTotalFreeException ():void {

        $this->expectException(DiskSpaceException::class);

        $this->suppressPhpErrors(
            fn() => FileSystem\Storage::freeSpace($this->temp_folder.'-')
        );

    }

}