<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.2
 * @package Runtime
 */

namespace FireHub\Runtime\Stream;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function stream_resolve_include_path;

/**
 * ### PHP Runtime Stream Path Utilities
 *
 * Provides low-level wrappers for resolving file paths using the configured PHP include path.
 *
 * This component preserves native PHP stream path resolution behavior.
 * @since 1.0.0
 */
final readonly class Path extends NativeRuntime {

    /**
     * ### Resolves a file path
     *
     * Resolves the specified filename against the configured PHP include path.
     *
     * Returns the resolved absolute path when the file is found, or false when the file cannot be resolved.
     * @since 1.0.0
     *
     * @param string $filename <p>
     * Name or path of the file to resolve using the configured PHP include path.
     * </p>
     *
     * @return string|false Resolved absolute file path on success, false if the file cannot be found.
     */
    public static function resolve (string $filename):string|false {

        return stream_resolve_include_path($filename);

    }

}