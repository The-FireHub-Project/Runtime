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
use FireHub\Tests\Runtime\Stubs\ {
    EmptyClass, FilledClass
};
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test Object and Class Metadata
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(ObjectModel\Metadata::class)]
final class MetadataTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param class-string $class
     * @param class-string $alias
     *
     * @throws \FireHub\Runtime\Exception\ClassAliasException
     *
     * @return void
     */
    #[TestWith([EmptyClass::class, 'NewTestClass'])]
    public function testAlias (string $class, string $alias):void {

        ObjectModel\Metadata::alias($class, $alias);

        self::assertInstanceOf(\NewTestClass::class, new $class);

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $class
     *
     * @throws \FireHub\Runtime\Exception\ClassDoesntExistException
     *
     * @return void
     */
    #[TestWith([FilledClass::class])]
    public function testProperties (string $class):void {

        self::assertSame(['publicVar' => 'foo'], ObjectModel\Metadata::properties($class));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testMangledProperties ():void {

        $vars = ObjectModel\Metadata::mangledProperties(new FilledClass());

        self::assertArrayHasKey('publicVar', $vars);

        self::assertArraysHaveIdenticalValues(['foo'], $vars);

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $class
     *
     * @throws \FireHub\Runtime\Exception\ClassDoesntExistException
     *
     * @return void
     */
    #[TestWith([FilledClass::class])]
    public function testMethods (string $class):void {

        self::assertSame(['publicMethod'], ObjectModel\Metadata::methods($class));

    }

}