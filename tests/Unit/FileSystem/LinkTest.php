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
use FireHub\Runtime\Exception\CreateLinkException;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Depends, DependsExternal, Group, Small, TestWith
};

/**
 * ### Test PHP Runtime File Link Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(FileSystem\Link::class)]
final class LinkTest extends FileSystemTestCase {

    /**
     * @since 1.0.0
     *
     * @param string $path
     * @param string $link
     *
     * @throws \FireHub\Runtime\Exception\CreateLinkException
     *
     * @return void
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith(['/test.txt', 'hardLink'])]
    public function testHard (string $path, string $link):void {

        self::assertTrue(FileSystem\Link::hard($this->temp_folder.$path, $this->temp_folder.$link));

    }

    /**
     * @since 1.0.0
     *
     * @param string $path
     * @param string $link
     *
     * @return void
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith(['', 'hardLink'])]
    #[TestWith(['/test.txt', ''])]
    public function testHardException (string $path, string $link):void {

        $this->expectException(CreateLinkException::class);

        $this->suppressPhpErrors(
            fn() => self::assertTrue(FileSystem\Link::hard($this->temp_folder.$path, $this->temp_folder.$link))
        );

    }

    /**
     * @since 1.0.0
     *
     * @param string $path
     *
     * @throws \FireHub\Runtime\Exception\DeleteFileException
     *
     * @return void
     */
    #[Depends('testHard')]
    #[TestWith(['hardLink'])]
    public function testUnlink (string $path):void {

        self::assertTrue(FileSystem\File::delete($this->temp_folder.$path));

    }

}