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
use FireHub\Tests\Runtime\Stubs\FilledClass;
use FireHub\Testing\Stubs\ {
    EmptyClass, EmptyEnum, EmptyInterface, EmptyTrait
};
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test Object and Class Inspection
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(ObjectModel\Inspection::class)]
final class InspectionTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param class-string $name
     * @param bool $excepted
     *
     * @return void
     */
    #[TestWith([EmptyClass::class, true])]
    #[TestWith([EmptyInterface::class, false])]
    #[TestWith([EmptyTrait::class, false])]
    #[TestWith([EmptyEnum::class, false])]
    public function testIsClass (string $name, bool $excepted):void {

        self::assertSame($excepted, ObjectModel\Inspection::isClass($name));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $name
     * @param bool $excepted
     *
     * @return void
     */
    #[TestWith([EmptyClass::class, false])]
    #[TestWith([EmptyInterface::class, true])]
    #[TestWith([EmptyTrait::class, false])]
    #[TestWith([EmptyEnum::class, false])]
    public function testIsInterface (string $name, bool $excepted):void {

        self::assertSame($excepted, ObjectModel\Inspection::isInterface($name));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $name
     * @param bool $excepted
     *
     * @return void
     */
    #[TestWith([EmptyClass::class, false])]
    #[TestWith([EmptyInterface::class, false])]
    #[TestWith([EmptyTrait::class, true])]
    #[TestWith([EmptyEnum::class, false])]
    public function testIsTrait (string $name, bool $excepted):void {

        self::assertSame($excepted, ObjectModel\Inspection::isTrait($name));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $name
     * @param bool $excepted
     *
     * @return void
     */
    #[TestWith([EmptyClass::class, false])]
    #[TestWith([EmptyInterface::class, false])]
    #[TestWith([EmptyTrait::class, false])]
    #[TestWith([EmptyEnum::class, true])]
    public function testIsEnum (string $name, bool $excepted):void {

        self::assertSame($excepted, ObjectModel\Inspection::isEnum($name));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param class-string $class
     * @param non-empty-string $method
     *
     * @return void
     */
    #[TestWith([true, FilledClass::class, 'publicMethod'])]
    #[TestWith([false, FilledClass::class, 'xxx'])]
    public function testMethodExists (bool $expected, string $class, string $method):void {

        self::assertSame($expected, ObjectModel\Inspection::methodExists($class, $method));
        self::assertSame($expected, ObjectModel\Inspection::methodExists(new $class, $method));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param class-string $class
     * @param non-empty-string $property
     *
     * @return void
     */
    #[TestWith([true, FilledClass::class, 'publicVar'])]
    #[TestWith([false, FilledClass::class, 'xxx'])]
    public function testPropertyExists (bool $expected, string $class, string $property):void {

        self::assertSame($expected, ObjectModel\Inspection::propertyExists($class, $property));
        self::assertSame($expected, ObjectModel\Inspection::propertyExists(new $class, $property));

    }

}