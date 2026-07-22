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

namespace FireHub\Tests\Runtime\Unit\System;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\System;
use FireHub\Runtime\Exception\ExtensionNotFoundException;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small, TestWith
};

/**
 * ### Test PHP Extension Management Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(System\Extension::class)]
final class ExtensionTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param string $name
     *
     * @return void
     */
    #[TestWith(['Core'])]
    public function testHasExtension (string $name):void {

        self::assertTrue(System\Extension::hasExtension($name));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testLoadedExtensions ():void {

        self::assertIsList(System\Extension::loadedExtensions());

    }

    /**
     * @since 1.0.0
     *
     * @param string $extension
     *
     * @throws \FireHub\Runtime\Exception\ExtensionNotFoundException
     *
     * @return void
     */
    #[TestWith(['Core'])]
    public function testIsExtensionFunctions (string $extension):void {

        self::assertIsList(System\Extension::extensionFunctions($extension));

    }

    /**
     * @since 1.0.0
     *
     * @param string $extension
     *
     * @return void
     */
    #[TestWith(['NotValidExtension'])]
    public function testIsExtensionFunctionsNotValid (string $extension):void {

        $this->expectException(ExtensionNotFoundException::class);

        System\Extension::extensionFunctions($extension);

    }

}