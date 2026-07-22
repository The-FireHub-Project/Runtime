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
use PHPUnit\Framework\Attributes\ {
    CoversClass, Depends, Group, Small, TestWith
};

/**
 * ### Test PHP Runtime Environment Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(System\Environment::class)]
final class EnvironmentTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $assignment
     *
     * @return void
     */
    #[TestWith(['FOO=BAR'])]
    public function testSetVariables (string $assignment):void {

        self::assertTrue(System\Environment::setVariable($assignment));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testGetVariables ():void {

        self::assertIsArray(System\Environment::getVariable());

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $name
     *
     * @return void
     */
    #[TestWith(['FOO'])]
    #[Depends('testSetVariables')]
    public function testGetVariablesWithName (string $name):void {

        self::assertSame('BAR', System\Environment::getVariable($name));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testScriptOwner ():void {

        self::assertIsString(System\Environment::scriptOwner());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testTempFolder ():void {

        self::assertIsString(System\Environment::tempFolder());

    }

}