<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=7.4
 * @package Runtime
 */

namespace FireHub\Runtime\FileSystem;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function is_executable;
use function is_readable;
use function is_writable;

/**
 * ### PHP Runtime File System Permission Utilities
 *
 * Provides low-level wrappers for inspecting and modifying file system permissions, ownership, and access
 * capabilities while preserving native PHP behavior.
 *
 * This component exposes PHP permission management capabilities through a consistent FireHub Runtime API without
 * altering native runtime semantics.
 * @since 1.0.0
 */
final class Permission extends NativeRuntime {

    /**
     * ### Tells whether the path is executable
     * @since 1.0.0
     *
     * @param string $path <p>
     * Path to the file.
     * </p>
     *
     * @return bool True if the filename exists and is an executable file, false otherwise.
     *
     * @note On POSIX systems, a file is executable if the executable bit of the file permissions is set.
     * On Windows, a file is considered executable if it is a properly executable file as reported by the Win API
     * GetBinaryType(); for BC reasons, files with a .bat or .cmd extension are also considered executable.
     * @note The results of this function are cached.
     * See Metadata::clearCache() for more details.
     */
    public static function isExecutable (string $path):bool {

        return is_executable($path);

    }

    /**
     * ### Tells whether a file exists and is readable
     * @since 1.0.0
     *
     * @param string $path <p>
     * Path to the file or folder.
     * </p>
     *
     * @return bool True if the file or directory specified by $path exists and is readable, false otherwise.
     *
     * @note The check is done using the real UID/GID instead of the effective one.
     * @note The results of this function are cached.
     * See Metadata::clearCache() for more details.
     */
    public static function isReadable (string $path):bool {

        return is_readable($path);

    }

    /**
     * Tells whether the path is writable
     * @since 1.0.0
     *
     * @param string $path <p>
     * Path to the file.
     * </p>
     *
     * @return bool True if the filename exists and is writable.
     *
     * @note The results of this function are cached.
     * See Metadata::clearCache() for more details.
     */
    public static function isWritable (string $path):bool {

        return is_writable($path);

    }

}