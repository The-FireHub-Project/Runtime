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
 * ### String data provider
 * @since 1.0.0
 */
final class StrDataProvider {

    /**
     * @since 1.0.0
     *
     * @return array<array<string>>
     */
    public static function stringsSB ():array {

        return [
            ['The lazy fox jumped over the fence.']
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<string>>
     */
    public static function stringsMB ():array {

        return [
            ['đščćž 诶杰艾玛 ЛЙ ÈßÁ カタカナ']
        ];

    }

}