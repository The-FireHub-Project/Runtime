<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.1
 * @package Runtime\Tests
 */

namespace FireHub\Tests\Runtime\Unit\Str\MB;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Str;
use FireHub\Core\Type\Str\Encoding;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### PHP Multibyte String Runtime Wrapper Utility - Configuration
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Str\MB\Configuration::class)]
final class ConfigurationTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param null|\FireHub\Core\Type\Str\Encoding $encoding
     *
     * @throws \FireHub\Runtime\Exception\InvalidEncodingException
     *
     * @return void
     */
    #[TestWith([Encoding::UTF_8])]
    public function testEncoding (?Encoding $encoding):void {

        self::assertTrue(Str\MB\Configuration::encoding($encoding));

        self::assertSame($encoding, Str\MB\Configuration::encoding());

    }

}