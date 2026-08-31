<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.1
 * @package Runtime\Tests
 */

namespace FireHub\Tests\Runtime\Unit\FileSystem;

use FireHub\Testing\FileSystemTestCase;
use FireHub\Runtime\FileSystem;
use FireHub\Core\Type\FileSystem\PermissionMode;
use FireHub\Core\Meta\Enum\Order;
use FireHub\Core\Meta\Enum\FileSystem\ {
    PathSearchFlag, Permission
};
use FireHub\Runtime\Exception\ {
    CannotListFolderException, DeleteFolderException
};
use PHPUnit\Framework\Attributes\ {
    CoversClass, Depends, DependsExternal, Group, Small, TestWith
};

/**
 * ### Test PHP Runtime Folder Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(FileSystem\Folder::class)]
final class FolderTest extends FileSystemTestCase {

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param string $path
     *
     * @return void
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith([true, ''])]
    #[TestWith([false, 'unknown'])]
    public function testExists (bool $expected, string $path):void {

        self::assertSame($expected, FileSystem\Folder::exists($this->temp_folder.$path));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param string $path
     *
     * @throws \FireHub\Runtime\Exception\CreateFolderException
     *
     * @return void
     */
    #[TestWith([true, 'test_folder'])]
    public function testCreate (bool $expected, string $path):void {

        $mode = new PermissionMode(
            Permission::NONE,
            Permission::ALL,
            Permission::ALL
        );

        self::assertSame(
            $expected,
            FileSystem\Folder::create($this->temp_folder.$path, $mode)
        );

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param string $path
     *
     * @throws \FireHub\Runtime\Exception\DeleteFolderException
     *
     * @return void
     */
    #[Depends('testCreate')]
    #[TestWith([true, 'test_folder'])]
    public function testDelete (bool $expected, string $path):void {

        self::assertSame(
            $expected,
            FileSystem\Folder::delete($this->temp_folder.$path)
        );

    }

    /**
     * @since 1.0.0
     *
     * @param string $path
     *
     * @return void
     */
    #[TestWith(['unknown_folder'])]
    public function testDeleteException (string $path):void {

        $this->expectException(DeleteFolderException::class);

        $this->suppressPhpErrors(
            fn() => FileSystem\Folder::delete($this->temp_folder.$path)
        );

    }

    /**
     * @since 1.0.0
     *
     * @param \FireHub\Core\Meta\Enum\FileSystem\PathSearchFlag ...$flags
     *
     * @throws \FireHub\Runtime\Exception\MatchInFolderException
     *
     * @return void
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    public function testMatch (PathSearchFlag ...$flags):void {

        self::assertSame(
            [
                $this->temp_folder.'/test.txt'
            ],
            FileSystem\Folder::match($this->temp_folder.'/*', ...$flags)
        );

        self::assertSame(
            [],
            FileSystem\Folder::match($this->temp_folder.'/unknown/*.txt', ...$flags)
        );

    }

    /**
     * @since 1.0.0
     *
     * @param null|\FireHub\Core\Meta\Enum\FileSystem\PathSearchFlag ...$flags
     *
     * @throws \FireHub\Runtime\Exception\CannotListFolderException
     *
     * @return void
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    public function testList (?Order $order = null):void {

        self::assertEqualsCanonicalizing(
            [
                '.',
                '..',
                'test.txt'
            ],
            FileSystem\Folder::list($this->temp_folder, $order)
        );

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    public function testListException ():void {

        $this->expectException(CannotListFolderException::class);

        $this->suppressPhpErrors(
            fn() => FileSystem\Folder::list($this->temp_folder.'/unknown')
        );

    }

}