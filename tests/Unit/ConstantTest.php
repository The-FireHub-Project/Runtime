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
use FireHub\Runtime\Constant;
use FireHub\Runtime\Exception\{
    ConstantAlreadyDefinedException, UndefinedConstantException
};
use FireHub\Tests\Runtime\DataProviders\ConstantDataProvider;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Depends, Group, Small, TestWith
};

/**
 * ### Test PHP Runtime Constant
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Constant::class)]
final class ConstantTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $name
     * @param null|array<array-key, mixed>|scalar $value
     *
     * @return void
     */
    #[Depends('testDefine')]
    #[DataProviderExternal(ConstantDataProvider::class, 'types')]
    public function testDefined (string $name, null|array|bool|float|int|string $value):void {

        self::assertTrue( Constant::defined($name));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $name
     * @param null|array<array-key, mixed>|scalar $value
     *
     * @throws \FireHub\Runtime\Exception\ConstantAlreadyDefinedException
     * @throws \FireHub\Runtime\Exception\CannotDefineConstantException
     *
     * @return void
     */
    #[DataProviderExternal(ConstantDataProvider::class, 'types')]
    public function testDefine (string $name, null|array|bool|float|int|string $value):void {

        self::assertTrue( Constant::define($name, $value));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $name
     * @param null|array<array-key, mixed>|scalar $value
     *
     * @throws \FireHub\Runtime\Exception\CannotDefineConstantException
     *
     * @return void
     */
    #[DataProviderExternal(ConstantDataProvider::class, 'types')]
    public function testDefineAlreadyExist (string $name, null|array|bool|float|int|string $value):void {

        $this->expectException(ConstantAlreadyDefinedException::class);

        self::assertTrue( Constant::define($name, $value));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $name
     * @param null|array<array-key, mixed>|scalar $value
     *
     * @@throws \FireHub\Runtime\Exception\UndefinedConstantException
     *
     * @return void
     */
    #[Depends('testDefine')]
    #[DataProviderExternal(ConstantDataProvider::class, 'types')]
    public function testValue (string $name, null|array|bool|float|int|string $value):void {

        self::assertSame($value, Constant::value($name));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $name
     *
     * @return void
     */
    #[Depends('testDefine')]
    #[TestWith(['NotDefined'])]
    public function testValueNotFound (string $name):void {

        $this->expectException(UndefinedConstantException::class);

        Constant::value($name);

    }

}