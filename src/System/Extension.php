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
use FireHub\Runtime\Exception\ExtensionNotFoundException;

use function extension_loaded;
use function get_extension_funcs;
use function get_loaded_extensions;

/**
 * ### PHP Extension Management Utilities
 *
 * Provides low-level wrappers for inspecting PHP extensions, including checking loaded extensions, retrieving
 * extension functions, and listing available modules while preserving native runtime behavior.
 *
 * This component exposes PHP extension discovery capabilities through a consistent FireHub Runtime API without
 * altering extension loading or execution semantics.
 * @since 1.0.0
 */
final class Extension extends NativeRuntime {

    /**
     * ### Check if a PHP extension is loaded
     * @since 1.0.0
     *
     * @param non-empty-string $name <p>
     * Extension name or verified extension enum.
     *
     * This parameter is case-insensitive for strings.
     * </p>
     *
     * @return bool True if the extension is loaded, false otherwise.
     */
    public static function hasExtension (string $name):bool {

        return extension_loaded($name);

    }

    /**
     * ### Array with the names of all modules compiled and loaded
     * @since 1.0.0
     *
     * @return list<non-empty-string> Indexed array of all the module names.
     */
    public static function loadedExtensions ():array {

        /** @var list<non-empty-string> */
        return get_loaded_extensions();

    }

    /**
     * ### Array with the names of the functions for a module
     * @since 1.0.0
     *
     * @param string $extension <p>
     * The module name. This parameter is case-insensitive.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\ExtensionNotFoundException If the extension is not valid or does not have
     * functions.
     *
     * @return list<non-empty-string> Array with all the functions.
     */
    public static function extensionFunctions (string $extension):array {

        return ($functions = get_extension_funcs($extension)) !== false
            ? $functions : throw new ExtensionNotFoundException('Extension not found or does not have functions.');

    }

}