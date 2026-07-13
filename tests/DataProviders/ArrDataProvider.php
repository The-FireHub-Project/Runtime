<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.2
 * @package Runtime\Tests
 */

namespace FireHub\Tests\Runtime\DataProviders;

/**
 * ### Array data provider
 * @since 1.0.0
 */
class ArrDataProvider {

    /**
     * @since 1.0.0
     *
     * @return array<list>
     */
    public static function list ():array {

        return [
            [[1, 2, 3]],
            [[10.2, 200, -3]],
            [['x', 'y', 'z']],
            [[]]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array>
     */
    public static function associative ():array {

        return [
            [['one' => 1, 'two' => 2, 'three' => 3]],
            [['ONE' => 1, 'TWO' => 2, 'THREE' => 3]],
            [[2 => '', 'x' => null, 5 => false]]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array>
     */
    public static function multidimensional ():array {

        return [
            [['one' => [1, 2, 3], 'two' => [4, 5, 6], 'three' => [7, 8, 9]]],
            [[1 => [1 => null, 2 => false], 2 => [1 => true, 'x' => false]]]
        ];

    }

}