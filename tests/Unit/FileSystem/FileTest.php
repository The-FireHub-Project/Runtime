<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.2
 * @package Runtime\Tests
 */

namespace FireHub\Tests\Runtime\Unit\FileSystem;

use FireHub\Testing\FileSystemTestCase;
use FireHub\Runtime\FileSystem;
use FireHub\Runtime\Exception\ {
    CopyFileException, DeleteFileException, EmptyPathException, ReadFileException, RenameFileException,
    UploadedFileMoveException
};
use PHPUnit\Framework\Attributes\ {
    CoversClass, Depends, Group, Small, TestWith
};

/**
 * ### Test PHP Runtime File Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(FileSystem\File::class)]
final class FileTest extends FileSystemTestCase {

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param string $path
     *
     * @return void
     */
    #[Depends('testPutContent')]
    #[TestWith([true, '/test.txt'])]
    #[TestWith([false, '/test_unknown.txt'])]
    public function testExist (bool $expected, string $path):void {

        self::assertSame($expected, FileSystem\File::exist($this->temp_folder.$path));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param string $path
     *
     * @return void
     */
    #[Depends('testPutContent')]
    #[TestWith([true, '/test.txt'])]
    #[TestWith([false, '/test_unknown.txt'])]
    public function testIsFile (bool $expected, string $path):void {

        self::assertSame($expected, FileSystem\File::isFile($this->temp_folder.$path));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param string $path
     *
     * @return void
     */
    #[Depends('testPutContent')]
    #[TestWith([false, '/test.txt'])]
    #[TestWith([false, '/test_unknown.txt'])]
    public function testIsUploaded (bool $expected, string $path):void {

        self::assertSame($expected, FileSystem\File::isUploaded($this->temp_folder.$path));

    }

    /**
     * @since 1.0.0
     *
     * @param string $path
     * @param string $to
     *
     * @throws \FireHub\Runtime\Exception\CopyFileException
     *
     * @return void
     */
    #[Depends('testPutContent')]
    #[TestWith(['/test.txt', '/test2.txt'])]
    public function testCopy (string $path, string $to):void {

        self::assertTrue(FileSystem\File::copy($this->temp_folder.$path, $this->temp_folder.$to));

    }

    /**
     * @since 1.0.0
     *
     * @param string $path
     * @param string $to
     *
     * @return void
     */
    #[TestWith(['/test_x.txt', '/test_y.txt'])]
    public function testCopyFailed (string $path, string $to):void {

        $this->expectException(CopyFileException::class);

        $this->suppressPhpErrors(
            fn() => FileSystem\File::copy($this->temp_folder.$path, $this->temp_folder.$to)
        );

    }

    /**
     * @since 1.0.0
     *
     * @param string $path
     * @param string $to
     *
     * @throws \FireHub\Runtime\Exception\RenameFileException
     *
     * @return void
     */
    #[Depends('testCopy')]
    #[TestWith(['/test2.txt', '/test3.txt'])]
    public function testRename (string $path, string $to):void {

        self::assertTrue(FileSystem\File::rename($this->temp_folder.$path, $this->temp_folder.$to));

    }

    /**
     * @since 1.0.0
     *
     * @param string $path
     * @param string $to
     *
     * @return void
     */
    #[TestWith(['/test_x.txt', '/test_y.txt'])]
    public function testRenameFailed (string $path, string $to):void {

        $this->expectException(RenameFileException::class);

        $this->suppressPhpErrors(
            fn() => self::assertTrue(FileSystem\File::rename($this->temp_folder.$path, $this->temp_folder.$to))
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
    #[Depends('testRename')]
    #[TestWith(['/test3.txt'])]
    public function testDelete (string $path):void {

        self::assertTrue(FileSystem\File::delete($this->temp_folder.$path));

    }

    /**
     * @since 1.0.0
     *
     * @param string $path
     *
     * @return void
     */
    #[TestWith(['/test_x.txt'])]
    public function testDeleteFailed (string $path):void {

        $this->expectException(DeleteFileException::class);

        $this->suppressPhpErrors(
            fn() => self::assertTrue(FileSystem\File::delete($this->temp_folder.$path))
        );

    }

    /**
     * @since 1.0.0
     *
     * @param string $path
     * @param string $to
     *
     * @return void
     */
    #[TestWith(['/test.txt', '/test2.txt'])]
    public function testMoveUploadedFailed (string $path, string $to):void {

        $this->expectException(UploadedFileMoveException::class);

        FileSystem\File::moveUploaded($this->temp_folder.$path, $this->temp_folder.$to);

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $expected
     * @param string $path
     * @param string $output
     *
     * @throws \FireHub\Runtime\Exception\ReadFileException
     * @throws \FireHub\Runtime\Exception\EmptyPathException
     *
     * @return void
     */
    #[Depends('testPutContent')]
    #[TestWith([5, '/test.txt', 'hallo'])]
    public function testRead (int $expected, string $path, string $output):void {

        ob_start();

        $bytes = FileSystem\File::read($this->temp_folder.$path);

        $output = ob_get_clean();

        self::assertSame($expected, $bytes);
        self::assertSame($output, $output);

    }

    /**
     * @since 1.0.0
     *
     * @throws \FireHub\Runtime\Exception\ReadFileException
     *
     * @return void
     */
    public function testReadEmptyPath ():void {

        $this->expectException(EmptyPathException::class);

        FileSystem\File::read('');

    }

    /**
     * @since 1.0.0
     *
     * @param string $expected
     * @param string $path
     * @param int $offset
     * @param null|int $length
     *
     * @throws \FireHub\Runtime\Exception\ReadFileException
     *
     * @return void
     */
    #[Depends('testPutContent')]
    #[TestWith(['hallo', '/test.txt'])]
    #[TestWith(['llo', '/test.txt', 2])]
    #[TestWith(['ha', '/test.txt', 0, 2])]
    public function testGetContent (string $expected, string $path, int $offset = 0, ?int $length = null):void {

        self::assertSame($expected, FileSystem\File::getContent($this->temp_folder.$path, $offset, $length));

    }

    /**
     * @since 1.0.0
     *
     * @param list<string> $expected
     * @param string $path
     * @param bool $skip_empty_lines
     * @param bool $ignore_new_lines
     *
     * @throws \FireHub\Runtime\Exception\ReadFileException
     *
     * @return void
     */
    #[Depends('testPutContent')]
    #[TestWith([
        ['hallo'],
        '/test.txt'
    ])]
    public function testGetContentAsArray (array $expected, string $path, bool $skip_empty_lines = false, bool $ignore_new_lines = false):void {

        self::assertSame(
            $expected,
            FileSystem\File::getContentArray($this->temp_folder.$path, $skip_empty_lines, $ignore_new_lines)
        );

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testGetContentException ():void {

        $this->expectException(ReadFileException::class);

        $this->suppressPhpErrors(
            fn() => FileSystem\File::getContent($this->temp_folder.'x')
        );

    }

    /**
     * @since 1.0.0
     *
     * @param string $path
     * @param string|string[] $data
     *
     * @throws \FireHub\Runtime\Exception\FileNotFoundException
     * @throws \FireHub\Runtime\Exception\FileWriteException
     *
     * @return void
     */
    #[TestWith(['/test.txt', 'hallo'])]
    public function testPutContent (string $path, array|string $data):void {

        self::assertGreaterThan(0, FileSystem\File::putContent($this->temp_folder.$path, $data));

    }

}