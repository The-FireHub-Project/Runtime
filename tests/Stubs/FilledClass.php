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

namespace FireHub\Tests\Runtime\Stubs;

/**
 * ### Filled class
 * @since 1.0.0
 */
class FilledClass extends EmptyClass implements EmptyInterface {

    /**
     * @since 1.0.0
     */
    use EmptyTrait;

    /**
     * @since 1.0.0
     */
    public string $publicVar = 'foo';

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function publicMethod ():void {}

}