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
use Countable;

/**
 * ### Data data provider
 * @since 1.0.0
 */
final class DataDataProvider {

    /**
     * @since 1.0.0
     *
     * @return array<array<string>>
     */
    public static function string ():array {

        return [
            ['firehub'],
            ['']
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<int>>
     */
    public static function int ():array {

        return [
            [10],
            [-5],
            [0]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<float>>
     */
    public static function float ():array {

        return [
            [10.5],
            [-2.3]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<array>>
     */
    public static function array ():array {

        return [
            [[1, 2, 3]],
            [[1 => 'one', 2 => 'two', 3 => 'three']]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<null>>
     */
    public static function null ():array {

        return [
            [null]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<bool>>
     */
    public static function bool ():array {

        return [
            [true],
            [false]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<callable>>
     */
    public static function callable ():array {

        return [
            [fn() => true],
            [new class {public function __invoke () {}}]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<Countable>>
     */
    public static function countable ():array {

        return [
            [new class implements Countable {public function count ():int {return 10;}}]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<resource>>
     */
    public static function resource ():array {

        return [
            [fopen('php://stdout', 'wb')]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<resource>>
     */
    public static function closedResource ():array {

        $resource = fopen('php://stdout', 'wb');
        fclose($resource);

        return [
            [$resource]
        ];

    }

}