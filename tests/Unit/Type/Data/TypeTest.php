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

namespace FireHub\Tests\Runtime\Unit\Type\Data;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\Type\Data\ {
    Category, Type
};
use FireHub\Tests\Runtime\DataProviders\DataDataProvider;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Group, Small
};

/**
 * ### Test PHP Runtime Data Type
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Type::class)]
final class TypeTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testCategory ():void {

        self::assertSame(Category::SCALAR, Type::BOOL->category());
        self::assertSame(Category::SCALAR, Type::INT->category());
        self::assertSame(Category::SCALAR, Type::FLOAT->category());
        self::assertSame(Category::SCALAR, Type::STRING->category());

        self::assertSame(Category::COMPOUND, Type::ARRAY->category());
        self::assertSame(Category::COMPOUND, Type::OBJECT->category());

        self::assertSame(Category::SPECIAL, Type::NULL->category());
        self::assertSame(Category::SPECIAL, Type::RESOURCE->category());
        self::assertSame(Category::SPECIAL, Type::CLOSED_RESOURCE->category());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testIsScalar():void {

        self::assertTrue(Type::BOOL->isScalar());
        self::assertTrue(Type::INT->isScalar());
        self::assertTrue(Type::FLOAT->isScalar());
        self::assertTrue(Type::STRING->isScalar());

        self::assertFalse(Type::ARRAY->isScalar());
        self::assertFalse(Type::OBJECT->isScalar());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testIsCompound ():void {

        self::assertTrue(Type::ARRAY->isCompound());
        self::assertTrue(Type::OBJECT->isCompound());

        self::assertFalse(Type::STRING->isCompound());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testIsSpecial ():void {

        self::assertTrue(Type::NULL->isSpecial());
        self::assertTrue(Type::RESOURCE->isSpecial());

        self::assertFalse(Type::BOOL->isSpecial());

    }

}