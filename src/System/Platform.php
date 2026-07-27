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

use function php_uname;

/**
 * ### PHP Platform Utilities
 *
 * Provides low-level wrappers for inspecting the underlying operating system and hardware platform where PHP is
 * running, including system name, hostname, release, version, and machine architecture while preserving native
 * runtime behavior.
 *
 * This component exposes PHP platform information through a consistent FireHub Runtime API without altering
 * operating system detection semantics.
 * @since 1.0.0
 */
final class Platform extends NativeRuntime {

    /**
     * ### Gets OS information
     *
     * Information about the operating system PHP is running one "cli" whereas with Apache it may have several different
     * values depending on the exact SAPI used.
     * @since 1.0.0
     *
     * @return array{name: string, hostname: string, release: string, version: string, machine: string} Operating system
     * information.
     */
    public static function osInfo ():array {

        return [
            'name' => php_uname('s'),
            'hostname' => php_uname('n'),
            'release' => php_uname('r'),
            'version' => php_uname('v'),
            'machine' => php_uname('m')
        ];

    }

}