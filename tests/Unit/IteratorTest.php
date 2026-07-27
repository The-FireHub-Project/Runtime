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
use FireHub\Runtime\Iterator;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small
};
use SplFixedArray;

/**
 * ### Test PHP Runtime Iterator Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(Iterator::class)]
final class IteratorTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @var SplFixedArray
     */
    private SplFixedArray $iterator;

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @return void
     */
    public function setUp ():void {

        $this->iterator = new SplFixedArray(3);
        $this->iterator[0] = 'one';
        $this->iterator[1] = 'two';
        $this->iterator[2] = 'three';

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testToArray ():void {

        self::assertSame([0 => 'one', 1 => 'two', 2 => 'three'], Iterator::toArray($this->iterator));
        self::assertSame(['one', 'two', 'three'], Iterator::toArray($this->iterator, false));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testCount ():void {

        self::assertSame(3, Iterator::count($this->iterator));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testApply ():void {

        Iterator::apply($this->iterator, function (...$param) {
            foreach ($param as $key => $value) {
                $this->iterator[$key] = $value.'-';
            }
            return true;

        },$this->iterator->toArray());

        self::assertSame(['one-', 'two-', 'three-'], $this->iterator->toArray());

    }

}