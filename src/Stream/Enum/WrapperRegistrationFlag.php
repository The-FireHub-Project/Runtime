<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026-present The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version >=8.1
 * @package Runtime
 */

namespace FireHub\Runtime\Stream\Enum;

/**
 * ### Wrapper Registration Flag
 *
 * Defines native PHP stream constants for wrapperregistrationflag operations.
 * @since 1.0.0
 */
enum WrapperRegistrationFlag:int {

    /**
     * ### Registers a stream wrapper without URL semantics.
     * @since 1.0.0
     */
    case NONE = 0;

    /**
     * ### Registers the wrapper as a URL-aware protocol.
     * @since 1.0.0
     */
    case IS_URL = STREAM_IS_URL;

}
