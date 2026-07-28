<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.4
 * @package Runtime
 */

namespace FireHub\Runtime\FileSystem;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Runtime\Exception\ {
    InvalidPathParentLevelException, PathResolutionException
};

use function basename;
use function dirname;
use function pathinfo;
use function realpath;

/**
 * ### PHP Runtime File System Path Utilities
 *
 * Provides low-level wrappers for manipulating and resolving file system paths, including path extraction,
 * normalization, and path information inspection while preserving native PHP behavior.
 *
 * This component exposes PHP path handling capabilities through a consistent FireHub Runtime API without altering
 * native runtime semantics.
 * @since 1.0.0
 */
final class Path extends NativeRuntime {

    /**
     * ### Returns a trailing name component of a path
     *
     * Given a string containing the path to a file or directory, this function will return the trailing name component.
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * A path. On Windows, both slash (/) and backslash (\) are used as directory separator characters.
     * In other environments, it is the forward slash (/).
     * </p>
     * @param string $suffix [optional] <p>
     * If the name component ends in suffix, this will also be cut off.
     * </p>
     *
     * @return string The base name of the given path.
     *
     * @caution Method is locale-aware, so for it to see the correct basename with multibyte character paths,
     * the matching locale must be set using the setlocale() function.
     * If a path contains characters which are invalid for the current locale, the behavior of
     * FileSystem::basename() is undefined.
     * @note Method operates naively on the input string and is not aware of the actual filesystem or path
     * components such as "..".
     */
    public static function basename (string $path, string $suffix = ''):string {

        return basename($path, $suffix);

    }

    /**
     * ### Returns parent folder path
     *
     * Given a string containing the path of a file or directory, this function will return the parent folder's path
     * that is $level up from the current folder.
     * @since 1.0.0
     *
     * @param string $path <p>
     * A path.
     * </p>
     * @param positive-int $levels [optional] <p>
     * The number of parent folders to go up.
     * This must be an integer greater than 0.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\InvalidPathParentLevelException If $levels is less than 1.
     *
     * @return string The parent folder name of the given path.
     * If there are no slashes in a path, a dot is returned, indicating the current folder.
     *
     * @caution Be careful when using this function in a loop that can reach the top-level directory as this can
     * result in an infinite loop.
     */
    public static function parent (string $path, int $levels = 1):string {

        return $levels >= 1
            ? dirname($path, $levels)
            : throw new InvalidPathParentLevelException(
                'The number of parent levels must be greater than zero.',
                [
                    'levels' => $levels,
                    'minimum' => 1,
                ]
            );

    }

    /**
     * ### Returns information about a file path
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * The path to be parsed.
     * </p>
     *
     * @return array{
     *   'dirname': string|null,
     *   'basename': string,
     *   'extension': string|null,
     *   'filename': string
     * } Information about a file path.
     *
     * @caution Path::pathInfo() is locale-aware, so for it to parse a path containing multibyte characters
     * correctly, the matching locale must be set using the setlocale() function.
     * @note Path::pathInfo() operates naively on the input string and is not aware of the actual filesystem,
     * or path components such as "..".
     * @note On Windows systems only, the \ character will be interpreted as a directory separator.
     * On other systems it will be treated like any other character.
     */
    public static function info (string $path):array {

        $path_info = pathinfo($path);

        return [
            'dirname' => $path_info['dirname'] ?? null, // @phpstan-ignore nullCoalesce.unnecessary
            'basename' => $path_info['basename'],
            'extension' => $path_info['extension'] ?? null,
            'filename' => $path_info['filename']
        ];

    }

    /**
     * ### Returns canonical absolute pathname
     *
     * Expands all symbolic links and resolves references to /./, /../ and extra / characters in the input path and
     * returns the canonical absolute pathname.
     *
     * Trailing delimiters, such as \ and /, are also removed.
     * @since 1.0.0
     *
     * @param string $path <p>
     * The path being checked.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\PathResolutionException If we couldn't get an absolute path for a path or
     * file doesn't exist, or a script doesn't have executable permissions.
     *
     * @return non-empty-string The canonical absolute pathname.
     *
     * @note The running script must have executable permissions in all directories in the hierarchy, otherwise
     * Path::absolute() will return false.
     * @note For case-insensitive filesystems, absolutePath() may or may not normalize the character case.
     * @note The function Path::absolute() will not work for a file which is inside a Phar as such a path would be
     * virtual path, not a real one.
     * @note On Windows, one level only expands junctions and symbolic links to directories.
     * @note Because PHP's integer type is signed and many platforms use 32bit integers, some filesystem functions
     * may return unexpected results for files which are larger than 2GB.
     */
    public static function absolute (string $path):string {

        return realpath($path)
            ?: throw new PathResolutionException;

    }

}