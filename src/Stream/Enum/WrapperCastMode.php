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
 * ### Wrapper Cast Mode
 *
 * Defines native PHP stream constants for wrappercastmode operations.
 * @since 1.0.0
 */
enum WrapperCastMode:int {

    /**
     * ### Casts a wrapper stream for general use.
     * @since 1.0.0
     */
    case AS_STREAM = STREAM_CAST_AS_STREAM;

    /**
     * ### Casts a wrapper stream for stream selection.
     * @since 1.0.0
     */
    case FOR_SELECT = STREAM_CAST_FOR_SELECT;

}
