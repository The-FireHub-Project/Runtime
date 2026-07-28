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
 * ### Constant data provider
 * @since 1.0.0
 */
final class ConstantDataProvider {

    /**
     * @since 1.0.0
     *
     * @return array<array<non-empty-string, mixed>>
     */
    public static function types ():array {

        return [
            ['testString', 'test'],
            ['testInt', 10],
            ['testBool', false],
            ['testNull', null],
            ['testArray', ['x']]
        ];

    }

}