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

/**
 * ### Numeric data provider
 * @since 1.0.0
 */
final class NumDataProvider {

    /**
     * @since 1.0.0
     *
     * @return array<array<positive-int>>
     */
    public static function positiveInt ():array {

        return [[10], [45874], [INF]];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<negative-int>>
     */
    public static function negativeInt ():array {

        return [[-1], [-4568], [-INF]];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<float>>
     */
    public static function positiveFloat ():array {

        return [[0.435435], [45.223], [43253.43543]];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<float>>
     */
    public static function negativeFloat ():array {

        return [[-0.3532545], [-1.2], [-10.567]];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<int>>
     */
    public static function null ():array {

        return [[0], [-0], [0.0000], [-0.00]];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<int>>
     */
    public static function nan ():array {

        return [[NAN]];

    }

}