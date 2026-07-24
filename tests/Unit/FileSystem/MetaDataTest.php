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
use FireHub\Core\Type\FileSystem\PermissionMode;
use FireHub\Core\Meta\Enum\FileSystem\Permission;
use FireHub\Runtime\Exception\ {
    PathGroupException, PathInodeException, PathOwnerException, PathPermissionsException, PathSizeException,
    PathStatisticsException, PathTimestampException
};
use PHPUnit\Framework\Attributes\ {
    CoversClass, DependsExternal, Group, RequiresOperatingSystemFamily, Small, TestWith
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
     * @param string $path
     *
     * @return void
     *@throws \FireHub\Runtime\Exception\PathSizeException
     *
     * @since 1.0.0
     *
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

        $this->expectException(PathSizeException::class);

        $this->suppressPhpErrors(
            fn() => FileSystem\Metadata::size($this->temp_folder.$path)
        );

    }

    /**
     * @param string $path
     *
     * @return void
     *@throws \FireHub\Runtime\Exception\PathTimestampException
     *
     * @since 1.0.0
     *
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith(['/test.txt'])]
    public function testLastAccessed (string $path):void {

        self::assertIsInt(FileSystem\Metadata::lastAccessed($this->temp_folder.$path));

    }

    /**
     * @param string $path
     *
     * @return void
     *@throws \FireHub\Runtime\Exception\PathTimestampException
     *
     * @since 1.0.0
     *
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith(['/test.txt'])]
    public function testLastAModified (string $path):void {

        self::assertIsInt(FileSystem\Metadata::lastModified($this->temp_folder.$path));

    }

    /**
     * @param string $path
     *
     * @return void
     *@throws \FireHub\Runtime\Exception\PathTimestampException
     *
     * @since 1.0.0
     *
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith(['/test.txt'])]
    public function testLastChanged (string $path):void {

        self::assertIsInt(FileSystem\Metadata::lastChanged($this->temp_folder.$path));

    }

    /**
     * @since 1.0.0
     *
     * @param string $path
     *
     * @return void
     */
    #[TestWith(['/test_unknown.txt'])]
    public function testLastAccessedChangedModifiedException (string $path):void {

        $this->expectException(PathTimestampException::class);

        $this->suppressPhpErrors(
            fn() => FileSystem\Metadata::lastAccessed($this->temp_folder.$path)
        );

        $this->suppressPhpErrors(
            fn() => FileSystem\Metadata::lastChanged($this->temp_folder.$path)
        );

        $this->suppressPhpErrors(
            fn() => FileSystem\Metadata::lastModified($this->temp_folder.$path)
        );

    }

    /**
     * @param string $path
     *
     * @return void
     *@throws \FireHub\Runtime\Exception\PathInodeException
     *
     * @since 1.0.0
     *
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith(['/test.txt'])]
    public function testInode (string $path):void {

        self::assertIsInt(FileSystem\Metadata::inode($this->temp_folder.$path));

    }

    /**
     * @since 1.0.0
     *
     * @param string $path
     *
     * @return void
     */
    #[TestWith(['/test_unknown.txt'])]
    public function testInodeException (string $path):void {

        $this->expectException(PathInodeException::class);

        $this->suppressPhpErrors(
            fn() => FileSystem\Metadata::inode($this->temp_folder.$path)
        );

    }

    /**
     * @param bool $expected
     * @param string $path
     * @param null|int $last_accessed
     * @param null|int $last_modified
     *
     * @return void
     *@throws \FireHub\Runtime\Exception\PathTimestampException
     *
     * @since 1.0.0
     *
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith([true, '/test.txt', 3600, 3600])]
    public function testSetTimestamps (bool $expected,  string $path, ?int $last_accessed = null, ?int $last_modified = null):void {

        self::assertSame($expected, FileSystem\Metadata::setTimestamps($this->temp_folder.$path, $last_accessed, $last_modified));

    }

    /**
     * @param string $path
     *
     * @throws \FireHub\Runtime\Exception\PathGroupException
     *
     * @return void
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith(['/test.txt'])]
    public function testGetGroup (string $path):void  {

        $group = FileSystem\Metadata::getGroup($this->temp_folder.$path);

        self::assertGreaterThanOrEqual(0, $group);

    }

    /**
     * @since 1.0.0
     *
     * @param string $path
     *
     * @return void
     */
    #[TestWith(['/test_unknown.txt'])]
    public function testGetGroupException (string $path):void {

        $this->expectException(PathGroupException::class);

        $this->suppressPhpErrors(
            fn() => FileSystem\Metadata::getGroup($this->temp_folder.$path)
        );

    }

    /**
     * @param string $path
     *
     * @throws \FireHub\Runtime\Exception\PathGroupException
     *
     * @return void
     */
    #[RequiresOperatingSystemFamily('Linux')]
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith(['/test.txt'])]
    public function testSetGroupLinux (string $path):void {

        self::assertTrue(
            FileSystem\Metadata::setGroup(
                $this->temp_folder.$path,
                FileSystem\Metadata::getGroup($this->temp_folder.$path)
            )
        );

    }

    /**
     * @param string $path
     *
     * @throws \FireHub\Runtime\Exception\PathGroupException
     *
     * @return void
     */
    #[RequiresOperatingSystemFamily('Darwin')]
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith(['/test.txt'])]
    public function testSetGroupDarwin (string $path):void {

        self::assertTrue(
            FileSystem\Metadata::setGroup(
                $this->temp_folder.$path,
                FileSystem\Metadata::getGroup($this->temp_folder.$path)
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param string $path
     *
     * @return void
     */
    #[TestWith(['/test_unknown.txt'])]
    public function testSetGroupException (string $path):void {

        $this->expectException(PathGroupException::class);

        $this->suppressPhpErrors(
            fn() => FileSystem\Metadata::setGroup($this->temp_folder.$path, 0)
        );

    }

    /**
     * @param string $path
     *
     * @throws \FireHub\Runtime\Exception\PathOwnerException
     *
     * @return void
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith(['/test.txt'])]
    public function testGetOwner (string $path):void  {

        $group = FileSystem\Metadata::getOwner($this->temp_folder.$path);

        self::assertGreaterThanOrEqual(0, $group);

    }

    /**
     * @since 1.0.0
     *
     * @param string $path
     *
     * @return void
     */
    #[TestWith(['/test_unknown.txt'])]
    public function testGetOwnerException (string $path):void {

        $this->expectException(PathOwnerException::class);

        $this->suppressPhpErrors(
            fn() => FileSystem\Metadata::getOwner($this->temp_folder.$path)
        );

    }

    /**
     * @param string $path
     *
     * @throws \FireHub\Runtime\Exception\PathOwnerException
     *
     * @return void
     */
    #[RequiresOperatingSystemFamily('Linux')]
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith(['/test.txt'])]
    public function testSetOwnerLinux (string $path):void {

        self::assertTrue(
            FileSystem\Metadata::setOwner(
                $this->temp_folder.$path,
                FileSystem\Metadata::getOwner($this->temp_folder.$path)
            )
        );

    }

    /**
     * @param string $path
     *
     * @throws \FireHub\Runtime\Exception\PathOwnerException
     *
     * @return void
     */
    #[RequiresOperatingSystemFamily('Darwin')]
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith(['/test.txt'])]
    public function testSetOwnerDarwin (string $path):void {

        self::assertTrue(
            FileSystem\Metadata::setOwner(
                $this->temp_folder.$path,
                FileSystem\Metadata::getOwner($this->temp_folder.$path)
            )
        );

    }

    /**
     * @since 1.0.0
     *
     * @param string $path
     *
     * @return void
     */
    #[TestWith(['/test_unknown.txt'])]
    public function testSetOwnerException (string $path):void {

        $this->expectException(PathOwnerException::class);

        $this->suppressPhpErrors(
            fn() => FileSystem\Metadata::setOwner($this->temp_folder.$path, 0)
        );

    }

    /**
     * @param string $path
     *
     * @throws \FireHub\Runtime\Exception\PathPermissionsException
     * @throws \FireHub\Runtime\Exception\InvalidNumberBaseException
     *
     * @return void
     */
    #[RequiresOperatingSystemFamily('Linux')]
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith(['/test.txt'])]
    public function testPermissionsLinux (string $path):void {

        $expected = new PermissionMode(
            Permission::READ_WRITE,
            Permission::READ,
            Permission::NONE
        );

        FileSystem\Metadata::setPermissions($this->temp_folder.$path, $expected);

        self::assertSame(
            $expected->value(),
            FileSystem\Metadata::getPermissions($this->temp_folder.$path)->value()
        );

    }

    /**
     * @param string $path
     *
     * @throws \FireHub\Runtime\Exception\PathPermissionsException
     * @throws \FireHub\Runtime\Exception\InvalidNumberBaseException
     *
     * @return void
     */
    #[RequiresOperatingSystemFamily('Darwin')]
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith(['/test.txt'])]
    public function testPermissionsDarwin (string $path):void {

        $expected = new PermissionMode(
            Permission::READ_WRITE,
            Permission::READ,
            Permission::NONE
        );

        FileSystem\Metadata::setPermissions($this->temp_folder.$path, $expected);

        self::assertSame(
            $expected->value(),
            FileSystem\Metadata::getPermissions($this->temp_folder.$path)->value()
        );

    }

    /**
     * @since 1.0.0
     *
     * @param string $path
     *
     * @throws \FireHub\Runtime\Exception\InvalidNumberBaseException
     *
     * @return void
     */
    #[TestWith(['/test_unknown.txt'])]
    public function testGetPermissionsException (string $path):void {

        $this->expectException(PathPermissionsException::class);

        $this->suppressPhpErrors(
            fn() => FileSystem\Metadata::getPermissions($this->temp_folder.$path)
        );

    }

    /**
     * @param string $path
     *
     * @throws \FireHub\Runtime\Exception\PathStatisticsException
     *
     * @return void
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith(['/test.txt'])]
    public function testStatistics (string $path):void {

        $statistics = FileSystem\Metadata::statistics($this->temp_folder.$path);

        self::assertIsArray($statistics);

        self::assertArrayHasKey('dev', $statistics);
        self::assertArrayHasKey('ino', $statistics);
        self::assertArrayHasKey('mode', $statistics);
        self::assertArrayHasKey('nlink', $statistics);
        self::assertArrayHasKey('uid', $statistics);
        self::assertArrayHasKey('gid', $statistics);
        self::assertArrayHasKey('rdev', $statistics);
        self::assertArrayHasKey('size', $statistics);
        self::assertArrayHasKey('atime', $statistics);
        self::assertArrayHasKey('mtime', $statistics);
        self::assertArrayHasKey('ctime', $statistics);
        self::assertArrayHasKey('blksize', $statistics);
        self::assertArrayHasKey('blocks', $statistics);

        self::assertSame(
            5,
            $statistics['size']
        );

    }

    /**
     * @since 1.0.0
     *
     * @param string $path
     *
     * @return void
     */
    #[TestWith(['/test_unknown.txt'])]
    public function testStatisticsException (string $path):void {

        $this->expectException(PathStatisticsException::class);

        $this->suppressPhpErrors(
            fn() => FileSystem\Metadata::statistics($this->temp_folder.$path)
        );

    }

    /**
     * @since 1.0.0
     *
     * @param bool $clear_realpath_cache
     * @param string $path
     *
     * @return void
     */
    #[DependsExternal(FileTest::class, 'testPutContent')]
    #[TestWith([false, '/test.txt'])]
    public function testClearCache (bool $clear_realpath_cache = false, string $path = ''):void {

        FileSystem\Metadata::clearCache($clear_realpath_cache, $this->temp_folder.$path);

        self::assertFileExists($this->temp_folder.$path);

    }

}