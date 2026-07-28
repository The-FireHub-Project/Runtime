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
use FireHub\Runtime\Exception\DiskSpaceException;

use function disk_free_space;
use function disk_total_space;

/**
 * ### PHP Runtime File System Storage Utilities
 *
 * Provides low-level wrappers for inspecting available file system storage capacity, including total and free disk
 * space while preserving native PHP behavior.
 *
 * This component exposes PHP storage information capabilities through a consistent FireHub Runtime API without
 * altering native runtime semantics.
 * @since 1.0.0
 */
final class Storage extends NativeRuntime {

    /**
     * ### Gets total size of a filesystem or disk partition
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to folder ot disk partition.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\DiskSpaceException If we couldn't get disk space for a path.
     *
     * @return float Returns the total number of bytes as a float.
     *
     * @note Given a filename instead of a folder, the behavior of the function is unspecified and may differ
     * between operating systems and PHP versions.
     * @note This function will not work on remote files as the file to be examined must be accessible via the
     * server's filesystem.
     */
    public static function totalSpace (string $path):float {

        return ($space = disk_total_space($path)) !== false
            ? $space : throw new DiskSpaceException;

    }

    /**
     * ### Gets free space of a filesystem or disk partition
     * @since 1.0.0
     *
     * @param non-empty-string $path <p>
     * Path to folder ot disk partition.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\DiskSpaceException If we couldn't get disk space for a path.
     *
     * @return float Returns the total free space of bytes as a float.
     *
     * @note Given a filename instead of a folder, the behavior of the function is unspecified and may differ
     * between operating systems and PHP versions.
     * @note This function will not work on remote files as the file to be examined must be accessible via the
     * server's filesystem.
     */
    public static function freeSpace (string $path):float {

        return ($space = disk_free_space($path)) !== false
            ? $space : throw new DiskSpaceException;

    }

}