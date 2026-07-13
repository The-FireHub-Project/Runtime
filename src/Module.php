<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=7.0
 * @package Runtime
 */

namespace FireHub\Runtime;

use FireHub\Core\Boundary\Lifecycle\NonInstantiable;

/**
 * ### Base Abstraction for FireHub Runtime Layer
 *
 * The Module class serves as the base abstraction for all FireHub Runtime components.
 *
 * It enforces a unified structure for stateless, non-instantiable utility modules that wrap native PHP functionality
 * into consistent runtime APIs.
 *
 * This base ensures architectural consistency across the Runtime layer and prevents instantiation while maintaining
 * a clear separation between execution-level utilities and higher-level framework layers.
 *
 * It contains no domain logic and acts purely as a structural contract for all runtime modules.
 * @since 1.0.0
 */
abstract class Module {

    /**
     * ### Prevent instantiation of this class
     * @since 1.0.0
     */
    use NonInstantiable;

}