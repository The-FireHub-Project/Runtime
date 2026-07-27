<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=7.4
 * @package Runtime\Tests
 */

namespace FireHub\Tests\Runtime\DataProviders;

use FireHub\Core\Type\Date\Zone;

/**
 * ### Date data provider
 * @since 1.0.0
 */
final class DateDataProvider {

    /**
     * @since 1.0.0
     *
     * @return array<int[]>
     */
    public static function validDates ():array {

        return [
            [1, 1, 1],
            [2024, 12, 31],
            [1000, 10, 6]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<int[]>
     */
    public static function invalidDates ():array {

        return [
            [0, -1, -1],
            [1, 1, 32],
            [1, 13, 12]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<string[]>
     */
    public static function stringToTime ():array {

        return [
            ['now'],
            ['10 September 2000'],
            ['+1 day'],
            ['+1 week'],
            ['+1 week 2 days 4 hours 2 seconds'],
            ['next Thursday'],
            ['last Monday']
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<\FireHub\Core\Type\Date\Zone[]>
     */
    public static function timezones ():array {

        $zones = [];
        foreach (Zone::cases() as $zone)
            $zones[][] = $zone;

        return $zones;

    }

}