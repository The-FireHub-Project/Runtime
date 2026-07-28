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

namespace FireHub\Runtime\Date;

use FireHub\Core\Boundary\Runtime\NativeRuntime;

use function date_sun_info;

/**
 * ### Solar Calculation Utilities
 *
 * Provides low-level wrappers for calculating sunrise, sunset, twilight, and other solar information using native
 * PHP date functions.
 * @since 1.0.0
 */
final class Solar extends NativeRuntime {

    /**
     * ### Gets information about sunset/sunrise and twilight begin/end
     * @since 1.0.0
     *
     * @param int $timestamp <p>
     * Unix timestamp.
     * </p>
     * @param float $latitude <p>
     * Latitude in degrees.
     * </p>
     * @param float $longitude <p>
     * Longitude in degrees.
     * </p>
     *
     * @return array{
     *   sunrise: int|bool,
     *   sunset: int|bool,
     *   transit: int|bool,
     *   civil_twilight_begin: int|bool,
     *   civil_twilight_end: int|bool,
     *   nautical_twilight_begin: int|bool,
     *   nautical_twilight_end: int|bool,
     *   astronomical_twilight_begin: int|bool,
     *   astronomical_twilight_end: int|bool
     * } Array with sunset and twilight details.
     */
    public static function info (int $timestamp, float $latitude, float $longitude):array {

        return date_sun_info($timestamp, $latitude, $longitude);

    }

}