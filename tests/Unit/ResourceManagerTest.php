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

namespace FireHub\Tests\Runtime\Unit;

use FireHub\Testing\FireHubTestCase;
use FireHub\Runtime\ResourceManager;
use FireHub\Runtime\Type\Resource;
use FireHub\Tests\Runtime\DataProviders\ResourceDataProvider;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Depends, Group, Small, TestWith
};

/**
 * ### Test PHP Runtime Resource Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('src')]
#[CoversClass(ResourceManager::class)]
final class ResourceManagerTest extends FireHubTestCase {

    /**
     * @since 1.0.0
     *
     * @param resource $resource
     *
     * @return void
     */
    #[DataProviderExternal(ResourceDataProvider::class, 'stream')]
    public function testID (mixed $resource):void {

        $id = ResourceManager::id($resource);

        self::assertIsInt($id);
        self::assertTrue($id > 0);

    }

    /**
     * @since 1.0.0
     *
     * @param resource $resource
     *
     * @return void
     */
    #[DataProviderExternal(ResourceDataProvider::class, 'stream')]
    public function testType (mixed $resource):void {

        self::assertSame(Resource::STREAM, ResourceManager::type($resource));

    }

    /**
     * @since 1.0.0
     *
     * @param null|\FireHub\Runtime\Type\Resource $type
     *
     * @return void
     */
    #[Depends('testType')]
    #[TestWith([null])]
    #[TestWith([Resource::STREAM])]
    public function testActive (?Resource $type = null):void {

        self::assertIsArray(ResourceManager::active($type));

    }

}