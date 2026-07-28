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

namespace FireHub\Tests\Runtime\Unit\System;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\System;
use FireHub\Runtime\Exception\{
    ConfigurationOptionNotFoundException, ExtensionNotFoundException, FailedToSetConfigurationOptionException,
    InvalidConfigurationQuantityException
};
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Runtime Configuration Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(System\Configuration::class)]
final class ConfigurationTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testGetPath ():void {

        self::assertIsString(System\Configuration::getPath());

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $option
     *
     * @throws \FireHub\Runtime\Exception\ConfigurationOptionNotFoundException
     *
     * @return void
     */
    #[TestWith(['post_max_size'])]
    public function testGet (string $option):void {

        self::assertIsString(System\Configuration::get($option));

    }

    /**
     * @since 1.0.0
     *
     * @param string $name
     *
     * @return void
     */
    #[TestWith(['NotValidConfigurationOption'])]
    public function testGetConfigurationOptionNotValid (string $name):void {

        $this->expectException(ConfigurationOptionNotFoundException::class);

        System\Configuration::get($name);

    }

    /**
     * @since 1.0.0
     *
     * @throws \FireHub\Runtime\Exception\ExtensionNotFoundException
     * @throws \FireHub\Runtime\Exception\ConfigurationRetrievalException
     *
     * @return void
     */
    public function testGetAll ():void {

        self::assertIsArray(System\Configuration::getAll());

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $extension
     *
     * @throws \FireHub\Runtime\Exception\ExtensionNotFoundException
     * @throws \FireHub\Runtime\Exception\ConfigurationRetrievalException
     *
     * @return void
     */
    #[TestWith(['pcre'])]
    public function testGetAllWithName (string $extension):void {

        self::assertIsArray(System\Configuration::getAll($extension));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $extension
     *
     * @throws \FireHub\Runtime\Exception\ConfigurationRetrievalException
     *
     * @return void
     */
    #[TestWith(['NotValidExtension'])]
    public function testGetAllWithNameNotValid (string $extension):void {

        $this->expectException(ExtensionNotFoundException::class);

        System\Configuration::getAll($extension);

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $option
     * @param null|scalar $value
     *
     * @throws \FireHub\Runtime\Exception\FailedToSetConfigurationOptionException
     *
     * @return void
     */
    #[TestWith(['display_errors', '0'])]
    public function testSet (string $option, null|int|float|string|bool $value):void {

        self::assertTrue(System\Configuration::set($option, $value));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $option
     * @param null|scalar $value
     *
     * @return void
     */
    #[TestWith(['test', '0'])]
    public function testSetFailed (string $option, null|int|float|string|bool $value):void {

        $this->expectException(FailedToSetConfigurationOptionException::class);

        System\Configuration::set($option, $value);

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $option
     *
     * @throws \FireHub\Runtime\Exception\ConfigurationOptionNotFoundException
     *
     * @return void
     */
    #[TestWith(['max_memory_limit'])]
    public function testRestore (string $option):void {

        self::assertIsString(System\Configuration::restore($option));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $option
     *
     * @return void
     */
    #[TestWith([''])]
    public function testRestoreWithEmptyOption (string $option):void {

        $this->expectException(ConfigurationOptionNotFoundException::class);

        System\Configuration::restore($option);

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $expected
     * @param non-empty-string $shorthand
     *
     * @throws \FireHub\Runtime\Exception\InvalidConfigurationQuantityException
     * @throws \FireHub\Runtime\Exception\InvalidPatternException
     *
     * @return void
     */
    #[TestWith([1024, '1024'])]
    #[TestWith([1073741824, '1024M'])]
    #[TestWith([524288, '512K'])]
    #[TestWith([532, '0o1024'])]
    #[TestWith([532, '01024'])]
    public function testParseQuantity (int $expected, string $shorthand):void {

        self::assertSame($expected, System\Configuration::parseQuantity($shorthand));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $shorthand
     *
     * @throws \FireHub\Runtime\Exception\InvalidPatternException
     *
     * @return void
     */
    #[TestWith(['xxx'])]
    public function testParseQuantityWithInvalidShorthand (string $shorthand):void {

        $this->expectException(InvalidConfigurationQuantityException::class);

        System\Configuration::parseQuantity($shorthand);

    }

}