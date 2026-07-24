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
use FireHub\Runtime\Exception\FileSizeException;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DependsExternal, Group, Small, TestWith
};

/**
 * ### Test PHP Runtime File Metadata Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(FileSystem\Metadata::class)]
final class MetaDataTest extends FileSystemTestCase {

    /**
     * @since 1.0.0
     *
     * @param string $path
     *
     * @throws \FireHub\Runtime\Exception\FileSizeException
     *
     * @return void
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith(['/test.txt'])]
    public function testSize (string $path):void {

        self::assertIsInt(FileSystem\Metadata::size($this->temp_folder.$path));

    }

    /**
     * @since 1.0.0
     *
     * @param string $path
     *
     * @return void
     */
    #[TestWith(['/test_unknown.txt'])]
    public function testSizeException (string $path):void {

        $this->expectException(FileSizeException::class);

        $this->suppressPhpErrors(
            fn() => FileSystem\Metadata::size($this->temp_folder.$path)
        );

    }

}