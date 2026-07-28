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
use FireHub\Runtime\ObjectModel;
use FireHub\Tests\Runtime\Stubs\EmptyClass;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test Object Identity Management
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(ObjectModel\Identity::class)]
final class IdentityTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param class-string $class
     *
     * @return void
     */
    #[TestWith([EmptyClass::class])]
    public function testID (string $class):void {

        self::assertIsInt(ObjectModel\Identity::id(new $class));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $class
     *
     * @return void
     */
    #[TestWith([EmptyClass::class])]
    public function testHash (string $class):void {

        self::assertIsString(ObjectModel\Identity::hash(new $class));

    }

}