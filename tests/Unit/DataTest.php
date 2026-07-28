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
use FireHub\Runtime\ {
    Data, DataIs
};
use FireHub\Runtime\Type\Data\Type;
use FireHub\Runtime\Exception\{
    ArrayToStringConversionException, CannotSerializeException, CannotUnserializeException,
    ResourceTypeConversionException
};
use FireHub\Tests\Runtime\DataProviders\DataDataProvider;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Group, Small, TestWith
};

/**
 * ### Test PHP Data Runtime Utility
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Data::class)]
#[CoversClass(DataIs::class)]
final class DataTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    public function testArray (mixed $value):void {

        self::assertTrue(DataIs::array($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotArray (mixed $value):void {

        self::assertFalse(DataIs::array($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    public function testBool (mixed $value):void {

        self::assertTrue(DataIs::bool($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotBool (mixed $value):void {

        self::assertFalse(DataIs::bool($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    public function testCallable (mixed $value):void {

        self::assertTrue(DataIs::callable($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotCallable (mixed $value):void {

        self::assertFalse(DataIs::callable($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    public function testCountable (mixed $value):void {

        self::assertTrue(DataIs::countable($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotCountable (mixed $value):void {

        self::assertFalse(DataIs::countable($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    public function testFloat (mixed $value):void {

        self::assertTrue(DataIs::float($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotFloat (mixed $value):void {

        self::assertFalse(DataIs::float($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    public function testInt (mixed $value):void {

        self::assertTrue(DataIs::int($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotInt (mixed $value):void {

        self::assertFalse(DataIs::int($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    public function testIterable (mixed $value):void {

        self::assertTrue(DataIs::iterable($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotIterable (mixed $value):void {

        self::assertFalse(DataIs::iterable($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    public function testNull (mixed $value):void {

        self::assertTrue(DataIs::null($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotNull (mixed $value):void {

        self::assertFalse(DataIs::null($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    public function testNumeric (mixed $value):void {

        self::assertTrue(DataIs::numeric($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotNumeric (mixed $value):void {

        self::assertFalse(DataIs::numeric($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    public function testObject (mixed $value):void {

        self::assertTrue(DataIs::object($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotObject (mixed $value):void {

        self::assertFalse(DataIs::object($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testResource (mixed $value):void {

        self::assertTrue(DataIs::resource($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    public function testNotResource (mixed $value):void {

        self::assertFalse(DataIs::resource($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    public function testScalar (mixed $value):void {

        self::assertTrue(DataIs::scalar($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotsScalar (mixed $value):void {

        self::assertFalse(DataIs::scalar($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    public function testString (mixed $value):void {

        self::assertTrue(DataIs::string($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotString (mixed $value):void {

        self::assertFalse(DataIs::string($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    public function testGetDebugType (mixed $value):void {

        self::assertSame('string', Data::getDebugType($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    public function testGetTypeString (mixed $value):void {

        self::assertSame(Type::STRING, Data::getType($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    public function testGetTypeInt (mixed $value):void {

        self::assertSame(Type::INT, Data::getType($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    public function testGetTypeFloat (mixed $value):void {

        self::assertSame(Type::FLOAT, Data::getType($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    public function testGetTypeArray (mixed $value):void {

        self::assertSame(Type::ARRAY, Data::getType($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    public function testGetTypeNull (mixed $value):void {

        self::assertSame(Type::NULL, Data::getType($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    public function testGetTypeBool (mixed $value):void {

        self::assertSame(Type::BOOL, Data::getType($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    public function testGetTypeObject (mixed $value):void {

        self::assertSame(Type::OBJECT, Data::getType($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testGetTypeResource (mixed $value):void {

        self::assertSame(Type::RESOURCE, Data::getType($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'closedResource')]
    public function testGetTypeClosedResource (mixed $value):void {

        self::assertSame(Type::CLOSED_RESOURCE, Data::getType($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @throws \FireHub\Runtime\Exception\ArrayToStringConversionException
     * @throws \FireHub\Runtime\Exception\ResourceTypeConversionException
     * @throws \FireHub\Runtime\Exception\FailedToConvertTypeException
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    public function testSetTypeString (mixed $value):void {

        self::assertSame(Type::STRING, Data::getType(Data::setType($value, Type::STRING)));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @throws \FireHub\Runtime\Exception\ArrayToStringConversionException
     * @throws \FireHub\Runtime\Exception\ResourceTypeConversionException
     * @throws \FireHub\Runtime\Exception\FailedToConvertTypeException
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    public function testSetTypeInt (mixed $value):void {

        self::assertSame(Type::INT, Data::getType(Data::setType($value, Type::INT)));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @throws \FireHub\Runtime\Exception\ArrayToStringConversionException
     * @throws \FireHub\Runtime\Exception\ResourceTypeConversionException
     * @throws \FireHub\Runtime\Exception\FailedToConvertTypeException
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    public function testSetTypeFloat (mixed $value):void {

        self::assertSame(Type::FLOAT, Data::getType(Data::setType($value, Type::FLOAT)));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @throws \FireHub\Runtime\Exception\ArrayToStringConversionException
     * @throws \FireHub\Runtime\Exception\ResourceTypeConversionException
     * @throws \FireHub\Runtime\Exception\FailedToConvertTypeException
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    public function testSetTypeArray (mixed $value):void {

        self::assertSame(Type::ARRAY, Data::getType(Data::setType($value, Type::ARRAY)));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @throws \FireHub\Runtime\Exception\ArrayToStringConversionException
     * @throws \FireHub\Runtime\Exception\ResourceTypeConversionException
     * @throws \FireHub\Runtime\Exception\FailedToConvertTypeException
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    public function testSetTypeNull (mixed $value):void {

        self::assertSame(Type::NULL, Data::getType(Data::setType($value, Type::NULL)));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @throws \FireHub\Runtime\Exception\ArrayToStringConversionException
     * @throws \FireHub\Runtime\Exception\ResourceTypeConversionException
     * @throws \FireHub\Runtime\Exception\FailedToConvertTypeException
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    public function testSetTypeBool (mixed $value):void {

        self::assertSame(Type::BOOL, Data::getType(Data::setType($value, Type::BOOL)));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @throws \FireHub\Runtime\Exception\ResourceTypeConversionException
     * @throws \FireHub\Runtime\Exception\FailedToConvertTypeException
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    public function testSetTypeStringFromArray (mixed $value):void {

        $this->expectException(ArrayToStringConversionException::class);

        Data::setType($value, Type::STRING);

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     *
     * @throws \FireHub\Runtime\Exception\ArrayToStringConversionException
     * @throws \FireHub\Runtime\Exception\FailedToConvertTypeException
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    public function testSetTypeFromResource (mixed $value):void {

        $this->expectException(ResourceTypeConversionException::class);

        Data::setType($value, Type::RESOURCE);

    }

    /**
     * @since 1.0.0
     *
     * @param null|scalar|array<array-key, mixed>|object $value
     * @param string $result
     *
     * @throws \FireHub\Runtime\Exception\CannotSerializeException
     *
     * @return void
     */
    #[TestWith([['one' => 1, 'two' => 2, 'three' => 3], 'a:3:{s:3:"one";i:1;s:3:"two";i:2;s:5:"three";i:3;}'])]
    #[TestWith(['This is long string.', 's:20:"This is long string.";'])]
    public function testSerialize (null|string|int|float|bool|array|object $value, string $result):void {

        self::assertSame($result, Data::serialize($value));

    }

    /**
     * @since 1.0.0
     *
     * @param null|scalar|array<array-key, mixed>|object $value
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    public function testSerializeAnonymousClasses (null|string|int|float|bool|array|object $value):void {

        $this->expectException(CannotSerializeException::class);

        Data::serialize($value);

    }

    /**
     * @since 1.0.0
     *
     * @param null|scalar|array<array-key, mixed>|object $result
     * @param string $value
     *
     * @throws \FireHub\Runtime\Exception\CannotUnserializeException
     *
     * @return void
     */
    #[TestWith([['one' => 1, 'two' => 2, 'three' => 3], 'a:3:{s:3:"one";i:1;s:3:"two";i:2;s:5:"three";i:3;}'])]
    #[TestWith(['This is long string.', 's:20:"This is long string.";'])]
    public function testUnserialize (null|string|int|float|bool|array|object $result, string $value):void {

        self::assertSame($result, Data::unserialize($value));

    }

    /**
     * @since 1.0.0
     *
     * @param string $value
     *
     * @return void
     */
    #[TestWith(['b:0;'])]
    #[TestWith(['N;'])]
    public function testUnserializeFalse (string $value):void {

        $this->expectException(CannotUnserializeException::class);

        Data::unserialize($value);

    }

}