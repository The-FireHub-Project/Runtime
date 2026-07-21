<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.0
 * @package Runtime\Tests
 */

namespace FireHub\Tests\Runtime\Unit;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\ObjectModel;
use FireHub\Tests\Runtime\Stubs\ {
    EmptyClass, EmptyInterface, EmptyTrait, FilledClass
};
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test Object and Class Relations
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(ObjectModel\Relation::class)]
final class RelationTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param class-string $class
     * @param class-string $class1
     *
     * @return void
     */
    #[TestWith([true, FilledClass::class, EmptyInterface::class])]
    #[TestWith([false, FilledClass::class, 'xxx'])]
    public function testInstanceOf (bool $expected, string $class, string $class1):void {

        self::assertSame($expected, ObjectModel\Relation::instanceOf($class, $class1));
        self::assertSame($expected, ObjectModel\Relation::instanceOf(new $class, $class1));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param class-string $object_or_class
     * @param class-string $class
     *
     * @return void
     */
    #[TestWith([true, FilledClass::class, EmptyClass::class])]
    #[TestWith([false, FilledClass::class, 'xxx'])]
    public function testIsSubClassOf (bool $expected, string|object $object_or_class, string $class):void {

        self::assertSame($expected, ObjectModel\Relation::isSubClassOf($object_or_class, $class));
        self::assertSame($expected, ObjectModel\Relation::isSubClassOf(new $object_or_class, $class));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string|object $object_or_class
     * @param class-string $class
     *
     * @throws \FireHub\Runtime\Exception\ClassDoesntExistException
     *
     * @return void
     */
    #[TestWith([FilledClass::class, EmptyClass::class])]
    public function testParentClass (string|object $object_or_class, string $class):void {

        self::assertSame($class, ObjectModel\Relation::parentClass($object_or_class));
        self::assertSame($class, ObjectModel\Relation::parentClass(new $object_or_class));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $expected
     * @param class-string $object_or_class
     *
     * @throws \FireHub\Runtime\Exception\ClassDoesntExistException
     *
     * @return void
     */
    #[TestWith([EmptyClass::class, FilledClass::class])]
    public function testParents (string $expected, string|object $object_or_class):void {

        self::assertSame([$expected => $expected], ObjectModel\Relation::parents($object_or_class));
        self::assertSame([$expected => $expected], ObjectModel\Relation::parents(new $object_or_class));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $expected
     * @param class-string $object_or_class
     *
     * @throws \FireHub\Runtime\Exception\ClassDoesntExistException
     *
     * @return void
     */
    #[TestWith([EmptyInterface::class, FilledClass::class])]
    public function testImplements (string $expected, string|object $object_or_class):void {

        self::assertSame([$expected => $expected], ObjectModel\Relation::implements($object_or_class));
        self::assertSame([$expected => $expected], ObjectModel\Relation::implements(new $object_or_class));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $expected
     * @param class-string $object_or_class
     *
     * @throws \FireHub\Runtime\Exception\ClassDoesntExistException
     *
     * @return void
     */
    #[TestWith([EmptyTrait::class, FilledClass::class])]
    public function testUses (string $expected, string|object $object_or_class):void {

        self::assertSame([$expected => $expected], ObjectModel\Relation::uses($object_or_class));
        self::assertSame([$expected => $expected], ObjectModel\Relation::uses(new $object_or_class));

    }

}