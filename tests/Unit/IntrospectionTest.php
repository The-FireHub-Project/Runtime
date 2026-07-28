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

namespace FireHub\Tests\Runtime\Unit;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Introspection;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small
};

/**
 * ### Test PHP Runtime Introspection Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Introspection::class)]
final class IntrospectionTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testClasses ():void {

        self::assertIsList(Introspection::classes());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testInterfaces ():void {

        self::assertIsList(Introspection::interfaces());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testTraits ():void {

        self::assertIsList(Introspection::traits());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testDefinedConstants ():void {

        self::assertIsArray(Introspection::definedConstants());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testDefinedFunctions ():void {

        self::assertIsArray(Introspection::definedFunctions());

    }

}