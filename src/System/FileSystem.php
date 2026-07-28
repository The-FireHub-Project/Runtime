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

namespace FireHub\Runtime\System;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Runtime\Str;

use function get_included_files;

/**
 * ### PHP Runtime File System Utilities
 *
 * Provides low-level wrappers for interacting with the file system, including files, directories, paths,
 * permissions, and file metadata while preserving native PHP behavior.
 *
 * This component exposes PHP file system capabilities through a consistent FireHub Runtime API without altering
 * native runtime behavior.
 * @since 1.0.0
 */
final class FileSystem extends NativeRuntime {

    /**
     * ### Array with the names of included or required files
     * @since 1.0.0
     *
     * @return list<non-empty-string> Array of the names for all files referenced by include and family.
     */
    public static function includedFiles ():array {

        /** @var list<non-empty-string> */
        return get_included_files();

    }

}