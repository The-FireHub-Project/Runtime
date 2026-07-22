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

namespace FireHub\Runtime\Date;

use FireHub\Core\Boundary\Runtime\NativeRuntime;
use FireHub\Core\Type\Date\Zone;
use FireHub\Runtime\Exception\ {
    FailedToGetTimezoneException, FailedToSetTimezoneException
};

use function date_default_timezone_get;
use function date_default_timezone_set;
use function timezone_abbreviations_list;

/**
 * ### Time Zone Utilities
 *
 * Provides low-level wrappers for retrieving, configuring, and inspecting PHP time zone settings while preserving
 * native runtime behavior.
 * @since 1.0.0
 */
final class Timezone extends NativeRuntime {

    /**
     * ### Gets the default timezone used by all date/time functions in a script
     *
     * In order of preference, this function returns the default timezone by:
     * - Reading the timezone set using the setDefaultTimezone() method (if any).
     * - Reading the value of the 'date.timezone' ini option (if set).
     *
     * If none of the above succeeds, DateAndTimeZone#getDefaultTimezone() will return a default timezone of UTC.
     * @since 1.0.0
     *
     * @throws \FireHub\Runtime\Exception\FailedToGetTimezoneException If we can't get the default timezone.
     *
     * @return \FireHub\Core\Type\Date\Zone Timezone enum.
     */
    public static function getDefault ():Zone {

        return Zone::tryFrom(date_default_timezone_get())
            ?? throw new FailedToGetTimezoneException;

    }

    /**
     * ### Sets the default timezone used by all date/time functions in a script
     *
     * Method sets the default timezone used by all date/time functions.
     *
     * Instead of using this function to set the default timezone in your script, you can also use the INI setting
     * 'date.timezone' to set the default timezone.
     * @since 1.0.0
     *
     * @param \FireHub\Core\Type\Date\Zone $zone <p>
     * The timezone identifier.
     * </p>
     *
     * @throws \FireHub\Runtime\Exception\FailedToSetTimezoneException If failed to set the default timezone.
     *
     * @return true Always true.
     */
    public static function setDefault (Zone $zone):true {

        return date_default_timezone_set($zone->value)
            ?: throw new FailedToSetTimezoneException;

    }

    /**
     * ### Get an associative array containing dst, offset, and the timezone name alias
     * @since 1.0.0
     *
     * @return array<string, list<array{
     *   dst: bool,
     *   offset: int,
     *   timezone_id: string|null
     * }>> List of timezone abbreviations.
     */
    public static function abbreviationList ():array {

        return timezone_abbreviations_list();

    }

}