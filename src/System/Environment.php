<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.0
 * @package Runtime
 */

namespace FireHub\Runtime\System;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function getenv;
use function get_current_user;
use function putenv;
use function sys_get_temp_dir;

/**
 * ### PHP Runtime Environment Utilities
 *
 * Provides low-level wrappers for accessing and managing the current PHP process environment, including environment
 * variables, execution user information, and temporary directory locations while preserving native runtime behavior.
 *
 * This component exposes PHP environment capabilities through a consistent FireHub Runtime API without altering
 * operating system or process environment semantics.
 * @since 1.0.0
 */
final class Environment extends NativeRuntime {

    /**
     * ### Gets the value of a single or all the environment variables
     * @since 1.0.0
     *
     * @param null|string $name [optional] <p>
     * The variable name as a string or null.
     * </p>
     *
     * @return ($name is null ? array<string, string> : string|false) Returns the value of the environment variable
     * name, or false if the environment variable name doesn't exist.
     * If the name is null, all environment variables are returned as an associative array.
     */
    public static function getVariable (?string $name = null):array|string|false {

        return getenv($name);

    }

    /**
     * ### Sets the value of an environment variable
     *
     * Adds assignment to the server environment.
     *
     * The environment variable will only exist for the duration of the current request.
     *
     * At the end of the request, the environment is restored to its original state.
     * @since 1.0.0
     *
     * @param non-empty-string $assignment <p>
     * The setting, like "FOO=BAR".
     * </p>
     *
     * @return bool True on success or false on failure.
     */
    public static function setVariable (string $assignment):bool {

        return putenv($assignment);

    }

    /**
     * ### Gets the owner of the current PHP script file
     * @since 1.0.0
     *
     * @return string Username as a string.
     */
    public static function scriptOwner ():string {

        return get_current_user();

    }

    /**
     * ### Gets a directory path used for temporary files
     * @since 1.0.0
     *
     * @return non-empty-string Path of the temporary directory.
     */
    public static function tempFolder ():string {

        /** @var non-empty-string */
        return sys_get_temp_dir();

    }

}