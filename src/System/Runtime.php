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

namespace FireHub\Runtime\System;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Core\Type\Version\Constraint;
use FireHub\Runtime\Exception\SapiUnavailableException;

use function phpversion;
use function php_sapi_name;
use function version_compare;
use function zend_version;

/**
 * ### PHP Runtime Introspection Utilities
 *
 * Provides low-level wrappers for inspecting the current PHP runtime environment, including PHP version,
 * Zend Engine version, and Server API (SAPI) information while preserving native runtime behavior.
 *
 * This component exposes PHP runtime metadata through a consistent FireHub Runtime API without altering native
 * runtime detection semantics.
 * @since 1.0.0
 */
final class Runtime extends NativeRuntime {

    /**
     * ### Type of interface between web server and PHP
     *
     * Returns a lowercase string that describes the type of interface (the Server API, SAPI) that PHP is using.
     *
     * For example, in CLI PHP this string will be "cli" whereas with Apache it may have several different values
     * depending on the exact SAPI used.
     * @since 1.0.0
     *
     * @throws \FireHub\Runtime\Exception\SapiUnavailableException If failed to get server
     * API.
     *
     * @return non-empty-string Interface type.
     */
    public static function serverAPI ():string {

        return ($sapi_name = php_sapi_name()) !== false
            ? $sapi_name : throw new SapiUnavailableException;

    }

    /**
     * ### Gets the current PHP or extension version
     * @since 1.0.0
     *
     * @param null|non-empty-string $extension <p>
     * An optional extension name.
     * </p>
     *
     * @return string|false The current PHP version as a string.
     * If a string argument is provided for an extension parameter, phpversion() returns the version of that extension,
     * or false if there is no version information associated or the extension isn't enabled.
     */
    public static function phpVersion (?string $extension = null):string|false {

        return phpversion($extension); //@phpstan-ignore argument.type

    }

    /**
     * ### Gets the version of the current Zend engine
     * @since 1.0.0
     *
     * @return non-empty-string Zend Engine version number, as a string.
     */
    public static function zendVersion ():string {

        /** @var non-empty-string */
        return zend_version();

    }

    /**
     * ### Compares two "PHP-standardized" version number strings
     * @since 1.0.0
     *
     * @param string $first <p>
     * First version number.
     * </p>
     * @param string $second <p>
     * Second version number.
     * </p>
     * @param null|\FireHub\Core\Type\Version\Constraint $comparison [optional] <p>
     * Comparison constraint.
     * </p>
     *
     * @return ($comparison is null
     *   ? int-mask<-1, 0, 1>
     *   : bool
     * ) Returns -1 if the first version is lower than the second, 0 if they're equal, and 1 if the second is lower.
     */
    public static function compareVersion (string $first, string $second, ?Constraint $comparison = null):int|bool {

        /**
         * @var ($comparison is null
         *   ? int-mask<-1, 0, 1>
         *   : bool
         * )
         *
         * @phpstan-ignore-next-line
         */
        return version_compare(
            $first,
            $second,
            $comparison?->value
        );

    }

}